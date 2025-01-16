<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;
use Dompdf\Dompdf;
use Dompdf\Options;
include_once APPPATH. 'Controllers/CommonController.php';
class PaymentController extends BaseController
{
    public function __construct()
    {
        $this->curl = \Config\Services::curlrequest();
        $this->encryption = \Config\Services::encrypter();
        $this->email = \Config\Services::email();
        $this->order = new \App\Models\Orders();
        $this->package = new \App\Models\Packages();
        $this->paymentLog = new \App\Models\PaymentLog();
        $this->CosmoLinkPay = new \App\Models\CosmoLinkPay();
        $this->verifyOrder = new \App\Controllers\OrderController();
        $this->app = new \App\Controllers\AppController();
    }

    private function checkAddonGateway($gateway)
    {
        $addonStatus = $this->app->checkAddon([$gateway.'_gateway']);
        if ($addonStatus[$gateway.'_gateway'] == 'Active') {
            $siteAdminToken = (new \App\Controllers\HomeController())->siteAdminToken();
            if ($siteAdminToken[$gateway] == 'active') {
                return true;
            }
        }
        return false;
    }

    // @ioncube.dk dynamicHash("pnNGiZrOrIVEJttE", "0TxVF6NKl14jepJM") -> "25111980c9f3de137c551c0696a646c3f521693fab44226a0aaf4388d178b22b"
    public function payment()
    {
        $token = $this->request->getGet('token');
        $this->app->checkLicense();
        $tokenData = json_decode($this->encryption->decrypt(base64_decode($token)), true);
        $orderData = $this->order->where('txn_id', $tokenData['txn_id'])->first();
        $orderData['tokenData'] = $tokenData;
        $orderData['packageDetails'] = $this->package->find($orderData['package_id']);

        $paymentData = ['status' => 'failed', 'data' => null];

        if ($orderData['gateway'] == 'razorpay') {
            $paymentData = $this->razorpay($orderData);
        }
        if ($orderData['gateway'] == 'cosmofeed') {
            if ($this->checkAddonGateway('cosmofeed')) {
                $paymentData = $this->cosmofeed($orderData, $token);
            }
        }
        if ($orderData['gateway'] == 'phonepe') {
            $paymentData = $this->phonepe($orderData);
        }
        if ($orderData['gateway'] == 'upi_qr') {
            $paymentData = $this->upiqr($orderData);
        }
        if ($paymentData['status'] == 'failed') {
            return redirect()->to(base_url('order-failed'));
        }
        return view('site/payment', ['title' => 'Payment', 'paymentData' => $paymentData, 'orderData' => $orderData, 'tokenData' => $tokenData]);
    }

    // @ioncube.dk dynamicHash("DSLU6Wl5PB4IWcVI", "KXWvD2SXDhjwMUIo") -> "b0f301842c27e14a1e3805c4f1836afdfe7a506bf3c7c51fc68b4e85271451c4"
    private function gatewayCredentials() 
    {
        $filePath = file_get_contents(WRITEPATH . 'static/gateWays.json');
        $decoded = json_decode($filePath, true);
        return $decoded['gateways'];
    }

    // @ioncube.dk dynamicHash("J050L9DtZbb4Qfy5", "LaAY3suNsE8xBRov") -> "b9e957f4944a4b27dcec95710a908bd50eec9cbba4cf7897c8f2eabc50aa9437"
    private function getGatewayData($gatewayName)
    {
        $gateways = $this->gatewayCredentials();
        foreach ($gateways as $gateway) {
            if ($gateway['gateway'] === $gatewayName) {
                return $gateway['data'];
            }
        }
        return null;
    }

    public function razorpay($data)
    {
        $rzpData = $this->getGatewayData('razorpay');
        if ($rzpData['razorpay_status'] == 'LIVE') {
            $rzpPayUrl = "https://api.razorpay.com/v1/orders";
        } else {
            $rzpPayUrl = "https://api.razorpay.com/v1/orders";
        }
        $auth = base64_encode("$rzpData[merchant_key]:$rzpData[merchant_salt]");
        $payLoad = array(
            'amount' => $data['amount'] * 100,
            'currency' => "INR",
            'receipt' => $data['txn_id'],
            'notes' => array(
                "txn_id" => $data['txn_id'],
                "product_id" => $data['package_id'],
                "user_email" => $data['tokenData']['email'],
            )
        );
        $response = $this->curl->request('POST', $rzpPayUrl, [
            'json' => $payLoad,
            'headers' => [
                'authorization' => 'Basic ' . $auth,
                'Content-Type' => 'application/json'
            ]
        ]);
        $responseBody = json_decode($response->getBody(), true);
        if (isset($responseBody['id'])) {
            if ($orderData = $this->order->where('txn_id', $responseBody['receipt'])->first()) {
                $responseBody['rzp_key'] = $rzpData['merchant_key'];
                $responseBody['userData'] = $data['tokenData'];
                return ['status' => 'success', 'data' => $responseBody];
            }
        }
        return ['status' => 'failed', 'data' => null];
    }

    // @ioncube.dk dynamicHash("80lICbLK22tXbTYE", "bSeCujOLPh78OdX6") -> "3c49244dffb1c186b3250e62a45f945e20bd1a50fa96d87a51c934c074d57623"
    public function phonepe($data)
    {
        $phonepeData = $this->getGatewayData('phonepe');
        if ($phonepeData['phonepe_status'] == 'LIVE') {
            $phonepePayUrl = "https://api.phonepe.com/apis/hermes/pg/v1/pay";
            $callbackUrl = base_url('callback/phonepe');
        } else {
            $phonepePayUrl = "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/pay";
            $callbackUrl = "https://webhook.site/41005685-40b0-4c34-b244-5e3a5f2cde89";
        }
        $payLoad = array(
            'merchantId' => $phonepeData['merchant_id'],
            'merchantTransactionId' => $data['txn_id'],
            "merchantUserId" => uniqid(),
            'amount' => $data['amount'] * 100,
            'redirectMode' => "POST",
            'redirectUrl' => base_url('order-success?txn=' . $data['txn_id']),
            'callbackUrl' => $callbackUrl,
            "paymentInstrument" => array(
                "type" => "PAY_PAGE",
            )
        );
        $payLoad = base64_encode(json_encode($payLoad));
        $checksum = hash('sha256', $payLoad . "/pg/v1/pay" . $phonepeData['merchant_salt']) . "###" . $phonepeData['merchant_index'];
        $response = $this->curl->request('POST', $phonepePayUrl, [
            'json' => ['request' => $payLoad],
            'headers' => [
                'Content-Type' => 'application/json',
                'X-VERIFY' => $checksum
            ]
        ]);
        $responseBody = json_decode($response->getBody(), true);
        if (isset($responseBody['code']) && $responseBody['code'] == 'PAYMENT_INITIATED') {
            if  ($orderData = $this->order->where('txn_id', $responseBody['data']['merchantTransactionId'])->first()) {
                return ['status' => 'success', 'data' => $responseBody];
            }
        }
        return ['status' => 'failed', 'data' => null];
    }

    // @ioncube.dk dynamicHash("wFCvQ7eNh6eif3Vu", "EUIMWD7cMObvF2p2") -> "fc7900837e61a9e29938d98564c9dd3f2434e97c1ab27ec50f592175fc70cdba"
    public function cosmofeed($data, $token)
    {
        $paymentLink = $this->CosmoLinkPay->where('package_id', $data['package_id'])->first();
        if ($paymentLink) {
            $hash = hash('sha256', $data['amount'] . $data['txn_id']);
            $finalHash = hash('sha256', $hash . $token);
            $tokenData = [
                'txn_id' => $data['txn_id'],
                'hash' => $finalHash
            ];
            $cosmoToken = $this->encryption->encrypt(json_encode($tokenData));
            $cosmoToken = base64_encode($cosmoToken);
            $data['temp_token'] = json_decode($this->encryption->decrypt(base64_decode($token)), true);
            $payUrl = $paymentLink['link'] . '?phone=' . $data['temp_token']['phone'] . '&email=' . $data['temp_token']['email'] . '&token=' . $cosmoToken;
            return ['status' => 'success', 'data' => $payUrl];
        }
        return ['status' => 'failed', 'data' => null];
    }

    // @ioncube.dk dynamicHash("uhwMWwzNx7KuS0d0", "gKVb5FQ8K7OVlXR0") -> "b5f75a97c8611d915589fa641ece723f9219640c0e5a0beaf80e68e53448d773"
    public function upiqr($data)
    {
        $upiId = (new \App\Controllers\HomeController())->siteAdminToken()['upi_id'];
        $upiData = 'upi://pay?pa=' . $upiId . '&cu=INR&am=' . $data['amount'] . '';
        $upiQr = '<img id="qrCodeImage" style="width:100%;" src="' . (new QRCode)->render($upiData) . '" alt="QR Code" />';
        if ($upiQr) {
            return ['status' => 'success', 'data' => ['upi_id' => $upiId, 'qrcode' => $upiQr]];
        }
        return ['status' => 'failed', 'data' => null];
    }

    // @ioncube.dk dynamicHash("QFk3He3YFS85gCEb", "wZLbEFjT6S7VpbH0") -> "e731b4a9db453afdf060b5335aadc17211cf9501ee0bfe9764fa8933055d7a68"
    public function walletVerify()
    {
        if ($this->request->getMethod() == 'POST') {
            $post = $this->request->getPost();
            if (!$post['ref_code'] || !$post['txn_id']) {
                return $this->response->setJSON(['status' => 'failed', 'message' => 'Some fields are missing']);
            }
            $refUser = (new \App\Models\Users())->where('ref_code', $post['ref_code'])->first();
            if (!$refUser) {
                return $this->response->setJSON(['status' => 'failed', 'message' => 'Invalid Referral Code']);
            }
            $orderData = $this->order->where('txn_id', $post['txn_id'])->first();
            if ($orderData['amount'] > $refUser['wallet']) {
                return $this->response->setJSON(['status' => 'failed', 'message' => 'Insufficient Balance']);
            }
            $otp = random_string('alnum', 4) . $refUser['id'] . random_string('alnum', 4);
            $walletOtp = (new \App\Models\WalletOtp())->insert([
                'user_id' => $refUser['id'],
                'for' => 'order',
                'txn_id' => $orderData['txn_id'],
                'otp' => $otp,
                'amount' => $orderData['amount']
            ]);
            $subject = 'Wallet Payment Request - ' . env('app.name');
            $this->email->setFrom(env('email.fromEmail'), env('email.fromName'));
            $this->email->setTo($refUser['email']);
            $this->email->setSubject($subject);
            $this->email->setMessage('Hello ' . $refUser['name'] . ',<br><br> Someone has requested for wallet payment of Rs. ' . $orderData['amount'] . ' for order ' . $orderData['txn_id'] . '.<br><br> Verification Code: ' . $otp . '<br><br> Regards,<br> ' . env('app.name'));
            if ($walletOtp && $this->email->send()) {
                return $this->response->setJSON(['status' => 'success', 'message' => 'Verification code has been sent to the given referral user email.', 'otp' => $otp]);
            }
            return $this->response->setJSON(['status' => 'failed', 'message' => 'Something went wrong. Please contact support.']);
        }
        return ['status' => 'failed', 'data' => null];
    }

    // -------------------------------
    // Order Failed and Success Views
    // -------------------------------

    public function orderFailed()
    {
        $data['title'] = 'Order Failed';
        return view('site/orderFailed', $data);    
    }

    public function orderSuccess()
    {
        $data['title'] = 'Order Success';
        return view('site/orderSuccess', $data);    
    }

    // -------------------------------
    // Gateway Callback Functions
    // -------------------------------

    // @ioncube.dk dynamicHash("e52wBtxpFO7YHyaQ", "7duZMUbfmPRJAYxF") -> "21e7155df64c4314d77a3dcf3e0926e82db682651db2d9b902fe85efa7d6bca4"
    public function phonepeCallback()
    {
        $phonepeData = $this->getGatewayData('phonepe');
        $data = json_decode(file_get_contents('php://input'), true);
        $data = json_decode(base64_decode($data['response']), true);
        $checksum = hash('sha256', '/pg/v1/status/' . $phonepeData['merchant_id'] . '/' . $data['data']['merchantTransactionId'] . $phonepeData['merchant_salt']) . '###' . $phonepeData['merchant_index'];
        if ($phonepeData['phonepe_status'] == 'LIVE') {
            $url = "https://api.phonepe.com/apis/hermes/pg/v1/status";
        } else {
            $url = "https://api-preprod.phonepe.com/apis/pg-sandbox/pg/v1/status";
        }
        $response = $this->curl->request('GET', $url . '/' . $phonepeData['merchant_id'] . '/' . $data['data']['merchantTransactionId'], [
            'headers' => [
                'Accept' => 'application/json',
                'X-MERCHANT-ID' => $phonepeData['merchant_id'],
                'X-VERIFY' => $checksum
            ]
        ]);
        $responseBody = json_decode($response->getBody(), true);
        if (isset($responseBody['code'])) {
            if ($responseBody['code'] == 'PAYMENT_SUCCESS') {
                $this->paymentLog->insert([
                    'gateway' => 'phonepe',
                    'data' => json_encode($responseBody)
                ]);
                $this->verifyOrder->verifyOrder($responseBody['data']['merchantTransactionId']);
                return ['status' => 'success', 'data' => $responseBody['data']['merchantTransactionId']];
            }
        }
        return ['status' => 'failed', 'data' => null];
    }

    // @ioncube.dk dynamicHash("Qh3jgxidVFe22UDF", "6Ot82f9v5cGgtyVL") -> "acc8b758ec9797316c4f357eff37a25ed10d550a2904aaae84e731fb83cea98c"
    public function upiCallback()
    {
        $data = $this->request->getPost();
        $rules = [
            'txn_id' => 'required',
            'payment_ref' => 'required',
            'payment_screenshot' => [
                'label' => 'Image File',
                'rules' => [
                    'uploaded[payment_screenshot]',
                    'is_image[payment_screenshot]',
                    'mime_in[payment_screenshot,image/jpg,image/jpeg,image/png,image/heic]',
                    'max_size[payment_screenshot,5120]',
                ],
            ],
        ];
        if (!$this->validate($rules)) {
            return redirect()->back()->withInput()->with('errors', $this->validator->getErrors());
        }
        $file = $this->request->getFile('payment_screenshot');
        if ($file->isValid() && !$file->hasMoved()) {
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/others', $newName);
            $data['payment_screenshot'] = $newName;
        }
        $this->paymentLog->insert([
            'gateway' => 'upi',
            'data' => json_encode($data)
        ]);
        $this->order->where('txn_id', $data['txn_id'])->set($data)->update();
        return redirect()->to(base_url('order-success?txn=' . $data['txn_id']));
    }

    // @ioncube.dk dynamicHash("I75WfqdDc1iJDgSt", "e3UsdLru69uturfq") -> "d5e1c232c209001c40775e58d1a06fd0040a13dc4d1d9bd5e7a53d58d37927ed"
    public function cosmoCallback()
    {
        if (!$this->checkAddonGateway('cosmofeed')) {
            return ['status' => 'failed', 'data' => null];
        }
        $data = json_decode(file_get_contents('php://input'), true);
        $this->paymentLog->insert([
            'gateway' => 'cosmofeed',
            'data' => json_encode($data)
        ]);
        if ($data['status'] === 'paid'){
            $token = $this->encryption->decrypt(base64_decode($data['token']));
            $tokenData = json_decode($token, true);
            $orderData = $this->order->where('txn_id', $tokenData['txn_id'])->first();
            $hash1 = hash('sha256', $data['amount'] . $tokenData['txn_id']);
            $hash2 = hash('sha256', $hash1 . $orderData['temp_token']);
            if ($hash2 == $tokenData['hash']) {
                $this->verifyOrder->verifyOrder($tokenData['txn_id']);
                return ['status' => 'success', 'data' => $tokenData['txn_id']];
            }
        }
        return ['status' => 'failed', 'data' => null];
    }

    // @ioncube.dk dynamicHash("HyvOJX9rBvz216ss", "xt0X8ZcTbO0zTnZS") -> "e94f7746e45b5dcbeaba19d7e441542f6c105abc4b71f8fa33e71d451a60fcc1"
    public function walletCallback()
    {
        if (!$this->checkAddonGateway('wallet')) {
            return $this->response->setJSON(['status' => 'failed', 'message' => 'Something went wrong. Please contact support.']);
        }
        $data = $this->request->getPost();
        $otpData = (new \App\Models\WalletOtp())->where('otp', $data['wallet_otp'])->first();
        if (!$otpData) {
            return $this->response->setJSON(['status' => 'failed', 'message' => 'Invalid OTP']);
        }
        $data['otpData'] = $otpData;
        $this->paymentLog->insert([
            'gateway' => 'wallet',
            'data' => json_encode($data)
        ]);
        $result = (new \App\Models\WalletOtp())->update($otpData['id'], ['status' => 'used']);
        if ($result) {
            $userWallet = (new \App\Models\Users())->where('id', $otpData['user_id'])->first()['wallet'];
            if ($userWallet < $otpData['amount']) {
                return $this->response->setJSON(['status' => 'failed', 'message' => 'Insufficient wallet balance']);
            }
            if (!(new \App\Models\Users())->update($otpData['user_id'], ['wallet' => $userWallet - $otpData['amount']])) {
                return $this->response->setJSON(['status' => 'failed', 'message' => 'Something went wrong']);
            }
            if ((new \App\Controllers\HomeController())->siteAdminToken()['payout_mail_on_wallet'] == 'active') {
                $payoutEmailData = [
                    'username' => $this->user->find($otpData['user_id'])['name'],
                    'amount' => $otpData['amount']
                ];
                $subject = 'Payout Processed | ' . env('app.name');
                $template = 'emails/payout';
                $this->email->setFrom(env('email.fromEmail'), env('email.fromName'));
                $this->email->setTo($this->user->find($otpData['user_id'])['email']);
                $this->email->setSubject($subject);
                $this->email->setMessage(view($template, $payoutEmailData));
                $this->email->send();
            }
            $walletLog = (new \App\Models\WalletLog())->insert([
                'uid' => $otpData['user_id'],
                'type' => 'debit',
                'amount' => $userWallet,
                'updated_amount' => $otpData['amount'],
                'balance' => $userWallet - $otpData['amount'],
                'description' => 'Order Placed For - ' . $otpData['txn_id'] . '  Payment'
            ]);
            $this->verifyOrder->verifyOrder($otpData['txn_id']);
            return $this->response->setJSON(['status' => 'success', 'message' => 'Order Placed Successfully']);
        }
        return $this->response->setJSON(['status' => 'failed', 'message' => 'Something went wrong. Please contact support.']);
    }


    public function receiptCallback()
    {
        $data = $this->request->getJSON();
        if (!$data) {
            return $this->response->setJSON([
                'status' => 'failed',
                'message' => 'Something went wrong. Please contact support.1'
            ]);
        }
        $orderData = $this->order->where('txn_id', $data->txn_id)->first();
        $packageName = $this->package->where('id', $orderData['package_id'])->first()['name'];
        $customerData = json_decode($this->encryption->decrypt(base64_decode($orderData['temp_token'])), true);
        if (!$orderData) {
            return $this->response->setJSON([
                'status' => 'failed',
                'message' => 'Order not found. Please contact support.'
            ]);
        }
        $receiptHtml = view('receipt_template', ['orderData' => $orderData, 'packageName' => $packageName, 'customerData' => $customerData]);
        $options = new Options();
        $options->set('isRemoteEnabled', true);
        $dompdf = new Dompdf($options);
        $dompdf->loadHtml($receiptHtml);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();
        $output = $dompdf->output();
        
        return $this->response->setJSON([
            'status' => 'success',
            'pdf_data' => base64_encode($output),
            'file_name' => env('app.name') . ' - ' . $data->txn_id . '.pdf'
        ]);
    }

    public function razorpayCallback()
    {
        $razorpayOrderId = $this->request->getPost('razorpay_order_id');
        $razorpayPaymentId = $this->request->getPost('razorpay_payment_id');
        $razorpaySignature = $this->request->getPost('razorpay_signature');
        $merchantOrderId = $this->request->getPost('merchant_order_id');

        $rzpData = $this->getGatewayData('razorpay');
        $auth = base64_encode("$rzpData[merchant_key]:$rzpData[merchant_salt]");

        $response = $this->curl->request('GET', "https://api.razorpay.com/v1/orders/$razorpayOrderId", [
            'headers' => [
                'authorization' => 'Basic ' . $auth
            ]
        ]);
        $responseBody = json_decode($response->getBody(), true);

        $this->paymentLog->insert([
            'gateway' => 'razorpay',
            'data' => json_encode($responseBody)
        ]);
        if ($responseBody['status'] === 'paid') {
            $this->verifyOrder->verifyOrder($responseBody['receipt']);
            return redirect()->to(base_url('order-success?txn=' . $responseBody['receipt']));
        }
        return redirect()->to(base_url('order-failed?txn=' . $responseBody['receipt']));
    }
    
}
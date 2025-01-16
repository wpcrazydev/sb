<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?= $title . ' | ' . env('APP_NAME') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #061839;
            margin: 0;
            padding: 0;
        }
        .payment-container {
            width: 30%;
            margin: 3rem auto;
            padding: 2rem;
            text-align: center;
            background-color: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
            border-radius: 10px;
        }
        .header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 2rem;
        }
        .header img {
            max-width: 35%;
            height: auto;
        }
        .header p {
            font-size: 15px;
            color: #555;
            margin-bottom: 0;
        }
        .order-details {
            margin-bottom: 2rem;
            padding: 1rem;
            background: #f9f9f9;
            border-radius: 10px;
        }
        .order-details h4 {
            font-size: 18px;
            font-weight: 600;
            margin-bottom: 1rem;
            text-decoration: underline;
        }
        .order-items {
            display: flex;
            justify-content: space-between;
            margin-bottom: 0.5rem;
        }
        .order-items p {
            font-size: 15px;
            color: #000;
            margin-bottom: 0;
        }
        .payment-box {
            width: 100%;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            margin-top: 2rem;
            background-color: #fff;
            border-radius: 8px;
        }
        .payment-box button {
            font-size: 14px;
        }
        .payment-box span {
            cursor: pointer;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 0.5rem 1rem;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s;
        }
        button:hover {
            background-color: #0056b3;
        }
        .payment-steps {
            font-size: 15px;
        }
        .upi-form {
            width: 60%;
        }
        @media (max-width: 768px) {
            .payment-container {
                width: 95%;
            }
            .header img {
                max-width: 50%;
                height: auto;
            }
            .header p {
                font-size: 13px;
                color: #555;
                margin-bottom: 0;
            }
            .order-items p {
                font-size: 13px;
                color: #000;
                margin-bottom: 0;
            }
            .payment-steps {
                font-size: 13px;
            }
            .upi-form {
                width: 100%;
            }
        }
    
        .hidden {
            display: none;
        }
    </style>
</head>
<body>

    <div class="payment-container">
        <div class="header">
            <img src="<?= base_url('public/logo/' . env('dark_logo')) ?>" alt="">
            <p><i class="bi bi-shield-check"></i> Secure Payment</p>
        </div>
        <div class="order-details">
            <h4 class="text-start">Billing Details</h4>
            <div class="order-items">
                <p>Customer:</p>
                <p><?= $tokenData['name'] ?></p>
            </div>
            <div class="order-items">
                <p>Phone:</p>
                <p><?= $tokenData['phone'] ?></p>
            </div>
            <div class="order-items">
                <p>Email:</p>
                <p><?= $tokenData['email'] ?></p>
            </div>
        </div>
        <div class="order-details">
            <h4 class="text-start">Order Summary</h4>
            <div class="order-items">
                <p>TXN Id:</p>
                <p><?= $orderData['txn_id'] ?></p>
            </div>
            <div class="order-items">
                <p>Product:</p>
                <p><?= $orderData['packageDetails']['name'] ?></p>
            </div>
            <div class="order-items">
                <p>Amount:</p>
                <p>₹<?= $orderData['amount'] ?>.00/-</p>
            </div>
        </div>
        <?php if($orderData['gateway'] == 'upi_qr'): ?>
            <div class="payment-box">
                <p style="margin-bottom: 0px;"><strong>Scan QR Code to Pay</strong></p>
                <?= $paymentData['data']['qrcode'] ?>
                <span onclick="copyToClipboard('<?= $paymentData['data']['upi_id'] ?>')"><?= $paymentData['data']['upi_id'] ?> <i class="bi bi-clipboard"></i></span>
                <button onclick="downloadQRCode()" class="btn btn-outline-dark mt-3">
                    <i class="bi bi-download download-icon"></i> Download QR Code
                </button>
                <br>
                <p class="payment-steps">STEP-1 Make Payment To Qr Code or Upi</p>
                <p class="payment-steps">STEP-2 Take Screenshot and upload</p>
                <p class="payment-steps">STEP-3 And Enter payment transaction Id</p>
                <form action="<?= base_url('callback/upi') ?>" method="post" enctype="multipart/form-data" class="upi-form">
                    <?= csrf_field() ?>
                    <input type="hidden" name="txn_id" value="<?= $orderData['txn_id'] ?>">
                    <input type="file" class="form-control" name="payment_screenshot" required>
                    <br>
                    <input type="text" class="form-control" name="payment_ref" placeholder="Payment Reference" required>
                    <br>
                    <button type="submit" class="btn btn-outline-success w-100">Submit Payment</button>
                </form>
            </div>
        <?php endif; ?>
        <?php if($orderData['gateway'] == 'phonepe'): ?>
            <div class="payment-box">
                <button class="btn btn-outline-success w-100" onclick="phonepeIframe()">Pay Via PhonePe</button>
            </div>
        <?php endif; ?>
        <?php if($orderData['gateway'] == 'razorpay'): ?>
            <div class="payment-box">
                <form name="razorpay-form" id="razorpay-form" action="<?= base_url('callback/razorpay') ?>" method="POST">
                    <input type="hidden" name="merchant_order_id" id="merchant_order_id" value="<?= $orderData['txn_id'] ?>"/>
                    <script src="https://checkout.razorpay.com/v1/checkout.js"
                        data-key            = "<?= $paymentData['data']['rzp_key'] ?>"
                        data-amount         = "<?= $paymentData['data']['amount'] ?>"
                        data-currency       = "<?= $paymentData['data']['currency'] ?>"
                        data-order_id       = "<?= $paymentData['data']['id'] ?>"
                        data-description    = "<?= $orderData['packageDetails']['name'] ?>"
                        data-buttontext     = "Pay with Razorpay"
                        data-name           = "<?= env('APP_NAME') ?>"
                        data-prefill.name   = "<?= $tokenData['name'] ?>"
                        data-prefill.email  = "<?= $tokenData['email'] ?>"
                        data-prefill.contact= "<?= $tokenData['phone'] ?>"
                        data-theme.color    = "#3399cc">
                    </script>
                </form>
            </div>
        <?php endif; ?>
        <?php if($orderData['gateway'] == 'cosmofeed'): ?>
            <div class="payment-box">
                <a href="<?= $paymentData['data'] ?>" target="_blank" class="btn btn-outline-success w-100">Pay Via Cosmofeed</a>
            </div>
        <?php endif; ?>
        <?php if($orderData['gateway'] == 'wallet'): ?>
            <div class="payment-box">
                <div class="upi-form" id="wallet1">
                    <input type="hidden" id="txnId" value="<?= $orderData['txn_id'] ?>">
                    <input type="text" class="form-control" id="refCode" placeholder="Enter Referral Code" required>
                    <br>
                    <button onclick="verifyCode()" class="btn btn-outline-success w-100" id="verify-btn">Send Verification Code</button>
                    <button class="btn btn-outline-success w-100" id="loader-btn" type="button" disabled>
                        <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                        <span role="status">verifying...</span>
                    </button>
                    </div>
                    <div class="upi-form" id="wallet2">
                        <input type="text" class="form-control" id="walletOtp" placeholder="Enter Verification Code" required>
                        <br>
                        <button onclick="deductWallet()" class="btn btn-outline-success w-100" id="deduct-btn">Verify Code</button>
                        <button class="btn btn-outline-success w-100" id="deduct-loader-btn" type="button" disabled>
                            <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                            <span role="status">verifying...</span>
                        </button>
                    </div>
                </div>
            </div>
        <?php endif; ?>
        <?php if ($orderData['gateway'] == 'phonepe'): ?>
            <script src="https://mercury.phonepe.com/web/bundle/checkout.js"></script>
        <?php endif; ?>
        <?php if ($orderData['gateway'] == 'upi_qr' || $orderData['gateway'] == 'wallet'): ?>
            <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <?php endif; ?>
    </div>
<script>
    <?php if($orderData['gateway'] == 'phonepe'): ?>
        function phonepeIframe() {
            const payUrl = '<?= $paymentData['data']['data']['instrumentResponse']['redirectInfo']['url'] ?>';
            window.PhonePeCheckout.transact({ tokenUrl: payUrl, callback: phonepeIframecallback, type: "IFRAME" });
        }

        function phonepeIframecallback (response) {
            if (response === 'USER_CANCEL') {
                window.location.href = '/order-failed';
                return;
            } else if (response === 'CONCLUDED') {
                window.location.href = '/order-success?txn=<?= $orderData['txn_id'] ?>';
                return;
            }
        }
    <?php endif; ?>
    <?php if($orderData['gateway'] == 'upi_qr'): ?>
        function downloadQRCode() {
            var svgData = document.getElementById('qrCodeImage').src;
            var canvas = document.createElement('canvas');
            var ctx = canvas.getContext('2d');
            var img = new Image();
            img.onload = function () {
                var desiredWidth = 500;
                var desiredHeight = 500;
                canvas.width = desiredWidth;
                canvas.height = desiredHeight;
                ctx.drawImage(img, 0, 0, desiredWidth, desiredHeight);
                var tempLink = document.createElement('a');
                tempLink.href = canvas.toDataURL('image/png');
                tempLink.download = '<?= env('app.name') ?>_payment_qr_code.png';
                tempLink.click();
            };
            img.src = svgData;
        }

        function copyToClipboard(text) {
            var tempInput = document.createElement('input');
            tempInput.value = text;
            document.body.appendChild(tempInput);
            tempInput.select();
            document.execCommand('copy');
            document.body.removeChild(tempInput);
            Swal.fire({
                icon: 'success',
                title: 'Copied!',
                text: 'Upi id copied to clipboard! Make payment..',
                showConfirmButton: false,
                timer: 1500
            });
        }
    <?php endif; ?>
    <?php if($orderData['gateway'] == 'wallet'): ?>
        document.getElementById('wallet2').classList.add('hidden');
        document.getElementById('loader-btn').classList.add('hidden');
        function verifyCode() {
            document.getElementById('verify-btn').classList.add('hidden');
            document.getElementById('loader-btn').classList.remove('hidden');
            var txnId = document.getElementById('txnId').value;
            var refCode = document.getElementById('refCode').value;
            var formData = new FormData();
            formData.append('txn_id', txnId);
            formData.append('ref_code', refCode);
            fetch('<?= base_url('verify/wallet') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status == 'success') {
                    document.getElementById('wallet1').classList.add('hidden');
                    document.getElementById('wallet2').classList.remove('hidden');
                    document.getElementById('deduct-loader-btn').classList.add('hidden');
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 2500
                    });
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            });
        }

        function deductWallet() {
            document.getElementById('deduct-btn').classList.add('hidden');
            document.getElementById('deduct-loader-btn').classList.remove('hidden');
            var walletOtp = document.getElementById('walletOtp').value;
            var formData = new FormData();
            formData.append('wallet_otp', walletOtp);
            fetch('<?= base_url('callback/wallet') ?>', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status == 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 1500
                    });
                    setTimeout(() => {
                        window.location.href = '<?= base_url('order-success?txn=') ?><?= $orderData['txn_id'] ?>';
                    }, 1500);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: data.message,
                        showConfirmButton: false,
                        timer: 2000
                    });
                }
            });
        }
    <?php endif; ?>
</script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<?= $this->include('alert'); ?>
</body>
</html>
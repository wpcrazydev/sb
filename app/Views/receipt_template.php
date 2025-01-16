<!DOCTYPE html>
<html>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
<head>
    <style>
        body {
            font-family: Arial, sans-serif;
            line-height: 1.6;
        }
        .header h1 {
            font-size: 22px;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .details {
            width: 100%;
            border-collapse: collapse;
        }
        .details th, .details td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .details th {
            background-color: #f4f4f4;
        }
    </style>
</head>
<body>
    <div class="header">
        <h1>Purchase Receipt - <?= env('app.name') ?></h1>
        <p>Transaction ID: <?= $orderData['txn_id'] ?></p>
    </div>
    <table class="details">
        <tr>
            <td>Customer Name</td>
            <td><?= $customerData['name'] ?></td>
        </tr>
        <tr>
            <td>Customer Phone</td>
            <td><?= $customerData['phone'] ?></td>
        </tr>
        <tr>
            <td>Customer Email</td>
            <td><?= $customerData['email'] ?></td>
        </tr>
        <tr>
            <td>Product</td>
            <td><?= ucfirst($packageName) ?></td>
        </tr>
        <tr>
            <td>Amount</td>
            <td><?= $orderData['amount'] ?></td>
        </tr>
        <tr>
            <td>Date</td>
            <td><?= $orderData['created_at'] ?></td>
        </tr>
    </table>
    <p style="font-size: 13px; margin-bottom: 0px;"><strong>Note:</strong> This is an auto-generated receipt. if you have any questions or your order is approved, please contact us <a href="<?= base_url('contact') ?>">Click here</a>.</p>
</body>
</html>
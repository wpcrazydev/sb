<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Confirmation - <?= env('app.name') ?></title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; line-height: 1.6; background-color: #f6f6f6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="background-color: #ffffff; padding: 40px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <!-- Logo or Company Name -->
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="color: #333333; margin: 0;"><?= env('app.name') ?></h1>
            </div>

            <!-- Main Content -->
            <h2 style="color: #333333; margin-bottom: 20px;">Thank You for Your Purchase!</h2>
            
            <p style="color: #666666; margin-bottom: 20px;">Hello <?= $username ?>,</p>
            
            <p style="color: #666666; margin-bottom: 20px;">Your purchase has been confirmed. Here are your order details:</p>
            
            <!-- Purchase Details -->
            <div style="background-color: #f8f9fa; padding: 20px; border-radius: 4px; margin-bottom: 30px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 10px 0; border-bottom: 1px solid #dee2e6;">
                            <strong>Order Date:</strong>
                        </td>
                        <td style="padding: 10px 0; border-bottom: 1px solid #dee2e6; text-align: right;">
                            <?= date('d-m-Y') ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0; border-bottom: 1px solid #dee2e6;">
                            <strong>Product:</strong>
                        </td>
                        <td style="padding: 10px 0; border-bottom: 1px solid #dee2e6; text-align: right;">
                            <?= $productName ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0; border-bottom: 1px solid #dee2e6;">
                            <strong>Payment Method:</strong>
                        </td>
                        <td style="padding: 10px 0; border-bottom: 1px solid #dee2e6; text-align: right;">
                            <?= $paymentMethod ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0;">
                            <strong>Amount Paid:</strong>
                        </td>
                        <td style="padding: 10px 0; text-align: right; color: #28a745; font-weight: bold;">
                            <?= number_format($price, 2) ?> INR
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Access Product Section -->
            <p style="color: #666666; margin-bottom: 20px;">You can access your purchase by logging into your account:</p>
            
            <!-- Login Button -->
            <div style="text-align: center; margin-bottom: 30px;">
                <a href="<?= base_url('login') ?>" style="display: inline-block; padding: 12px 24px; background-color: #007bff; color: #ffffff; text-decoration: none; border-radius: 4px; font-weight: bold;">Access Your Account</a>
            </div>

            <p style="color: #666666; margin-bottom: 20px;">Or copy and paste this link into your browser:</p>
            <p style="color: #666666; margin-bottom: 30px; word-break: break-all;">
                <?= base_url('login') ?>
            </p>

            <hr style="border: none; border-top: 1px solid #eeeeee; margin: 30px 0;">
            
            <!-- Support Section -->
            <div style="margin-bottom: 30px;">
                <p style="color: #666666; margin-bottom: 10px;"><strong>Need Help?</strong></p>
                <p style="color: #666666; margin-bottom: 10px;">If you have any questions about your purchase or need assistance, our support team is here to help:</p>
                <ul style="color: #666666; margin: 0; padding-left: 20px;">
                    <li>Email: <?= env('app.support_email') ?></li>
                    <li>Phone: <?= env('app.support_phone') ?></li>
                </ul>
            </div>

            <!-- Footer -->
            <p style="color: #666666; margin-bottom: 0;">
                Thank you for choosing <?= env('app.name') ?>!<br>
                Best regards,<br>
                <?= env('app.name') ?> Team
            </p>
        </div>
        
        <!-- Email Footer -->
        <div style="text-align: center; margin-top: 20px;">
            <p style="color: #999999; font-size: 12px; margin-bottom: 10px;">
                This is a confirmation of your purchase. Please keep this for your records.
            </p>
            <p style="color: #999999; font-size: 12px; margin-bottom: 0;">
                © <?= date('Y') ?> <?= env('app.name') ?>. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>

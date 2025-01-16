<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payout Rejected - <?= env('app.name') ?></title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; line-height: 1.6; background-color: #f6f6f6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="background-color: #ffffff; padding: 40px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <!-- Logo or Company Name -->
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="color: #333333; margin: 0;"><?= env('app.name') ?></h1>
            </div>

            <!-- Main Content -->
            <h2 style="color: #dc3545; margin-bottom: 20px;">❌ Your Payout Has Been Rejected</h2>
            
            <p style="color: #666666; margin-bottom: 20px;">Hello <?= $username ?>,</p>
            
            <p style="color: #666666; margin-bottom: 20px;">We're sorry to inform you that your payout has been rejected.</p>
            
            <!-- Rejection Details -->
            <div style="background-color: #f8d7da; padding: 20px; border-radius: 4px; margin-bottom: 30px;">
                <p style="color: #721c24; margin: 0;">Reason for Rejection: <?= $rejectionReason ?></p>
            </div>

            <!-- Important Notice -->
            <div style="margin-bottom: 30px;">
                <p style="color: #666666; margin-bottom: 10px;"><strong>Important Information:</strong></p>
                <ul style="color: #666666; margin: 0; padding-left: 20px;">
                    <li>If you believe this is an error, please contact our support team.</li>
                    <li>We appreciate your understanding in this matter.</li>
                </ul>
            </div>

            <!-- Support Section -->
            <div style="margin-bottom: 30px;">
                <p style="color: #666666; margin-bottom: 10px;"><strong>Questions about your payout?</strong></p>
                <p style="color: #666666; margin-bottom: 10px;">If you have any questions or concerns about this payout, please contact our support team:</p>
                <ul style="color: #666666; margin: 0; padding-left: 20px;">
                    <li>Email: <?= env('app.support_email') ?></li>
                    <li>Phone: <?= env('app.support_phone') ?></li>
                    <li>Support Hours: Monday-Saturday, 10 AM - 6 PM IST</li>
                </ul>
            </div>

            <!-- Footer -->
            <p style="color: #666666; margin-bottom: 0;">
                Thank you for being part of our community!<br>
                Best regards,<br>
                <?= env('app.name') ?> Team
            </p>
        </div>
        
        <!-- Email Footer -->
        <div style="text-align: center; margin-top: 20px;">
            <p style="color: #999999; font-size: 12px; margin-bottom: 10px;">
                This is an automated payout rejection notification. Please keep it for your records.
            </p>
            <p style="color: #999999; font-size: 12px; margin-bottom: 0;">
                © <?= date('Y') ?> <?= env('app.name') ?>. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>
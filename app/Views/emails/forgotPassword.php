<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Your Password</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; line-height: 1.6; background-color: #f6f6f6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="background-color: #ffffff; padding: 40px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <!-- Logo or Company Name -->
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="color: #333333; margin: 0;"><?= env('app.name') ?></h1>
            </div>

            <!-- Main Content -->
            <h2 style="color: #333333; margin-bottom: 20px;">Password Reset Request</h2>
            
            <p style="color: #666666; margin-bottom: 20px;">Hello <?= $username ?>,</p>
            
            <p style="color: #666666; margin-bottom: 20px;">We received a request to reset your password. If you didn't make this request, you can safely ignore this email.</p>
            
            <p style="color: #666666; margin-bottom: 30px;">To reset your password, click the button below:</p>
            
            <!-- Reset Button -->
            <div style="text-align: center; margin-bottom: 30px;">
                <a href="<?= base_url($path . 'reset-password/' . $token) ?>" style="display: inline-block; padding: 12px 24px; background-color: #007bff; color: #ffffff; text-decoration: none; border-radius: 4px; font-weight: bold;">Reset Password</a>
            </div>
            
            <p style="color: #666666; margin-bottom: 20px;">Or copy and paste this link into your browser:</p>
            <p style="color: #666666; margin-bottom: 30px; word-break: break-all;">
                <?= base_url($path . 'reset-password/' . $token) ?>
            </p>
            
            <p style="color: #666666; margin-bottom: 20px;">This password reset link will expire in 15 minutes.</p>
            
            <hr style="border: none; border-top: 1px solid #eeeeee; margin: 30px 0;">
            
            <!-- Footer -->
            <p style="color: #999999; font-size: 12px; margin-bottom: 10px;">If you didn't request a password reset, please ignore this email or contact support if you have concerns.</p>
            
            <p style="color: #999999; font-size: 12px; margin-bottom: 0;">
                Best regards,<br>
                <?= env('app.name') ?> Team
            </p>
        </div>
        
        <!-- Email Footer -->
        <div style="text-align: center; margin-top: 20px;">
            <p style="color: #999999; font-size: 12px; margin-bottom: 10px;">
                This is an automated message, please do not reply to this email.
            </p>
            <p style="color: #999999; font-size: 12px; margin-bottom: 0;">
                © <?= date('Y') ?> <?= env('app.name') ?>. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>

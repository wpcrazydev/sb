<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome to <?= env('app.name') ?>!</title>
</head>

<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; line-height: 1.6; background-color: #f6f6f6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div
            style="background-color: #ffffff; padding: 40px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <!-- Logo or Company Name -->
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="color: #333333; margin: 0;"><?= env('app.name') ?></h1>
            </div>

            <!-- Main Content -->
            <h2 style="color: #333333; margin-bottom: 20px;">Welcome aboard!</h2>

            <p style="color: #666666; margin-bottom: 20px;">Hello <?= $username ?>,</p>

            <p style="color: #666666; margin-bottom: 20px;">Thank you for registering with <?= env('app.name') ?>. We're
                excited to have you join us! Here are your account details:</p>

            <!-- Account Details -->
            <div style="background-color: #f8f9fa; padding: 20px; border-radius: 4px; margin-bottom: 30px;">
                <p style="color: #666666; margin: 0 0 10px 0;"><strong>Email:</strong> <?= $email ?></p>
                <p style="color: #666666; margin: 0;"><strong>Password:</strong> <?= $password ?></p>
            </div>

            <p style="color: #666666; margin-bottom: 30px;">You can access your account by clicking the button below:
            </p>

            <!-- Login Button -->
            <div style="text-align: center; margin-bottom: 30px;">
                <a href="<?= base_url('login') ?>"
                    style="display: inline-block; padding: 12px 24px; background-color: #007bff; color: #ffffff; text-decoration: none; border-radius: 4px; font-weight: bold;">Login
                    to Your Account</a>
            </div>

            <p style="color: #666666; margin-bottom: 20px;">Or copy and paste this link into your browser:</p>
            <p style="color: #666666; margin-bottom: 30px; word-break: break-all;">
                <?= base_url('login') ?>
            </p>

            <hr style="border: none; border-top: 1px solid #eeeeee; margin: 30px 0;">

            <!-- Security Notice -->
            <div style="margin-bottom: 30px;">
                <p style="color: #666666; margin-bottom: 10px;"><strong>Important Security Tips:</strong></p>
                <ul style="color: #666666; margin: 0; padding-left: 20px;">
                    <li>Keep your login credentials secure</li>
                    <li>Never share your password with anyone</li>
                    <li>Use a strong, unique password</li>
                    <li>Log out when using shared devices</li>
                </ul>
            </div>

            <!-- Footer -->
            <p style="color: #666666; margin-bottom: 20px;">If you have any questions or need assistance, please don't
                hesitate to contact our support team.</p>

            <p style="color: #666666; margin-bottom: 0;">
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
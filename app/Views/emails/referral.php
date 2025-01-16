<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Referral Commission Earned! - <?= env('app.name') ?></title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, sans-serif; line-height: 1.6; background-color: #f6f6f6;">
    <div style="max-width: 600px; margin: 0 auto; padding: 20px;">
        <div style="background-color: #ffffff; padding: 40px; border-radius: 4px; box-shadow: 0 2px 4px rgba(0,0,0,0.1);">
            <!-- Logo or Company Name -->
            <div style="text-align: center; margin-bottom: 30px;">
                <h1 style="color: #333333; margin: 0;"><?= env('app.name') ?></h1>
            </div>

            <!-- Main Content -->
            <h2 style="color: #28a745; margin-bottom: 20px;">🎉 Congratulations! You've Earned a Commission!</h2>
            
            <p style="color: #666666; margin-bottom: 20px;">Hello <?= $username ?>,</p>
            
            <p style="color: #666666; margin-bottom: 20px;">Great news! You've earned a referral commission from your referral or team member. Here are the details:</p>
            
            <!-- Commission Details -->
            <div style="background-color: #f8f9fa; padding: 20px; border-radius: 4px; margin-bottom: 30px;">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td style="padding: 10px 0; border-bottom: 1px solid #dee2e6;">
                            <strong>Referral From:</strong>
                        </td>
                        <td style="padding: 10px 0; border-bottom: 1px solid #dee2e6; text-align: right;">
                            <?= $referralName ?>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0; border-bottom: 1px solid #dee2e6;">
                            <strong>Commission Amount:</strong>
                        </td>
                        <td style="padding: 10px 0; border-bottom: 1px solid #dee2e6; text-align: right; color: #28a745; font-weight: bold;">
                            <?= number_format($amount, 2) ?> INR
                        </td>
                    </tr>
                    <tr>
                        <td style="padding: 10px 0;">
                            <strong>Date Earned:</strong>
                        </td>
                        <td style="padding: 10px 0; text-align: right;">
                            <?= date('d-m-Y') ?>
                        </td>
                    </tr>
                </table>
            </div>

            <!-- Stats Summary -->
            <div style="background-color: #e8f5e9; padding: 20px; border-radius: 4px; margin-bottom: 30px; text-align: center;">
                <p style="color: #2e7d32; margin: 0; font-size: 18px; font-weight: bold;">
                    Keep up the great work! 🌟
                </p>
            </div>

            <!-- View Details Button -->
            <div style="text-align: center; margin-bottom: 30px;">
                <a href="<?= base_url('login') ?>" style="display: inline-block; padding: 12px 24px; background-color: #007bff; color: #ffffff; text-decoration: none; border-radius: 4px; font-weight: bold;">View Your Dashboard</a>
            </div>

            <p style="color: #666666; margin-bottom: 20px;">Or copy and paste this link into your browser:</p>
            <p style="color: #666666; margin-bottom: 30px; word-break: break-all;">
                <?= base_url('login') ?>
            </p>

            <hr style="border: none; border-top: 1px solid #eeeeee; margin: 30px 0;">
            
            <!-- Tips Section -->
            <div style="margin-bottom: 30px;">
                <p style="color: #666666; margin-bottom: 10px;"><strong>Tips to Increase Your Earnings:</strong></p>
                <ul style="color: #666666; margin: 0; padding-left: 20px;">
                    <li>Create content and share it with your audience</li>
                    <li>Share your referral link on social media</li>
                    <li>Tell your friends about our platform</li>
                    <li>Engage with your referrals to encourage activity</li>
                </ul>
            </div>

            <!-- Footer -->
            <p style="color: #666666; margin-bottom: 0;">
                Keep growing your network!<br>
                Best regards,<br>
                <?= env('app.name') ?> Team
            </p>
        </div>
        
        <!-- Email Footer -->
        <div style="text-align: center; margin-top: 20px;">
            <p style="color: #999999; font-size: 12px; margin-bottom: 10px;">
                This is an automated notification. Please do not reply to this email.
            </p>
            <p style="color: #999999; font-size: 12px; margin-bottom: 0;">
                © <?= date('Y') ?> <?= env('app.name') ?>. All rights reserved.
            </p>
        </div>
    </div>
</body>
</html>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title>License Error</title>
    <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f5f5f5;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    .error-container {
        background-color: white;
        padding: 2rem;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        max-width: 600px;
        width: 90%;
        text-align: center;
    }

    .error-icon {
        color: #dc3545;
        font-size: 4rem;
        margin-bottom: 1rem;
    }

    h1 {
        color: #333;
        margin-bottom: 1rem;
    }

    p {
        color: #666;
        line-height: 1.6;
        margin-bottom: 1.5rem;
    }

    .btn {
        display: inline-block;
        padding: 0.8rem 1.5rem;
        background-color: #007bff;
        color: white;
        text-decoration: none;
        border-radius: 4px;
        transition: background-color 0.3s;
        margin-bottom: 1rem;
    }

    .btn:hover {
        background-color: #0056b3;
    }
    </style>
</head>

<body>
    <div class="error-container">
        <div class="error-icon">⚠️</div>
        <h1>License Error</h1>
        <p>We're sorry, but there seems to be an issue with your license. This could be due to an expired license or
            invalid license key.</p>
        <p>Please verify your license status or contact support for assistance.</p>
        <?php if (env('CI_ENVIRONMENT') == 'development' && $bizCheckResult['status'] !== 'Active') : ?>
            <p><strong>Status:</strong> <?= ($bizCheckResult['status']); ?></p>
            <?php if (isset($bizCheckResult['description'])) : ?>
                <p><strong>Error:</strong> <?= ($bizCheckResult['description']); ?></p>
            <?php endif; ?>
        <?php endif; ?>
        <a href="/" class="btn">Contact Support</a>
        <br>
        <a href="/" style="color: #007bff; text-decoration: none; font-size: 0.9rem;">Refresh</a>
    </div>
    <?php if ($bizCheckResult['status'] == 'Active') : ?>
    <script>
        window.location.href = '/';
    </script>
    <?php endif; ?>
</body>
</html>
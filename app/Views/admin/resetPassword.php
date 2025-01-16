<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Reset Password | <?= env('app.name') ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 30px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1), 0 1px 3px rgba(0,0,0,0.08);
            border-radius: 12px;
            background: linear-gradient(to bottom right, #ffffff, #f8f9fa);
        }
        .form-control {
            border-radius: 8px;
            padding: 12px;
            border: 1px solid #e2e8f0;
            transition: all 0.3s ease;
        }
        .form-control:focus {
            border-color: #4299e1;
            box-shadow: 0 0 0 3px rgba(66, 153, 225, 0.15);
        }
        .btn-primary {
            padding: 12px;
            border-radius: 8px;
            font-weight: 500;
            background: linear-gradient(to right, #4299e1, #667eea);
            border: none;
            transition: transform 0.2s ease;
        }
        .btn-primary:hover {
            transform: translateY(-1px);
            background: linear-gradient(to right, #3182ce, #5a67d8);
        }
        .alert {
            border-radius: 8px;
            border: none;
        }

        .title {
            font-weight: 500;
            font-family: 'Poppins', sans-serif;
            font-size: 1.2rem;
            text-decoration: underline;
        }
    </style>
</head>
<body class="bg-light" style="background: linear-gradient(135deg, #f6f9fc 0%, #f1f4f8 100%);">
    <div class="container">
        <div class="login-container bg-white">
            <h4 class="text-left mb-4 title">Admin Reset Password</h4>
            <form action="<?= base_url(env('app.adminURL') . '/reset-password/' . $token) ?>" method="POST">
                <?= csrf_field() ?>
                <input type="hidden" name="token" value="<?= esc($token) ?>">
                <div class="mb-3">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="password" name="password" required>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary">Reset Password</button>
                </div>
            </form>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?= $this->include('alert') ?>
</body>
</html>
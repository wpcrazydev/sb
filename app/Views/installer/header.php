<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?= $data->title ?? 'Biz Installer' ?> | <?= env('app.name') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.5.0/font/bootstrap-icons.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:ital,opsz,wght@0,14..32,100..900;1,14..32,100..900&display=swap"
        rel="stylesheet">


    <style>
    * {
        font-family: "Inter", serif;
    }

    body {
        background: linear-gradient(135deg, #0f172a, #1e293b);
    }

    h1 {
        font-size: 2.5rem;
    }

    .btn {
        border: none;
    }

    .biz-btn {
        color: #fff;
        background-color: #4e4feb;
    }

    .biz-btn:hover {
        color: #fff;
        background-color: #3e3edb;
    }

    @media (max-width: 768px) {
        h1 {
            font-size: 1.5rem !important;
        }

        p {
            font-size: 14px !important;
        }
    }

    .biz-text {
        font-size: 20px !important;
        font-weight: 600;
    }

    @media (max-width: 768px) {
        .biz-text {
            font-size: 18px !important;
        }
    }

    .biz-link {
        font-size: 14px !important;
        font-weight: 400;
    }

    @media (max-width: 768px) {
        .biz-link {
            font-size: 12px !important;
        }
    }

    .biz-input {
        width: 40%;
    }

    @media (max-width: 768px) {
        .biz-input {
            width: 100%;
        }
    }

    .biz-box {
        width: 45%;
        border-radius: 10px;
        padding: 20px;
        background-color: #fff;
    }

    @media (max-width: 768px) {
        .biz-box {
            width: 100%;
        }
    }

    .box-content {
        max-height: 40vh;
        overflow-y: auto;
    }

    .box-footer {
        display: flex;
        justify-content: space-between;
        margin-top: 10px;
    }

    .container {
        border-radius: 10px;
        padding: 10px;
        height: 70vh;
        margin: 15px;
    }

    /* form {
        width: 45%;
        border: 1px solid #ccc;
        border-radius: 10px;
        padding: 20px;
        background-color: #fff;
    } */

    /* form h4 {
        font-size: 17px !important;
    } */

    /* @media (max-width: 768px) {
        form {
            width: 100%;
        }

        form h4 {
            font-size: 15px !important;
        }
    } */

    .biz-box-header img {
        width: 30%;
    }

    .biz-box-header h3 {
        font-size: 18px !important;
    }
    
    @media (max-width: 768px) {
        .biz-box-header h3 {
            font-size: 16px !important;
            margin-bottom: 0px !important;
        }

        .biz-box-header img {
            width: 45%;
        }

        #finalMessage {
            text-align: center !important;
        }
    }

    #celebrationEffect {
        font-size: 3rem;
        animation: spin 1s infinite;
    }

    @keyframes spin {
        0% {
            transform: rotate(0deg);
        }

        100% {
            transform: rotate(360deg);
        }
    }

    .celebration {
        animation: bounce 1.5s infinite;
    }

    @keyframes bounce {
        0% {
            transform: scale(1);
        }

        50% {
            transform: scale(1.2);
        }

        100% {
            transform: scale(1);
        }
    }
    </style>
</head>

<body>
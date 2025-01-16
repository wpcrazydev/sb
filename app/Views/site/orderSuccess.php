<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex, nofollow">
    <title><?= $title . ' | ' . env('app.name') ?></title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #061839;
        }
        ._failed{ border-bottom: solid 4px red !important; }
        ._failed i{  color:red !important;  }
        ._success {
            background-color: #fff;
            box-shadow: 0 15px 25px #00000019;
            padding: 45px;
            width: 100%;
            text-align: center;
            margin: 40px auto;
            border-bottom: solid 4px #28a745;
        }

        ._success i {
            font-size: 55px;
            color: #28a745;
        }

        ._success h2 {
            margin-bottom: 12px;
            font-size: 40px;
            font-weight: 500;
            line-height: 1.2;
            margin-top: 10px;
        }

        ._success p {
            margin-bottom: 0px;
            font-size: 18px;
            color: #495057;
            font-weight: 500;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="message-box _success">
                <i class="bi bi-check-circle-fill"></i>
                <h2> Success! </h2>
                <p> We recieved your payment! You will receive a confirmation email shortly. </p>  
                <br> 
                <div class="d-flex justify-content-center align-items-center gap-2">
                    <?php if (session()->has('uid') && session()->get('role') == 'user'): ?>
                    <a href="<?= base_url('user/dashboard') ?>"><button class="btn btn-outline-dark" style="font-size: 15px; font-weight: 500"><i class="bi bi-outbox" style="font-size: 16px; font-weight: 500"></i> Dashboard</button></a>
                    <?php else: ?>
                    <a href="<?= base_url() ?>"><button class="btn btn-outline-dark" style="font-size: 15px; font-weight: 500"><i class="bi bi-outbox" style="font-size: 16px; font-weight: 500"></i> Go Back</button></a>
                    <?php endif; ?>
                    <!-- <a href="#"><button class="btn btn-outline-dark" id="downloadBtn" onClick="getReceipt()" style="font-size: 14px; font-weight: 500"><i class="bi bi-download" style="font-size: 16px; font-weight: 500"></i> Get Receipt</button></a> -->
                    <button class="btn btn-success" type="button" id="downloadingBtn" style="display: none" disabled>
                        <span class="spinner-border spinner-border-sm" aria-hidden="true"></span>
                        <span role="status">Downloading...</span>
                    </button>
                </div>
            </div> 
        </div> 
    </div> 
</div> 
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script> 
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.4.0/dist/confetti.browser.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    window.onload = function() {
        confetti({
            particleCount: 200,
            spread: 70,
            origin: { y: 0.6 }
        });
    };

    function getReceipt() {
        const downloadBtn = document.getElementById('downloadBtn');
        const downloadingBtn = document.getElementById('downloadingBtn');
        const queryParams = new URLSearchParams(window.location.search);
        downloadBtn.style.display = 'none';
        downloadingBtn.style.display = 'block';
        fetch('<?= base_url('callback/receipt') ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '<?= csrf_token() ?>'
            },
            body: JSON.stringify({
                txn_id: queryParams.get('txn')
            })
        })
        .then(response => {
            if (!response.ok) {
                swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to download receipt'
                });
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                setTimeout(() => {
                    downloadingBtn.style.display = 'none';
                    downloadBtn.style.display = 'block';
                    const byteCharacters = atob(data.pdf_data);
                    const byteNumbers = new Array(byteCharacters.length);
                    for (let i = 0; i < byteCharacters.length; i++) {
                        byteNumbers[i] = byteCharacters.charCodeAt(i);
                    }
                    const byteArray = new Uint8Array(byteNumbers);
                    const blob = new Blob([byteArray], { type: 'application/pdf' });
                    const url = window.URL.createObjectURL(blob);
                    const a = document.createElement('a');
                    a.href = url;
                    a.download = data.file_name;
                    document.body.appendChild(a);
                    a.click();
                    window.URL.revokeObjectURL(url);
                    document.body.removeChild(a);
                    swal.fire({
                        icon: 'success',
                        title: 'Success',
                        text: 'Receipt downloaded successfully'
                    });
                }, 3000);
            } else {
                console.log(data);
                downloadingBtn.style.display = 'none';
                downloadBtn.style.display = 'block';
                swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: data.message || 'Failed to download receipt'
                });
            }
        })
        .catch(error => {
            console.error(error);
            downloadingBtn.style.display = 'none';
            downloadBtn.style.display = 'block';
            swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Failed to download receipt'
            });
        });
    }
</script>
</body>
</html>
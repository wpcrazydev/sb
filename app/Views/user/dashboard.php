<?= $this->include('user/header') ?>
<?= $this->include('alert') ?>
<style>
    .counter {
        color: #fff;
        font-size: 30px !important;
    }
    
    .dash2Counter {
        font-size: 24px !important;
    }

    #referralChart {
        width: 100% !important;
        height: 350px !important;
        margin: 20px auto;
    }

    @media (max-width: 767px) {
        #referralChart {
            width: 100% !important;
            height: 280px !important;
        }
    }

    .profile-bg {
        position: relative;
        overflow: hidden;
        border-radius: 5px;
        z-index: 1;
        padding: 8px 15px;
        border-radius: 10px;
        padding-top: 15px;
        padding-bottom: 15px;
    }

    .profile-bg::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: url('https://images.template.net/106277/dark-navy-blue-background-7dhda.png');
        background-position: center;
        background-size: cover;
        transform: rotate(180deg);
        z-index: -1;
        rotate: 180deg;
    }

    .rank {
        display: inline-block;
        background-color: #f22049;
        color: #fff;
        font-size: 14px;
        font-weight: 400;
        padding: 2px 6px;
        border-radius: 5px;
    }

    .dash-uname {
        font-size: 18px;
        color: #fff;
    }

    @media (max-width: 767px) {
        .dash-uname {
            font-size: 16px;
        }
    }

    .greet {
        color: #000;
        font-size: 15px;
        font-weight: 500;
    }

    @media (max-width: 767px) {
        .greet {
            font-size: 14px;
        }
    }

    .custom-card-action {
        position: relative;
        min-height: 400px;
        padding: 1rem;
    }

    .u-img {
      border: 2px solid #fff !important;
    }

    @media (max-width: 480px) {
        .custom-card-action {
            min-height: 300px;
            padding: 0.5rem;
        }
        .card-title {
            font-size: 14px;
        }

    }

</style>

<main class="nxl-container">
    <div class="nxl-content">
        <div class="main-content">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <p class="greet mb-0">Welcome back, <?= $userData['name'] ?>!</p>
                <a href="#" onclick="changeDashboard()" ><i class="bi bi-arrow-clockwise"></i></a>
            </div>
            <div class="card radius-10" style="border: 2px solid #fff">
                <div class="card-body profile-bg">
                    <div class="d-flex align-items-center">
                        <img src="<?= base_url('public/uploads/profiles/' . $userData['image']) ?>" class="rounded-circle u-img" alt="user-image" width="90" height="90">
                        <div class="flex-grow-1 ms-3">
                            <h5 class="mt-0 dash-uname"><?= $userData['name'] ?></h5>
                            <p class="mb-0 rank"><?= $packageName ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <?php if ($userData['dashboard'] === 'old') : ?>
            <div class="row">
                <div class="col-xxl-3 col-md-6" id="sb-earning-box">
                        <div class="card card-body"
                            style="background: linear-gradient(45deg, #9f0141, #ff8630); border: 2px solid #fff; padding: 20px 15px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <h5 class="fs-5 counter"><span id="rupeeSymbol">₹</span><?= $todayEarnings ?></h5>
                                    <span class="text-white">Today's Earning</span>
                                </div>
                                <div class="avatar-text avatar-lg bg-soft-white rounded-4 border-0"
                                    style="color:#044266;">
                                    <i class="bi bi-currency-rupee" style="font-size:30px;"></i>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="col-xxl-3 col-md-6" id="sb-earning-box">
                        <div class="card card-body"
                            style="background: linear-gradient(45deg, #2b00ab, #4dffe6); border: 2px solid #fff; padding: 20px 15px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <h5 class="fs-5 counter"><span id="rupeeSymbol">₹</span><?= $sevenDaysEarnings ?></h5>
                                    <span class="text-white">Weekly Earning</span>
                                </div>
                                <div class="avatar-text avatar-lg bg-soft-white rounded-4 border-0" style="color:#044266;">
                                    <i class="bi bi-gem" style="font-size:30px;"></i>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="col-xxl-3 col-md-6" id="sb-earning-box">
                        <div class="card card-body"
                            style="background: linear-gradient(45deg, #6d0255, #ff554d); border: 2px solid #fff; padding: 20px 15px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <h5 class="fs-5 counter"><span id="rupeeSymbol">₹</span><?= $thirtyDaysEarnings ?></h5>
                                    <span class="text-white">Monthly Earning</span>
                                </div>

                                <div class="avatar-text avatar-lg bg-soft-white rounded-4 border-0"
                                    style="color:#044266;">
                                    <i class="bi bi-bar-chart" style="font-size:30px;"></i>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="col-xxl-3 col-md-6" id="sb-earning-box">
                        <div class="card card-body"
                            style="background: linear-gradient(45deg, #6600af, #4dadff); border: 2px solid #fff; padding: 20px 15px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <h5 class="fs-5 counter"><span id="rupeeSymbol">₹</span><?= $allEarnings ?></h5>
                                    <span class="text-white">All Time Earning</span>
                                </div>
                                <div class="avatar-text avatar-lg bg-soft-white rounded-4 border-0" style="color:#044266;">
                                    <i class="bi bi-trophy" style="font-size:30px;"></i>
                                </div>
                            </div>
                        </div>
                </div>

                <div class="col-xxl-3 col-md-6" id="sb-earning-box">
                        <div class="card card-body"
                            style="background: linear-gradient(45deg, #007254, #cdb405); border: 2px solid #fff; padding: 20px 15px;">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="me-3">
                                    <h5 class="fs-5 counter"><span id="rupeeSymbol">₹</span><?= $userData['wallet'] ?></h5>
                                    <span class="text-white">Unpaid Balance</span>
                                </div>

                                <div class="avatar-text avatar-lg bg-soft-white rounded-4 border-0" style="color:#044266;">
                                    <i class="bi bi-wallet" style="font-size:30px;"></i>
                                </div>
                            </div>
                        </div>
                </div>
            </div>
            <?php elseif ($userData['dashboard'] === 'new') : ?>
                <div class="row">

                    <div class="col-xxl-3 col-md-6 col-6">
                        <div class="card stretch stretch-full" style="background: linear-gradient(45deg, #d5d5d5, #ffffff); border: none;">
                            <div class="card-body p-0">
                                <div class="d-flex justify-content-between align-items-center p-2">
                                    <div>
                                        <div class="fs-20 fw-bold text-dark"><span
                                                class="dash2Counter text-dark">₹<?= $todayEarnings ?>/-</span>
                                        </div>
                                        <div class="fw-normal fs-12 text-dark">Today's Earning</div>
                                    </div>
                                </div>
                                <div id="bounce-rate"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6 col-6">
                        <div class="card stretch stretch-full" style="background: linear-gradient(45deg, #dde6ff, #ffffff); border: none;">
                            <div class="card-body p-0">
                                <div class="d-flex justify-content-between align-items-center p-2">
                                    <div>
                                        <div class="fs-20 fw-bold text-dark"><span
                                                class="dash2Counter text-dark">₹<?= $sevenDaysEarnings ?>/-</span></div>
                                        <div class="fw-normal fs-12 text-dark">7 Days Earning</div>
                                    </div>
                                </div>
                                <div id="page-views"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6 col-6">
                        <div class="card stretch stretch-full" style="background: linear-gradient(45deg, #ffecd1, #ffffff); border: none;">
                            <div class="card-body p-0">
                                <div class="d-flex justify-content-between align-items-center p-2">
                                    <div>
                                        <div class="fs-20 fw-bold text-dark"><span
                                                class="dash2Counter text-dark">₹<?= $thirtyDaysEarnings ?>/-</span></div>
                                        <div class="fw-normal fs-12 text-dark">30 Days Earning</div>
                                    </div>
                                </div>
                                <div id="site-impressions"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xxl-3 col-md-6 col-6">
                        <div class="card stretch stretch-full" style="background: linear-gradient(45deg, #c7ffe1, #ffffff); border: none;">
                            <div class="card-body p-0">
                                <div class="d-flex justify-content-between align-items-center p-2">
                                    <div>
                                        <div class="fs-20 fw-bold text-dark"><span
                                                class="dash2Counter text-dark">₹<?= $allEarnings ?></span></div>
                                        <div class="fw-normal fs-12 text-dark">All Time Earning</div>
                                    </div>
                                </div>
                                <div id="conversions-rate"></div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            <div class="row">
                <div class="col-xxl-12">
                    <div class="card stretch stretch-full">
                        <div class="card-header">
                            <h5 class="card-title">7 Days Sales Graph</h5>
                        </div>
                        <div class="card-body custom-card-action">
                            <canvas id="salesChart" style="width: 100%; height: 300px;"></canvas>
                            <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
                            <script>
                            document.addEventListener('DOMContentLoaded', function() {
                                fetch('/user/getLast7DaysSalesData')
                                    .then(response => response.json())
                                    .then(result => {
                                        if (result.status === 'success') {
                                            const ctx = document.getElementById('salesChart').getContext('2d');
                                            new Chart(ctx, {
                                                type: 'line',
                                                data: {
                                                    labels: result.data.map(item => item.date),
                                                    datasets: [{
                                                        label: '',  
                                                        data: result.data.map(item => item.amount),
                                                        borderColor: 'rgb(75, 192, 192)',
                                                        tension: 0.1,
                                                        fill: false
                                                    }]
                                                },
                                                options: {
                                                    responsive: true,
                                                    maintainAspectRatio: false,
                                                    plugins: {
                                                        legend: {
                                                            display: false  
                                                        }
                                                    },
                                                    scales: {
                                                        y: {
                                                            beginAtZero: true,
                                                            ticks: {
                                                                callback: function(value) {
                                                                    return '₹' + value;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            });
                                        }
                                    });
                            });
                            </script>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>


<div class="modal fade" id="presentationModal" tabindex="-1" aria-labelledby="dashboardGuideLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title" id="dashboardGuideLabel" style="font-size:16px;">Presentation Video</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body p-3">
                <iframe class="dash-guide" src="https://www.youtube.com/embed/"
                    title="YouTube video player" frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                    referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
            </div>
        </div>
    </div>
</div>



<script>
    document.addEventListener("DOMContentLoaded", function() {
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }

        function counterUp(element, start = 0, end, duration = 2000) {
            const range = end - start;
            const startTime = performance.now();

            function update() {
                const elapsed = performance.now() - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const current = Math.floor(start + range * progress);
                element.innerHTML = `₹${formatNumber(current)}`;
                if (progress < 1) {
                    requestAnimationFrame(update);
                }
            }
            requestAnimationFrame(update);
        }
        const counters = document.querySelectorAll(".counter");
        counters.forEach(counter => {
            const value = parseInt(counter.textContent.replace(/[^\d]/g, ''));
            counterUp(counter, 0, value);
        });
    });
    
    document.addEventListener("DOMContentLoaded", function () {
        function formatNumber(num) {
            return num.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
        }
    
        function formatInLakh(num) {
            if (num >= 100000) {
                return (num / 100000).toFixed(1) + "Lakh";
            }
            return formatNumber(num);
        }
    
        function dash2CounterUp(element, start = 0, end, duration = 2000) {
            const range = end - start;
            const startTime = performance.now();
    
            function update() {
                const elapsed = performance.now() - startTime;
                const progress = Math.min(elapsed / duration, 1);
                const current = Math.floor(start + range * progress);
                element.innerHTML = `₹${formatInLakh(current)}`;
                if (progress < 1) {
                    requestAnimationFrame(update);
                }
            }
            requestAnimationFrame(update);
        }
    
        const dash2Counters = document.querySelectorAll(".dash2Counter");
        dash2Counters.forEach(dash2Counter => {
            const value = parseInt(dash2Counter.textContent.replace(/[^\d]/g, ''));
            dash2CounterUp(dash2Counter, 0, value);
        });
    });

    $(document).ready(function() {
        var lastShown = localStorage.getItem('presentationModalShown');
        var now = new Date().getTime();
        if (!lastShown || now - lastShown > 86400000) {
            var dashboardGuideModal = new bootstrap.Modal(document.getElementById('presentationModal'));
            dashboardGuideModal.show();
            localStorage.setItem('presentationModalShown', now);
        }
    });

    document.getElementById('sb-earning-box').addEventListener('click', function() {
        const rupeeSymbol = document.getElementById('rupeeSymbol'); 
    });


    function changeDashboard() {
        <?php if ($userData['dashboard'] === 'new') {
            $dash = 'old';
        } else {
            $dash = 'new';
        } ?>
        fetch ('<?= base_url('user/changeDashboard'); ?>', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                dashboard: '<?= $dash ?>'
            })
        }).then(response => response.json()).then(data => {
            if (data.status == 'success') {
                swal.fire({
                    icon: "success",
                    title: "Success",
                    text: data.message,
                    showConfirmButton: false,
                    timer: 1500
                });
                setTimeout(function() {
                    window.location.reload();
                }, 1500);
            } else {
                swal.fire({
                    icon: "error",
                    title: "Error",
                    text: data.message,
                    showConfirmButton: false,
                    timer: 1500
                });
            }
        });
    }
</script>

<?= $this->include('user/footer') ?>
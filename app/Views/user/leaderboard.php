<?= $this->include('user/header') ?>
<style>
    hr {
        margin-top: 15px !important;
        margin-bottom: 0px !important;
    }

    .tblimg-lb {
        border: 2px solid #fff;
        border-radius: 100%;
        padding: 2px;
        height: 50px;
        width: 50px;

    }

    .lb-tbl-amount {
        font-weight: 500;
        color: #1f1e43 !important;
        text-align: right !important;
    }

    .lb-heading {
        margin-bottom: 10%;
    }

    @media (max-width: 767px) {
        .lb-heading {
            margin-bottom: 18%;
        }

        .top3 {
            margin-top: 25% !important;
        }
    }

    .lb-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        text-align: center;
    }

    .lb-info {
        display: flex;
        flex-direction: column;
        align-items: center;
    }

    .lb-badge {
        display: flex;
        justify-content: center;
        align-items: center;
        width: 40px;
        height: 32px;
        border-radius: 100%;
    }

    .lb-badge p {
        margin-bottom: 0px;
        padding: 8px;
        font-weight: 400;
        color: #fff;
        font-size: 12px;
    }

    .lb-badge.first {
        background: #ff5200;
        margin-top: -18px;
    }

    .lb-badge.second {
        background: #00b8ff;
        margin-top: -18px;
    }

    .lb-badge.third {
        background: #ba49e9;
        margin-top: -18px;
    }

    img.rounded-circle.second {
        width: 80px;
        height: 80px;
        overflow: hidden;
    }

    img.rounded-circle.third {
        width: 80px;
        height: 80px;
        overflow: hidden;
    }

    img.rounded-circle.first {
        border: 2px solid #ff5200;
    }

    img.rounded-circle.second {
        border: 2px solid #00b8ff;
    }

    img.rounded-circle.third {
        border: 2px solid #ba49e9;
    }

    .crown-image {
        position: absolute;
        top: 5.5%;
        left: 50%;
        transform: translateX(-50%) rotate(0deg);
        width: 2vw;
        height: auto;
        z-index: 1;
    }


    @media (max-width: 480px) {
        .crown-image {
            top: 6%;
            left: 50%;
            width: 8vw;
            transform: translateX(-50%) rotate(0deg);
        }
    }

    img.rounded-circle.first {
        width: 90px;
        height: 90px;
        margin-top: -45px;
    }

    .col-4.lb-item.first {
        order: 2;
    }

    .col-4.lb-item.second {
        order: 1;
    }

    .col-4.lb-item.third {
        order: 3;
    }

    .grid__amount.first {
        color: #ff5200;
    }

    .grid__amount.second {
        color: #00b8ff;
    }

    .grid__amount.third {
        color: #ba49e9;
    }

    .grid__name {
        font-size: 13px;
        font-weight: 600;
        background: white;
        padding: 5px 10px;
        border-radius: 30px;
        color: #000;
        margin-top: 8px;
        margin-bottom: 5px;
    }

    .grid__amount {
        font-size: 16px;
        font-weight: 600;
    }

    .top3 {
        border-radius: 10px;
        /*background: linear-gradient(rgb(32 19 82 / 85%), #090e2a), url(../public/user/assets/images/bg-profile.jpeg) !important;*/
        padding-top: 15px;
        padding-bottom: 10px;
        margin-top: 10%;
    }
    
    .lb-badge.lb-rank {
        background: #8853ed;
        width: 25px;
        height: 25px;
        border: 1px solid #fff;
        margin-right: 5px;
    }

    .lb-border {
        border: 1px solid #8853ed;
        border-radius: 15px;
        padding: 5px;
    }
    
    .lb-tbl-name {
        font-weight: 500;
        font-size: 14px;
        color: white;
    }
    
    .lb-tbl-amount {
        color: white !important;
    }
</style>

<!--start content-->
<main class="nxl-container">
    <div class="nxl-content">
        <div class="main-content">
            <h2><?= $title ?></h2>
            <hr>
            <div class="row" style="margin-top:25px;">
                <?php if($siteAdminToken['today_lb'] == 'active') {?>
                    <?php if (!empty($todayLeaderboard['leaderboard'])) { ?>
                        <div class="col-12 col-lg-6 d-flex">
                            <div class="card rounded-4 w-100">
                                <div class="card-body p-0" style="background: #241442; border-radius: 15px;">
                                    <div class="p-3 rounded tbl-box">
                                        <h6 class="mb-5 text-uppercase text-center text-white">Today's Leaderboard</h6>
    
                                        <div class="d-flex mb-4 top3">
                                            <?php
                                            $rank = 1;
                                            $top3UserIds = [];
                                            foreach ($todayLeaderboard['leaderboard'] as $todaylb) {
    
                                                if ($rank > 3)
                                                    break;
    
                                                $badge = '';
                                                $extraClass = '';
                                                if ($rank == 1) {
                                                    $badge = '1st';
                                                    $extraClass = 'first';
                                                } elseif ($rank == 2) {
                                                    $badge = '2nd';
                                                    $extraClass = 'second';
                                                } elseif ($rank == 3) {
                                                    $badge = '3rd';
                                                    $extraClass = 'third';
                                                }
    
                                                $top3UserIds[] = $todaylb['id']; // Track ID
                                        
                                                ?>
                                                <div class="col-4 lb-item <?= $extraClass ?>">
                                                    <img src="<?= base_url('public/uploads/profiles/' . $todaylb['image']); ?>" alt="Avatar" class="rounded-circle <?= $extraClass ?>" width="80">
                                                    <div class="lb-badge <?= $extraClass ?>">
                                                        <p><?= $badge ?></p>
                                                    </div>
                                                    <div class="gridarea__small__button lb-info">
                                                        <div class="grid__name">
                                                            <?php $name = $todaylb['name'];
                                                            $firstWord = explode(' ', $name)[0];
                                                            echo $firstWord; ?>
                                                        </div>
                                                        <div class="grid__amount <?= $extraClass ?>">
                                                            ₹<?= $todaylb['amount']; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $rank++;
                                            } ?>
                                        </div>
    
                                        <!-- Bottom Table for Rank 4 and Beyond -->
                                        <table class="table mb-0">
                                            <tbody>
                                                <?php
                                                $rank = 4;
                                                foreach ($todayLeaderboard['leaderboard'] as $todaylb) {
                                                    if (!in_array($todaylb['id'], $top3UserIds)) {
                                                        ?>
                                                        <tr>
                                                            <td class="border-0 px-0 pb-2">
                                                                <div class="d-flex justify-content-start align-items-center lb-border">
                                                                    <div class="lb-badge lb-rank">
                                                                        <p><?= $rank ?></p>
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <img class="tblimg-lb" src="<?= base_url('public/uploads/profiles/' . $todaylb['image']); ?>"
                                                                            alt="Avatar" class="wid-50 rounded-circle"
                                                                            style="height: 50px; margin-right: 8px;">
                                                                    </div>
                                                                    <div class="col text-dark">
                                                                        <h6 class="mb-0 lb-tbl-name"><?= $todaylb['name']; ?></h6>
                                                                    </div>
    
                                                                    <div class="col">
                                                                        <h6 class="mb-0 lb-tbl-amount">
                                                                            ₹<?= $todaylb['amount']; ?>
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $rank++;
                                                    }
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>

                <?php if($siteAdminToken['seven_days_lb'] == 'active') {?>
                    <?php if (!empty($weeklyLeaderboard['leaderboard'])) { ?>
                        <div class="col-12 col-lg-6 d-flex">
                            <div class="card rounded-4 w-100">
                                <div class="card-body p-0" style="background: #241442; border-radius: 15px;">
                                    <div class="p-3 rounded">
                                        <h6 class="mb-5 text-uppercase text-center text-white">7 Days Leaderboard</h6>
                                        <div class="d-flex mb-4 top3">
                                            <?php
                                            $rank = 1;
                                            $top7Dayslbids = [];
                                            foreach ($weeklyLeaderboard['leaderboard'] as $top7Dayslb) {
    
                                                if ($rank > 3)
                                                    break;
    
                                                $badge = '';
                                                $extraClass = '';
                                                if ($rank == 1) {
                                                    $badge = '1st';
                                                    $extraClass = 'first';
                                                } elseif ($rank == 2) {
                                                    $badge = '2nd';
                                                    $extraClass = 'second';
                                                } elseif ($rank == 3) {
                                                    $badge = '3rd';
                                                    $extraClass = 'third';
                                                }
    
                                                $top7Dayslbids[] = $top7Dayslb['id']; // Track ID
                                        
                                                ?>
                                                <div class="col-4 lb-item <?= $extraClass ?>">
                                                    <img src="<?= base_url('public/uploads/profiles/' . $top7Dayslb['image']); ?>"
                                                        alt="Avatar" class="rounded-circle <?= $extraClass ?>" width="80">
                                                    <div class="lb-badge <?= $extraClass ?>">
                                                        <p><?= $badge ?></p>
                                                    </div>
                                                    <div class="gridarea__small__button lb-info">
                                                        <div class="grid__name">
                                                            <?php $name = $top7Dayslb['name'];
                                                            $firstWord = explode(' ', $name)[0];
                                                            echo $firstWord; ?>
                                                        </div>
                                                        <div class="grid__amount <?= $extraClass ?>">
                                                            ₹<?= $top7Dayslb['amount']; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $rank++;
                                            } ?>
                                        </div>
    
                                        <!-- Bottom Table for Rank 4 and Beyond -->
                                        <table class="table mb-0">
                                            <tbody>
                                                <?php
                                                $rank = 4;
                                                foreach ($weeklyLeaderboard['leaderboard'] as $top7Dayslb) {
                                                    if (!in_array($top7Dayslb['id'], $top7Dayslbids)) {
                                                        ?>
                                                        <tr>
                                                            <td class="border-0 px-0 pb-2">
                                                                <div class="d-flex justify-content-start align-items-center lb-border">
                                                                    <div class="lb-badge lb-rank">
                                                                        <p><?= $rank ?></p>
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <img class="tblimg-lb" src="<?= base_url('public/uploads/profiles/' . $top7Dayslb['image']); ?>"
                                                                            alt="Avatar" class="wid-50 rounded-circle"
                                                                            style="height: 50px; margin-right: 8px;">
                                                                    </div>
                                                                    <div class="col text-dark">
                                                                        <h6 class="mb-0 lb-tbl-name"><?= $top7Dayslb['name']; ?></h6>
                                                                    </div>
                                                                    <div class="col">
                                                                        <h6 class="mb-0 lb-tbl-amount">₹
                                                                            <?= $top7Dayslb['amount']; ?>
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $rank++;
                                                    }
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>

                <?php if($siteAdminToken['thirty_days_lb'] == 'active') {?>
                    <?php if (!empty($monthlyLeaderboard['leaderboard'])) { ?>
                        <div class="col-12 col-lg-6 d-flex">
                            <div class="card rounded-4 w-100">
                                <div class="card-body p-0" style="background: #241442; border-radius: 15px;">
                                    <div class="p-3 rounded">
                                        <h6 class="mb-5 text-uppercase text-center text-white">30 Days Leaderboard</h6>
                                        <div class="d-flex mb-4 top3">
                                            <?php
                                            $rank = 1;
                                            $top30Dayslbids = [];
                                            foreach ($monthlyLeaderboard['leaderboard'] as $top30Dayslb) {
    
                                                if ($rank > 3)
                                                    break;
    
                                                $badge = '';
                                                $extraClass = '';
                                                if ($rank == 1) {
                                                    $badge = '1st';
                                                    $extraClass = 'first';
                                                } elseif ($rank == 2) {
                                                    $badge = '2nd';
                                                    $extraClass = 'second';
                                                } elseif ($rank == 3) {
                                                    $badge = '3rd';
                                                    $extraClass = 'third';
                                                }
    
                                                $top30Dayslbids[] = $top30Dayslb['id']; // Track ID
                                        
                                                ?>
                                                <div class="col-4 lb-item <?= $extraClass ?>">
                                                    <img src="<?= base_url('public/uploads/profiles/' . $top30Dayslb['image']); ?>"
                                                        alt="Avatar" class="rounded-circle <?= $extraClass ?>" width="80">
                                                    <div class="lb-badge <?= $extraClass ?>">
                                                        <p><?= $badge ?></p>
                                                    </div>
                                                    <div class="gridarea__small__button lb-info">
                                                        <div class="grid__name">
                                                            <?php $name = $top30Dayslb['name'];
                                                            $firstWord = explode(' ', $name)[0];
                                                            echo $firstWord; ?>
                                                        </div>
                                                        <div class="grid__amount <?= $extraClass ?>">
                                                            ₹<?= $top30Dayslb['amount']; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $rank++;
                                            } ?>
                                        </div>
    
                                        <!-- Bottom Table for Rank 4 and Beyond -->
                                        <table class="table mb-0">
                                            <tbody>
                                                <?php
                                                $rank = 4;
                                                foreach ($monthlyLeaderboard['leaderboard'] as $top30Dayslb) {
                                                    if (!in_array($top30Dayslb['id'], $top30Dayslbids)) {
                                                        ?>
                                                        <tr>
                                                            <td class="border-0 px-0 pb-2">
                                                                <div class="d-flex justify-content-start align-items-center lb-border">
                                                                    <div class="lb-badge lb-rank">
                                                                        <p><?= $rank ?></p>
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <img class="tblimg-lb" src="<?= base_url('public/uploads/profiles/' . $top30Dayslb['image']); ?>"
                                                                            alt="Avatar" class="wid-50 rounded-circle"
                                                                            style="height: 50px; margin-right: 8px;">
                                                                    </div>
                                                                    <div class="col text-dark">
                                                                        <h6 class="mb-0 lb-tbl-name"><?= $top30Dayslb['name']; ?></h6>
                                                                    </div>
                                                                    <div class="col">
                                                                        <h6 class="mb-0 lb-tbl-amount">₹
                                                                            <?= $top30Dayslb['amount']; ?>
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $rank++;
                                                    }
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>

                <?php if($siteAdminToken['all_time_lb'] == 'active') {?>
                    <?php if (!empty($allTimeLeaderboard['leaderboard'])) { ?>
                        <div class="col-12 col-lg-6 d-flex">
                            <div class="card rounded-4 w-100">
                                <div class="card-body p-0" style="background: #241442; border-radius: 15px;">
                                    <div class="p-3 rounded">
                                        <h6 class="mb-5 text-uppercase text-center text-white">All Time Leaderboard</h6>
                                        <div class="d-flex mb-4 top3">
                                            <?php
                                            $rank = 1;
                                            $topUserslbids = [];
                                            foreach ($allTimeLeaderboard['leaderboard'] as $topUserslb) {
    
                                                if ($rank > 3)
                                                    break;
    
                                                $badge = '';
                                                $extraClass = '';
                                                if ($rank == 1) {
                                                    $badge = '1st';
                                                    $extraClass = 'first';
                                                } elseif ($rank == 2) {
                                                    $badge = '2nd';
                                                    $extraClass = 'second';
                                                } elseif ($rank == 3) {
                                                    $badge = '3rd';
                                                    $extraClass = 'third';
                                                }
    
                                                $topUserslbids[] = $topUserslb['id']; // Track ID
                                        
                                                ?>
                                                <div class="col-4 lb-item <?= $extraClass ?>">
                                                    <img src="<?= base_url('public/uploads/profiles/' . $topUserslb['image']); ?>"
                                                        alt="Avatar" class="rounded-circle <?= $extraClass ?>" width="80">
                                                    <div class="lb-badge <?= $extraClass ?>">
                                                        <p><?= $badge ?></p>
                                                    </div>
                                                    <div class="gridarea__small__button lb-info">
                                                        <div class="grid__name">
                                                            <?php $name = $topUserslb['name'];
                                                            $firstWord = explode(' ', $name)[0];
                                                            echo $firstWord; ?>
                                                        </div>
                                                        <div class="grid__amount <?= $extraClass ?>">
                                                            ₹<?= $topUserslb['amount']; ?>
                                                        </div>
                                                    </div>
                                                </div>
                                                <?php $rank++;
                                            } ?>
                                        </div>
    
                                        <!-- Bottom Table for Rank 4 and Beyond -->
                                        <table class="table mb-0">
                                            <tbody>
                                                <?php
                                                $rank = 4;
                                                foreach ($allTimeLeaderboard['leaderboard'] as $topUserslb) {
                                                    if (!in_array($topUserslb['id'], $topUserslbids)) {
                                                        ?>
                                                        <tr>
                                                            <td class="border-0 px-0 pb-2">
                                                                <div class="d-flex justify-content-start align-items-center lb-border">
                                                                    <div class="lb-badge lb-rank">
                                                                        <p><?= $rank ?></p>
                                                                    </div>
                                                                    <div class="col-auto">
                                                                        <img class="tblimg-lb" src="<?= base_url('public/uploads/profiles/' . $topUserslb['image']); ?>"
                                                                            alt="Avatar" class="wid-50 rounded-circle"
                                                                            style="height: 50px; margin-right: 8px;">
                                                                    </div>
                                                                    <div class="col text-dark">
                                                                        <h6 class="mb-0 lb-tbl-name"><?= $topUserslb['name']; ?></h6>
                                                                    </div>
                                                                    <div class="col">
                                                                        <h6 class="mb-0 lb-tbl-amount">₹
                                                                            <?= $topUserslb['amount']; ?>
                                                                        </h6>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        <?php
                                                        $rank++;
                                                    }
                                                } ?>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                <?php } ?>
            </div>
        </div>
    </div>
</main>
<?= $this->include('user/footer') ?>
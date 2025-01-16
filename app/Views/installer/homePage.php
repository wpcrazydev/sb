<?= $this->include('installer/header') ?>
<main class="d-flex justify-content-center align-items-center" style="height: 100vh;">
    <div class="container d-flex flex-column justify-content-center align-items-center">
        <div class="biz-box">
            <div class="mb-4 d-flex justify-content-between align-items-center biz-box-header">
                <img src="<?= $data['installerLogo'] ?>" alt="Logo">
                <h3 class="text-center"><?= $data['installerName'] ?></h3>
            </div>
            <?php 
            // session()->destroy();
            ?>
            <?php if ($data['step'] == 0) { ?>
                <?= $this->include('installer/parts/step0') ?>
            <?php } elseif ($data['step'] == 1) { ?>
                <?= $this->include('installer/parts/step1') ?>
            <?php } elseif ($data['step'] == 2) { ?>
                <?= $this->include('installer/parts/step2') ?>
            <?php } elseif ($data['step'] == 3) { ?>
                <?= $this->include('installer/parts/step3') ?>
            <?php } elseif ($data['step'] == 4) { ?>
                <?= $this->include('installer/parts/step4') ?>
            <?php } elseif ($data['step'] == 5) { ?>
                <?= $this->include('installer/parts/step5') ?>
            <?php } elseif ($data['step'] == 6) { ?>
                <?= $this->include('installer/parts/step6') ?>
            <?php } ?>
            <div class="box-footer">
                <a href="?step=<?= $data['backUrl'] ?>" id="backStep" class="btn btn-dark">Go Back</a>
                <a href="?step=<?= $data['step'] + 1 ?>" id="nextStep" class="btn biz-btn">Next Step</a>
            </div>
        </div>
    </div>
</main>
<?= $this->include('installer/footer') ?>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/canvas-confetti@1.4.0/dist/confetti.browser.min.js"></script>
<script>
<?php if ($data['step'] == 0) { ?>
    document.getElementById('backStep').style.display = 'none';
<?php } ?>
<?php if ($data['step'] == 1) { ?>
    document.getElementById('nextStep').style.display = 'none';
    document.getElementById('backStep').style.display = 'none';
    let spinner = document.getElementById('spinner');
    let spinnerMessage = document.getElementById('spinnerMessage');
    let finalMessage = document.getElementById('finalMessage');
    let finalIcon = document.getElementById('finalIcon');
    let errorIcon = document.getElementById('errorIcon');
    let showError = document.getElementById('showError');
    let errorDetails = document.getElementById('errorDetails');
        fetch('/installer/requirements', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    setTimeout(() => {
                        spinner.style.display = 'none';
                        spinnerMessage.style.display = 'none';
                        finalIcon.style.display = 'block';
                        finalMessage.innerHTML = data.message;
                        finalMessage.style.display = 'block';
                        document.getElementById('nextStep').style.display = 'block';
                        document.getElementById('backStep').style.display = 'block';
                    }, 5000);
                } else {
                    setTimeout(() => {
                        spinner.style.display = 'none';
                        spinnerMessage.style.display = 'none';
                        errorIcon.style.display = 'block';
                        finalMessage.innerHTML = data.message;
                        finalMessage.style.display = 'block';
                        showError.style.display = 'block';
                        let requirementsList = '<table class="table table-bordered">';
                        requirementsList += '<thead><tr><th>Requirement</th><th>Status</th></tr></thead><tbody>';
                        for (const [requirement, status] of Object.entries(data.data)) {
                            const formattedRequirement = requirement.charAt(0).toUpperCase() + requirement.slice(1);
                            requirementsList += `
                                <tr>
                                    <td>${formattedRequirement}</td>
                                    <td>${status}</td>
                                </tr>`;
                        }
                        requirementsList += '</tbody></table>';
                        errorDetails.innerHTML = requirementsList;
                    }, 1000);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('finalMessage').textContent = 'An error occurred while checking requirements';
            });
<?php } ?>
<?php if ($data['step'] == 2) { ?>
    document.getElementById('nextStep').style.display = 'none';
    let licenseKey = document.getElementById('licenseKey');
    let licenseEmail = document.getElementById('licenseEmail');
    let typingTimer;
    const doneTypingInterval = 100;
    function validateLicense() {
        const key = licenseKey.value.trim();
        const email = licenseEmail.value.trim();
        const errorMessage = document.getElementById('step2ErrorMessage');
        if (key && email) {
            fetch('/installer/verifyKey', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    license_key: key,
                    license_email: email
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    errorMessage.style.color = 'green';
                    errorMessage.textContent = data.message;
                    document.getElementById('nextStep').style.display = 'block';
                } else {
                    errorMessage.style.color = 'red';
                    errorMessage.textContent = data.message;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                errorMessage.textContent = 'An error occurred while verifying the license';
            });
        }
    }
    document.getElementById('step2ErrorMessage').style.color = 'blue';
    const errorMessage = document.getElementById('step2ErrorMessage');
    licenseKey.addEventListener('input', function() {
        clearTimeout(typingTimer);
        errorMessage.textContent = 'Checking License Key...'; 
        typingTimer = setTimeout(validateLicense, doneTypingInterval);
    });
    licenseEmail.addEventListener('input', function() {
        clearTimeout(typingTimer);
        errorMessage.textContent = 'Checking License Email...'; 
        typingTimer = setTimeout(validateLicense, doneTypingInterval);
    });
    if (licenseKey.value.trim() !== '' && licenseEmail.value.trim() !== '') {
        validateLicense();
    }
<?php } ?>
<?php if ($data['step'] == 3) { ?>
    document.getElementById('nextStep').style.display = 'none';
    let dbHost = document.getElementById('db_host');
    let dbName = document.getElementById('db_name');
    let dbUsername = document.getElementById('db_user');
    let dbPassword = document.getElementById('db_password');
    let typingTimer;
    const doneTypingInterval = 1000;
    function validateDatabase() {
        const host = dbHost.value.trim();
        const name = dbName.value.trim();
        const username = dbUsername.value.trim();
        const password = dbPassword.value.trim();
        const errorMessage = document.getElementById('step3ErrorMessage');

        if (host && name && username && password) {
            errorMessage.style.color = 'blue';
            errorMessage.textContent = 'Checking...'; 
            fetch('/installer/verifyDatabase', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    db_host: host,
                    db_name: name,
                    db_user: username,
                    db_password: password
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    errorMessage.style.color = 'green';
                    errorMessage.textContent = data.message;
                    document.getElementById('nextStep').style.display = 'block';
                } else {
                    errorMessage.style.color = 'red';
                    errorMessage.textContent = data.message;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                errorMessage.textContent = 'An error occurred while verifying the database';
            });
        }
    }
    document.getElementById('step3ErrorMessage').style.color = 'blue';
    const errorMessage = document.getElementById('step3ErrorMessage');
    dbHost.addEventListener('input', function() {
        clearTimeout(typingTimer);
        errorMessage.textContent = 'Checking Database Host...'; 
        typingTimer = setTimeout(validateDatabase, doneTypingInterval);
    });
    dbName.addEventListener('input', function() {
        clearTimeout(typingTimer);
        errorMessage.textContent = 'Checking Database Name...'; 
        typingTimer = setTimeout(validateDatabase, doneTypingInterval);
    });
    dbUsername.addEventListener('input', function() {
        clearTimeout(typingTimer);
        errorMessage.textContent = 'Checking Database Username...'; 
        typingTimer = setTimeout(validateDatabase, doneTypingInterval);
    });
    dbPassword.addEventListener('input', function() {
        clearTimeout(typingTimer);
        errorMessage.textContent = 'Checking Database Password...'; 
        typingTimer = setTimeout(validateDatabase, doneTypingInterval);
    });
    if (dbHost.value.trim() !== '' && dbName.value.trim() !== '' && dbUsername.value.trim() !== '' && dbPassword.value.trim() !== '') {
        validateDatabase();
    }
<?php } ?>
<?php if ($data['step'] == 4) { ?>
    document.getElementById('nextStep').style.display = 'none';
    const adminNameInput = document.getElementById('admin_name');
    const adminPhoneInput = document.getElementById('admin_phone');
    const adminEmailInput = document.getElementById('admin_email');
    const adminPasswordInput = document.getElementById('admin_password');
    let typingTimer;
    const doneTypingInterval = 1000;
    
    function validateAdmin() {
        const adminName = adminNameInput.value.trim();
        const adminPhone = adminPhoneInput.value.trim();
        const adminEmail = adminEmailInput.value.trim();
        const adminPassword = adminPasswordInput.value.trim();
        const errorMessage = document.getElementById('step4ErrorMessage');
        
        if (adminName && adminPhone && adminEmail && adminPassword) {
            fetch('/installer/verifyAdmin', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    admin_name: adminName,
                    admin_phone: adminPhone,
                    admin_email: adminEmail,
                    admin_password: adminPassword,
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    errorMessage.style.color = 'green';
                    errorMessage.textContent = data.message;
                    document.getElementById('nextStep').style.display = 'block';
                } else {
                    errorMessage.style.color = 'red';
                    errorMessage.textContent = data.message;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                errorMessage.textContent = 'An error occurred while verifying the admin details';
            });
        }
    }

    document.getElementById('step4ErrorMessage').style.color = 'blue';
    const errorMessage = document.getElementById('step4ErrorMessage');
    adminNameInput.addEventListener('input', function() {
        clearTimeout(typingTimer);
        errorMessage.textContent = 'Checking Admin Name...'; 
        typingTimer = setTimeout(validateAdmin, doneTypingInterval);
    });
    
    adminPhoneInput.addEventListener('input', function() {
        clearTimeout(typingTimer);
        errorMessage.textContent = 'Checking Admin Phone...'; 
        typingTimer = setTimeout(validateAdmin, doneTypingInterval);
    });
    
    adminEmailInput.addEventListener('input', function() {
        clearTimeout(typingTimer);
        errorMessage.textContent = 'Checking Admin Email...'; 
        typingTimer = setTimeout(validateAdmin, doneTypingInterval);
    });
    
    adminPasswordInput.addEventListener('input', function() {
        clearTimeout(typingTimer);
        errorMessage.textContent = 'Checking Admin Password...'; 
        typingTimer = setTimeout(validateAdmin, doneTypingInterval);
    });
    if (adminNameInput.value.trim() !== '' && adminPhoneInput.value.trim() !== '' && adminEmailInput.value.trim() !== '' && adminPasswordInput.value.trim() !== '') {
        validateAdmin();
    }
<?php } ?>
<?php if ($data['step'] == 5) { ?>
    document.getElementById('nextStep').style.display = 'none';
    const websiteNameInput = document.getElementById('website_name');
    const websiteTaglineInput = document.getElementById('website_tagline');
    const websiteUrlInput = document.getElementById('website_url');
    const adminUrlInput = document.getElementById('admin_url');
    const superAdminUrlInput = document.getElementById('super_admin_url');
    let typingTimer;
    const doneTypingInterval = 1000;
    
    function validateWebsiteDetails() {
        const websiteName = websiteNameInput.value.trim();
        const websiteTagline = websiteTaglineInput.value.trim();
        const websiteUrl = websiteUrlInput.value.trim();
        const adminUrl = adminUrlInput.value.trim();
        const superAdminUrl = superAdminUrlInput.value.trim();
        const errorMessage = document.getElementById('step5ErrorMessage');
        if (websiteName && websiteTagline && websiteUrl && adminUrl && superAdminUrl) {
            fetch('/installer/websiteDetails', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    website_name: websiteName,
                    website_tagline: websiteTagline,
                    website_url: websiteUrl,
                    admin_url: adminUrl,
                    super_admin_url: superAdminUrl,
                })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    errorMessage.style.color = 'green';
                    errorMessage.textContent = data.message;
                    document.getElementById('nextStep').style.display = 'block';
                } else {
                    errorMessage.style.color = 'red';
                    errorMessage.textContent = data.message;
                }
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('step5ErrorMessage').textContent = 'An error occurred while verifying the website details';
            });
        }
    }
    
    document.getElementById('step5ErrorMessage').style.color = 'blue';
    const errorMessage = document.getElementById('step5ErrorMessage');
    websiteNameInput.addEventListener('input', function() {
        clearTimeout(typingTimer);
        errorMessage.textContent = 'Checking Website Name...'; 
        typingTimer = setTimeout(validateWebsiteDetails, doneTypingInterval);
    });
    
    websiteTaglineInput.addEventListener('input', function() {
        clearTimeout(typingTimer);
        errorMessage.textContent = 'Checking Website Tagline...'; 
        typingTimer = setTimeout(validateWebsiteDetails, doneTypingInterval);
    });
    
    websiteUrlInput.addEventListener('input', function() {
        clearTimeout(typingTimer);
        errorMessage.textContent = 'Checking Website URL...'; 
        typingTimer = setTimeout(validateWebsiteDetails, doneTypingInterval);
    });
    
    adminUrlInput.addEventListener('input', function() {
        clearTimeout(typingTimer);
        errorMessage.textContent = 'Checking Admin URL...'; 
        typingTimer = setTimeout(validateWebsiteDetails, doneTypingInterval);
    });
    
    superAdminUrlInput.addEventListener('input', function() {
        clearTimeout(typingTimer);
        errorMessage.textContent = 'Checking Super Admin URL...'; 
        typingTimer = setTimeout(validateWebsiteDetails, doneTypingInterval);
    });
    if (websiteNameInput.value.trim() !== '' && websiteTaglineInput.value.trim() !== '' && websiteUrlInput.value.trim() !== '' && adminUrlInput.value.trim() !== '' && superAdminUrlInput.value.trim() !== '') {
        validateWebsiteDetails();
    }
<?php } ?>
<?php if ($data['step'] == 6) { ?>
    document.getElementById('nextStep').style.display = 'none';
    document.getElementById('backStep').style.display = 'none';
    let spinner = document.getElementById('spinner');
    let spinnerMessage = document.getElementById('spinnerMessage');
    let finalMessage = document.getElementById('finalMessage');
    let finalIcon = document.getElementById('finalIcon');
    let errorIcon = document.getElementById('errorIcon');
    let showError = document.getElementById('showError');
    let errorDetails = document.getElementById('errorDetails');
    let steps = [
        { name: 'Analyzing Provided Data'},
        { name: 'Setting Up Environment'}, 
        { name: 'Setting Up Website Details'}, 
        { name: 'Creating Database Tables'},
        { name: 'Creating Admin User'},
        { name: 'Finishing Installation'}
    ];
    let currentStep = 0;

    function processNextStep() {
        if (currentStep < steps.length) {
            spinnerMessage.innerHTML = `${steps[currentStep].name}...`;
            setTimeout(() => {
            fetch('/installer/finalize', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                },
                body: JSON.stringify({
                    step: currentStep + 1
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log(data);
                if (data.success) {
                    currentStep++;
                    if (currentStep < steps.length) {
                        processNextStep();
                    } else {
                        spinner.style.display = 'none';
                        spinnerMessage.style.display = 'none';
                        finalIcon.style.display = 'block';
                        finalMessage.innerHTML = data.message;
                        finalMessage.style.display = 'block';
                        confetti({
                            particleCount: 200,
                            spread: 70,
                            origin: { y: 0.6 }
                        });
                        setTimeout(() => {
                            confetti({
                                particleCount: 150,
                                angle: 60,
                                spread: 90,
                                origin: { x: 0, y: 0.7 }
                            });
                        }, 500);
                        setTimeout(() => {
                            confetti({
                                particleCount: 150,
                                angle: 120,
                                spread: 90,
                                origin: { x: 1, y: 0.7 }
                            });
                        }, 1000);
                        setTimeout(() => {
                            confetti({
                                particleCount: 250,
                                angle: 90,
                                spread: 120,
                                origin: { x: 0.5, y: 0.3 }
                            });
                        }, 1500);
                        setTimeout(() => {
                            let countdown = 5;
                            let redirectMessage = document.getElementById('redirectMessage');
                            redirectMessage.style.display = 'block';
                            let countdownInterval = setInterval(() => {
                                redirectMessage.innerHTML = `Redirecting in ${countdown} seconds...`;
                                countdown--;
                                if (countdown === 0) {
                                    clearInterval(countdownInterval);
                                    redirectMessage.style.display = 'none';
                                    window.location.href = '/';
                                }
                            }, 1000);
                        }, 5000);
                    }
                } else {
                    spinner.style.display = 'none';
                    spinnerMessage.style.display = 'none';
                    errorIcon.style.display = 'block';
                    finalMessage.innerHTML = data.message;
                    finalMessage.style.display = 'block';
                    showError.style.display = 'block';
                    if (data.data) {
                        let requirementsList = '<table class="table table-bordered">';
                        requirementsList += '<thead><tr><th>Requirement</th><th>Status</th></tr></thead><tbody>';
                        for (const [requirement, status] of Object.entries(data.data)) {
                            const formattedRequirement = requirement.charAt(0).toUpperCase() + requirement.slice(1);
                            requirementsList += `
                                <tr>
                                    <td>${formattedRequirement}</td>
                                    <td>${status}</td>
                                </tr>`;
                        }
                        requirementsList += '</tbody></table>';
                        errorDetails.innerHTML = requirementsList;
                    }
                }
            })
            .catch(error => {
                console.error('Error:', error);
                spinner.style.display = 'none';
                spinnerMessage.style.display = 'none';
                errorIcon.style.display = 'block';
                finalMessage.textContent = 'An error occurred during installation';
                finalMessage.style.display = 'block';
            });
        }, 2000);
        }
    }
    processNextStep();
<?php } ?>
</script>
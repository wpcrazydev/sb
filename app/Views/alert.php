<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php if (session()->get('error') || session()->get('errors')): ?>
<script>
    Swal.fire({
        icon: 'error',
        title: 'Error',
        html: <?php 
            if (is_array(session()->get('error')) || is_array(session()->get('errors'))) {
                $errors = array_filter([
                    session()->get('error'),
                    session()->get('errors')
                ]);
                echo json_encode(implode('<br>', array_map('esc', array_merge(...$errors))));
            } else {
                echo json_encode(esc(session()->get('error') ?? session()->get('errors')));
            }
        ?>,
        timer: 1500,
        timerProgressBar: true,
        showConfirmButton: false
    });
</script>
<?php endif; ?>

<?php if (session()->get('success')): ?>
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success',
        html: <?php 
            if (is_array(session()->get('success'))) {
                echo json_encode(implode('<br>', array_map('esc', session()->get('success'))));
            } else {
                echo json_encode(esc(session()->get('success')));
            }
        ?>,
        timer: 1500,
        timerProgressBar: true,
        showConfirmButton: false
    });
</script>
<?php endif; ?>

<?php 
session()->remove('error');
session()->remove('success');
session()->remove('errors');
?>
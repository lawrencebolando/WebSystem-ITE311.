<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('success') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>
    
    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <?= session()->getFlashdata('error') ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <?php if ($course): ?>
        <div class="card shadow-sm">
            <div class="card-body">
                <h2 class="card-title mb-3"><?= esc($course['title']) ?></h2>
                
                <div class="mb-3">
                    <p class="card-text"><?= esc($course['description'] ?? 'No description available.') ?></p>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <p><strong>Instructor:</strong> <?= esc($course['instructor_name'] ?? 'TBA') ?></p>
                        <?php if (isset($course['category'])): ?>
                            <p><strong>Category:</strong> <span class="badge bg-secondary"><?= esc($course['category']) ?></span></p>
                        <?php endif; ?>
                    </div>
                    <div class="col-md-6">
                        <?php if (isset($course['duration'])): ?>
                            <p><strong>Duration:</strong> <?= $course['duration'] ?> minutes</p>
                        <?php endif; ?>
                        <?php if (isset($course['price'])): ?>
                            <p><strong>Price:</strong> $<?= number_format($course['price'], 2) ?></p>
                        <?php endif; ?>
                        <p><strong>Status:</strong> <span class="badge bg-<?= $course['status'] === 'active' ? 'success' : 'secondary' ?>"><?= ucfirst($course['status']) ?></span></p>
                    </div>
                </div>
                
                <div class="mt-4">
                    <a href="<?= base_url('courses') ?>" class="btn btn-secondary">
                        <i class="bi bi-arrow-left"></i> Back to Courses
                    </a>
                    <?php if (session()->get('isLoggedIn') && session()->get('role') === 'student'): ?>
                        <button type="button" class="btn btn-primary enroll-btn" data-course-id="<?= $course['id'] ?>" data-course-title="<?= esc($course['title']) ?>">
                            <i class="bi bi-plus"></i> Enroll in Course
                        </button>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="alert alert-danger">
            Course not found.
        </div>
    <?php endif; ?>
</div>

<?php if (session()->get('isLoggedIn') && session()->get('role') === 'student'): ?>
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script>
$(document).ready(function() {
    function getCsrfToken() {
        let token = $('meta[name="csrf-token"]').attr('content');
        let tokenName = $('meta[name="csrf-token-name"]').attr('content');
        return { token: token, name: tokenName };
    }
    
    $('.enroll-btn').on('click', function() {
        const $button = $(this);
        const courseId = $button.data('course-id');
        const courseTitle = $button.data('course-title');
        
        $button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span> Enrolling...');
        
        const csrf = getCsrfToken();
        const postData = {
            course_id: courseId
        };
        postData[csrf.name] = csrf.token;
        
        $.ajax({
            url: '<?= base_url('course/enroll') ?>',
            type: 'POST',
            data: postData,
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    $button.removeClass('btn-primary').addClass('btn-success').html('<i class="bi bi-check"></i> Enrolled');
                    alert(response.message);
                } else {
                    alert(response.message);
                    $button.prop('disabled', false).html('<i class="bi bi-plus"></i> Enroll in Course');
                }
            },
            error: function() {
                alert('An error occurred. Please try again.');
                $button.prop('disabled', false).html('<i class="bi bi-plus"></i> Enroll in Course');
            }
        });
    });
});
</script>
<?php endif; ?>
<?= $this->endSection() ?>


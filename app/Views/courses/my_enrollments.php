<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <h2 class="mb-4">My Enrollments</h2>
    
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

    <?php if (!empty($enrollments)): ?>
        <div class="row g-4">
            <?php foreach ($enrollments as $enrollment): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title text-primary"><?= esc($enrollment['course_title'] ?? 'Course') ?></h5>
                            <p class="card-text text-muted small"><?= esc($enrollment['course_description'] ?? '') ?></p>
                            
                            <div class="mb-2">
                                <small class="text-muted">
                                    Enrolled: <?= date('M d, Y', strtotime($enrollment['enrollment_date'])) ?>
                                </small>
                            </div>
                            
                            <div class="mb-2">
                                <span class="badge bg-<?= $enrollment['status'] === 'active' ? 'success' : 'secondary' ?>">
                                    <?= ucfirst($enrollment['status']) ?>
                                </span>
                            </div>
                            
                            <div class="mt-2">
                                <div class="progress" style="height: 8px;">
                                    <div class="progress-bar" role="progressbar" style="width: <?= $enrollment['progress'] ?>%">
                                    </div>
                                </div>
                                <small class="text-muted"><?= number_format($enrollment['progress'], 1) ?>% Complete</small>
                            </div>
                            
                            <div class="mt-3">
                                <a href="<?= base_url('courses/' . $enrollment['course_id']) ?>" class="btn btn-sm btn-primary">
                                    <i class="bi bi-eye"></i> View Course
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> You are not enrolled in any courses yet.
            <a href="<?= base_url('courses') ?>" class="alert-link">Browse available courses</a>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>


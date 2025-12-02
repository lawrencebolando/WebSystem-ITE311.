<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <h2 class="mb-4">Available Courses</h2>
    
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

    <?php if (!empty($courses)): ?>
        <div class="row g-4">
            <?php foreach ($courses as $course): ?>
                <div class="col-md-6 col-lg-4">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title text-primary"><?= esc($course['title']) ?></h5>
                            <p class="card-text text-muted"><?= esc($course['description'] ?? 'No description available.') ?></p>
                            <div class="mb-2">
                                <small class="text-muted">
                                    <i class="bi bi-person"></i> Instructor: <?= esc($course['instructor_name'] ?? 'TBA') ?>
                                </small>
                            </div>
                            <?php if (isset($course['category'])): ?>
                                <div class="mb-2">
                                    <span class="badge bg-secondary"><?= esc($course['category']) ?></span>
                                </div>
                            <?php endif; ?>
                            <a href="<?= base_url('courses/' . $course['id']) ?>" class="btn btn-primary btn-sm">
                                <i class="bi bi-eye"></i> View Course
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info">
            <i class="bi bi-info-circle"></i> No courses available at the moment.
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>


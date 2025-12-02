<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="text-primary mb-0">Course Materials</h3>
            <p class="text-muted mb-0">Course: <strong><?= esc($course['title']) ?></strong></p>
        </div>
        <a href="<?= base_url('student/dashboard') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Dashboard
        </a>
    </div>

    <!-- Flash Messages -->
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

    <!-- Materials List -->
    <div class="card shadow-sm">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="bi bi-folder"></i> Available Materials (<?= count($materials) ?>)</h5>
        </div>
        <div class="card-body">
            <?php if (!empty($materials)): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>Size</th>
                                <th>Uploaded By</th>
                                <th>Date</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($materials as $material): ?>
                                <tr>
                                    <td>
                                        <i class="bi bi-file-earmark"></i>
                                        <?= esc($material['file_name']) ?>
                                    </td>
                                    <td>
                                        <?= number_format($material['file_size'] / 1024, 2) ?> KB
                                    </td>
                                    <td>
                                        <?= esc($material['uploaded_by_name'] ?? 'Unknown') ?>
                                    </td>
                                    <td>
                                        <?= date('M d, Y', strtotime($material['created_at'])) ?>
                                    </td>
                                    <td>
                                        <a href="<?= base_url('materials/download/' . $material['id']) ?>" 
                                           class="btn btn-sm btn-primary" 
                                           title="Download">
                                            <i class="bi bi-download"></i> Download
                                        </a>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-folder-x" style="font-size: 3rem;" class="text-muted mb-3"></i>
                    <p class="text-muted">No materials available for this course yet.</p>
                    <p class="text-muted small">Check back later for course materials.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>


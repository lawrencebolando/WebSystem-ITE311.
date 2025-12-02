<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="text-primary mb-0">Course Materials</h3>
            <p class="text-muted mb-0">Course: <strong><?= esc($course['title']) ?></strong></p>
        </div>
        <a href="<?= esc($backUrl ?? base_url('courses')) ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back
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
        <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
            <h5 class="mb-0"><i class="bi bi-folder"></i> Available Materials (<?= count($materials) ?>)</h5>
            <?php if (isset($canUpload) && $canUpload): ?>
                <a href="<?= base_url('admin/course/' . $course['id'] . '/upload') ?>" class="btn btn-success btn-sm">
                    <i class="bi bi-cloud-upload"></i> Upload Material
                </a>
            <?php endif; ?>
        </div>
        <div class="card-body">
            <?php if (!empty($materials)): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>File Name</th>
                                <th>Size</th>
                                <th>Type</th>
                                <th>Uploaded By</th>
                                <th>Date</th>
                                <th>Actions</th>
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
                                        <?php
                                        $size = $material['file_size'] ?? 0;
                                        if ($size >= 1048576) {
                                            echo number_format($size / 1048576, 2) . ' MB';
                                        } else {
                                            echo number_format($size / 1024, 2) . ' KB';
                                        }
                                        ?>
                                    </td>
                                    <td>
                                        <span class="badge bg-info"><?= esc($material['file_type'] ?? 'Unknown') ?></span>
                                    </td>
                                    <td>
                                        <?= esc($material['uploaded_by_name'] ?? 'Unknown') ?>
                                    </td>
                                    <td>
                                        <?= date('M d, Y', strtotime($material['created_at'])) ?>
                                    </td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?= base_url('materials/download/' . $material['id']) ?>" 
                                               class="btn btn-sm btn-primary" 
                                               title="Download">
                                                <i class="bi bi-download"></i> Download
                                            </a>
                                            <?php if (isset($canUpload) && $canUpload): ?>
                                                <a href="<?= base_url('materials/delete/' . $material['id']) ?>" 
                                                   class="btn btn-sm btn-danger" 
                                                   title="Delete"
                                                   onclick="return confirm('Are you sure you want to delete this material?');">
                                                    <i class="bi bi-trash"></i>
                                                </a>
                                            <?php endif; ?>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php else: ?>
                <div class="text-center py-5">
                    <i class="bi bi-folder-x" style="font-size: 3rem; color: #6c757d;"></i>
                    <p class="text-muted mt-3">No materials available for this course yet.</p>
                    <p class="text-muted small">Check back later for course materials.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>


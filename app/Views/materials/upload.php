<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h3 class="text-primary mb-0">Upload Material</h3>
            <p class="text-muted mb-0">Course: <strong><?= esc($course['title']) ?></strong></p>
        </div>
        <a href="<?= base_url('admin/courses') ?>" class="btn btn-secondary">
            <i class="bi bi-arrow-left"></i> Back to Courses
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

    <div class="row">
        <!-- Upload Form -->
        <div class="col-md-5">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-cloud-upload"></i> Upload New Material</h5>
                </div>
                <div class="card-body">
                    <form action="<?= base_url('admin/course/' . $course['id'] . '/upload') ?>" method="POST" enctype="multipart/form-data">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="material_file" class="form-label">Select File <span class="text-danger">*</span></label>
                            <input type="file" 
                                   class="form-control <?= ($validation->hasError('material_file')) ? 'is-invalid' : '' ?>" 
                                   id="material_file" 
                                   name="material_file" 
                                   accept=".pdf,.doc,.docx,.ppt,.pptx,.xls,.xlsx,.txt,.zip,.rar"
                                   required>
                            <?php if ($validation->hasError('material_file')): ?>
                                <div class="invalid-feedback">
                                    <?= $validation->getError('material_file') ?>
                                </div>
                            <?php endif; ?>
                            <small class="form-text text-muted">
                                Allowed formats: PDF, DOC, DOCX, PPT, PPTX, XLS, XLSX, TXT, ZIP, RAR<br>
                                Maximum file size: 10MB
                            </small>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-upload"></i> Upload Material
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Existing Materials List -->
        <div class="col-md-7">
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0"><i class="bi bi-folder"></i> Course Materials (<?= count($materials) ?>)</h5>
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
                                                <?= number_format($material['file_size'] / 1024, 2) ?> KB
                                            </td>
                                            <td>
                                                <?= esc($material['uploaded_by_name'] ?? 'Unknown') ?>
                                            </td>
                                            <td>
                                                <?= date('M d, Y', strtotime($material['created_at'])) ?>
                                            </td>
                                            <td>
                                                <div class="btn-group btn-group-sm" role="group">
                                                    <a href="<?= base_url('materials/download/' . $material['id']) ?>" 
                                                       class="btn btn-outline-primary" 
                                                       title="Download">
                                                        <i class="bi bi-download"></i>
                                                    </a>
                                                    <a href="<?= base_url('materials/delete/' . $material['id']) ?>" 
                                                       class="btn btn-outline-danger" 
                                                       title="Delete"
                                                       onclick="return confirm('Are you sure you want to delete this material? This action cannot be undone.');">
                                                        <i class="bi bi-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-folder-x" style="font-size: 3rem;" class="text-muted mb-3"></i>
                            <p class="text-muted">No materials uploaded yet.</p>
                            <p class="text-muted small">Upload your first material using the form on the left.</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>


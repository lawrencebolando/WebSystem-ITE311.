<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary mb-0">Manage Courses</h3>
        <a href="<?= base_url('admin/courses/create') ?>" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Create New Course
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

    <!-- Courses Table -->
    <div class="card shadow-sm">
        <div class="card-body">
            <?php if (!empty($courses)): ?>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Title</th>
                                <th>Instructor</th>
                                <th>Category</th>
                                <th>Level</th>
                                <th>Status</th>
                                <th>Created</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($courses as $course): ?>
                                <tr>
                                    <td><?= $course['id'] ?></td>
                                    <td>
                                        <strong><?= esc($course['title']) ?></strong>
                                        <?php if ($course['description']): ?>
                                            <br><small class="text-muted"><?= esc(substr($course['description'], 0, 50)) ?>...</small>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= esc($course['instructor_name'] ?? 'N/A') ?></td>
                                    <td><?= esc($course['category'] ?? 'N/A') ?></td>
                                    <td>
                                        <span class="badge bg-info"><?= ucfirst($course['level'] ?? 'beginner') ?></span>
                                    </td>
                                    <td>
                                        <?php
                                        $statusClass = 'secondary';
                                        if ($course['status'] === 'published') $statusClass = 'success';
                                        elseif ($course['status'] === 'draft') $statusClass = 'warning';
                                        elseif ($course['status'] === 'archived') $statusClass = 'dark';
                                        ?>
                                        <span class="badge bg-<?= $statusClass ?>"><?= ucfirst($course['status']) ?></span>
                                    </td>
                                    <td><?= date('M d, Y', strtotime($course['created_at'])) ?></td>
                                    <td>
                                        <div class="btn-group btn-group-sm" role="group">
                                            <a href="<?= base_url('admin/courses/edit/' . $course['id']) ?>" class="btn btn-outline-primary" title="Edit">
                                                <i class="bi bi-pencil"></i>
                                            </a>
                                            <a href="<?= base_url('admin/course/' . $course['id'] . '/upload') ?>" class="btn btn-outline-success" title="Upload Material">
                                                <i class="bi bi-cloud-upload"></i>
                                            </a>
                                            <a href="<?= base_url('admin/courses/delete/' . $course['id']) ?>" 
                                               class="btn btn-outline-danger" 
                                               title="Delete"
                                               onclick="return confirm('Are you sure you want to delete this course? This action cannot be undone.');">
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
                <div class="text-center py-5">
                    <i class="bi bi-book" style="font-size: 3rem;" class="text-muted mb-3"></i>
                    <p class="text-muted">No courses found.</p>
                    <a href="<?= base_url('admin/courses/create') ?>" class="btn btn-primary">
                        <i class="bi bi-plus-circle"></i> Create Your First Course
                    </a>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?= $this->endSection() ?>


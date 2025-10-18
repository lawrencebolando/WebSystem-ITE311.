<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3 class="text-primary">All Announcements</h3>
        <?php if (session()->get('role') === 'teacher' || session()->get('role') === 'admin'): ?>
            <a href="<?= base_url('add-announcement') ?>" class="btn btn-success">
                <i class="fas fa-plus"></i> Add New Announcement
            </a>
        <?php endif; ?>
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

    <?php if (!empty($announcements) && is_array($announcements)): ?>
        <div class="row g-3">
            <?php foreach ($announcements as $row): ?>
                <div class="col-md-12">
                    <div class="card shadow-sm">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-start mb-2">
                                <h5 class="card-title text-primary"><?= esc($row['title']) ?></h5>
                                <small class="text-muted"><?= date('M d, Y H:i', strtotime($row['created_at'])) ?></small>
                            </div>
                            <p class="card-text"><?= nl2br(esc($row['content'])) ?></p>
                            
                            <?php if (session()->get('role') === 'teacher' || session()->get('role') === 'admin'): ?>
                                <div class="btn-group" role="group">
                                    <a href="<?= base_url('edit-announcement/' . $row['id']) ?>" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                    <a href="<?= base_url('delete-announcement/' . $row['id']) ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this announcement?');">
                                        <i class="fas fa-trash"></i> Delete
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    <?php else: ?>
        <div class="alert alert-info text-center py-5">
            <i class="fas fa-inbox fa-3x mb-3"></i>
            <p class="mb-0">No announcements found.</p>
        </div>
    <?php endif; ?>
</div>
<?= $this->endSection() ?>

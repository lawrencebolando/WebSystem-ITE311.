<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <h3 class="mb-4 text-primary">Welcome, Teacher!</h3>

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

    <!-- Main Dashboard Cards -->
    <div class="row g-3 mb-4">
        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-bullhorn fa-3x text-primary mb-3"></i>
                    <h5 class="card-title">Manage Announcements</h5>
                    <p class="card-text text-muted">Create, edit, and manage announcements for your students.</p>
                    <a href="<?= base_url('add-announcement') ?>" class="btn btn-primary">
                        <i class="fas fa-plus"></i> Add Announcement
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-list fa-3x text-info mb-3"></i>
                    <h5 class="card-title">View All Announcements</h5>
                    <p class="card-text text-muted">See all announcements you've posted.</p>
                    <a href="<?= base_url('announcements') ?>" class="btn btn-info">
                        <i class="fas fa-eye"></i> View Announcements
                    </a>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Teacher Resources -->
    <div class="card shadow-sm">
        <div class="card-header fw-semibold">Quick Actions</div>
        <div class="card-body">
            <div class="d-grid gap-2 d-md-flex">
                <a href="<?= base_url('add-announcement') ?>" class="btn btn-success">
                    <i class="fas fa-pencil-alt"></i> Create New Announcement
                </a>
                <a href="<?= base_url('announcements') ?>" class="btn btn-secondary">
                    <i class="fas fa-list-ul"></i> View All Announcements
                </a>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <h3 class="mb-4 text-primary">Welcome, Admin!</h3>

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
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-bullhorn fa-3x text-success mb-3"></i>
                    <h5 class="card-title">Manage Announcements</h5>
                    <p class="card-text text-muted">Create and manage system announcements.</p>
                    <a href="<?= base_url('add-announcement') ?>" class="btn btn-success">
                        <i class="fas fa-plus"></i> Add Announcement
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-list fa-3x text-info mb-3"></i>
                    <h5 class="card-title">View Announcements</h5>
                    <p class="card-text text-muted">See all announcements in the system.</p>
                    <a href="<?= base_url('announcements') ?>" class="btn btn-info">
                        <i class="fas fa-eye"></i> View All
                    </a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <i class="fas fa-cog fa-3x text-warning mb-3"></i>
                    <h5 class="card-title">System Settings</h5>
                    <p class="card-text text-muted">Configure system settings and preferences.</p>
                    <button class="btn btn-warning" disabled>
                        <i class="fas fa-sliders-h"></i> Settings
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Additional Admin Resources -->
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

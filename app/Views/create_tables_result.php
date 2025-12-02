<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <h1 class="mb-4">🔧 Create Database Tables</h1>
    
    <?php foreach ($results as $tableName => $result): ?>
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title">
                    <?php if ($result['status'] === 'created'): ?>
                        <span class="badge bg-success">✅ Created</span>
                    <?php elseif ($result['status'] === 'exists'): ?>
                        <span class="badge bg-info">ℹ️ Exists</span>
                    <?php else: ?>
                        <span class="badge bg-danger">❌ Error</span>
                    <?php endif; ?>
                    <?= ucfirst($tableName) ?> Table
                </h5>
                <p class="card-text">
                    <?php if ($result['status'] === 'created'): ?>
                        <span class="text-success"><?= $result['message'] ?></span>
                    <?php elseif ($result['status'] === 'exists'): ?>
                        <span class="text-info"><?= $result['message'] ?></span>
                    <?php else: ?>
                        <span class="text-danger"><?= esc($result['message']) ?></span>
                    <?php endif; ?>
                </p>
            </div>
        </div>
    <?php endforeach; ?>
    
    <div class="alert alert-success mt-4">
        <h4>✅ Process Complete!</h4>
        <p><strong>All tables have been checked/created!</strong></p>
        <p>Now refresh your application page and the errors should be gone.</p>
        <div class="mt-3">
            <a href="<?= base_url('/') ?>" class="btn btn-primary">Go to Home Page</a>
            <a href="<?= base_url('announcements') ?>" class="btn btn-success">Test Announcements</a>
        </div>
    </div>
</div>
<?= $this->endSection() ?>


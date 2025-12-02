<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <h2 class="mb-4">Notifications System Test</h2>

    <div class="row">
        <div class="col-md-6">
            <div class="card mb-3">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">System Status</h5>
                </div>
                <div class="card-body">
                    <p><strong>Table Exists:</strong> 
                        <?php if ($table_exists): ?>
                            <span class="badge bg-success">YES ✓</span>
                        <?php else: ?>
                            <span class="badge bg-danger">NO ✗</span>
                            <br><small class="text-danger">Run migration: <code>php spark migrate</code></small>
                        <?php endif; ?>
                    </p>
                    <p><strong>User ID:</strong> <?= $user_id ?></p>
                    <p><strong>Unread Count:</strong> <span class="badge bg-danger"><?= $unread_count ?></span></p>
                </div>
            </div>

            <div class="card mb-3">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">Test Notification Creation</h5>
                </div>
                <div class="card-body">
                    <?php if ($test_created): ?>
                        <div class="alert alert-success">
                            ✓ Test notification created successfully!
                        </div>
                    <?php elseif ($test_error): ?>
                        <div class="alert alert-danger">
                            ✗ Error: <?= esc($test_error) ?>
                        </div>
                    <?php else: ?>
                        <div class="alert alert-warning">
                            Cannot create test notification (table doesn't exist)
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card">
                <div class="card-header bg-secondary text-white">
                    <h5 class="mb-0">Your Notifications (<?= count($notifications) ?>)</h5>
                </div>
                <div class="card-body">
                    <?php if (empty($notifications)): ?>
                        <p class="text-muted">No notifications found.</p>
                    <?php else: ?>
                        <div class="list-group">
                            <?php foreach ($notifications as $notification): ?>
                                <div class="list-group-item <?= $notification['is_read'] == 0 ? 'bg-light' : '' ?>">
                                    <div class="d-flex justify-content-between">
                                        <div>
                                            <?php if ($notification['is_read'] == 0): ?>
                                                <span class="badge bg-primary">NEW</span>
                                            <?php endif; ?>
                                            <strong><?= esc($notification['message']) ?></strong>
                                            <br>
                                            <small class="text-muted"><?= $notification['created_at'] ?></small>
                                        </div>
                                        <div>
                                            <?php if ($notification['is_read'] == 0): ?>
                                                <span class="badge bg-danger">Unread</span>
                                            <?php else: ?>
                                                <span class="badge bg-success">Read</span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-4">
        <h4>Next Steps:</h4>
        <ol>
            <li>If table doesn't exist, run: <code>php spark migrate</code></li>
            <li>Refresh this page to create a test notification</li>
            <li>Check the navigation bar for the notification badge</li>
            <li>Click the bell icon to see notifications</li>
        </ol>
    </div>
</div>
<?= $this->endSection() ?>


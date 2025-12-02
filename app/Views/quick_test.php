<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <h1 class="mb-4">⚡ Quick Notification Test</h1>
    
    <div class="alert alert-info">
        <strong>This page tests notifications directly without AJAX.</strong>
    </div>
    
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>Database Status</h5>
                </div>
                <div class="card-body">
                    <p><strong>Table Exists:</strong> 
                        <?php if ($tableExists): ?>
                            <span class="badge bg-success">YES</span>
                        <?php else: ?>
                            <span class="badge bg-danger">NO</span>
                            <br><a href="<?= base_url('create-tables') ?>" class="btn btn-sm btn-primary mt-2">Create Table</a>
                        <?php endif; ?>
                    </p>
                    <p><strong>User ID:</strong> <?= $userId ?? 'N/A' ?></p>
                    <p><strong>Unread Count:</strong> <?= $unreadCount ?? 0 ?></p>
                    <p><strong>Total Notifications:</strong> <?= count($notifications ?? []) ?></p>
                </div>
            </div>
        </div>
        
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">
                    <h5>API Test</h5>
                </div>
                <div class="card-body">
                    <p><strong>API URL:</strong> <code><?= $apiUrl ?? 'N/A' ?></code></p>
                    <p><strong>HTTP Code:</strong> 
                        <?php if (isset($apiHttpCode)): ?>
                            <?php if ($apiHttpCode == 200): ?>
                                <span class="badge bg-success"><?= $apiHttpCode ?></span>
                            <?php else: ?>
                                <span class="badge bg-danger"><?= $apiHttpCode ?></span>
                            <?php endif; ?>
                        <?php else: ?>
                            <span class="badge bg-secondary">Not tested</span>
                        <?php endif; ?>
                    </p>
                    <?php if (isset($testApiResponse)): ?>
                        <pre class="bg-light p-2 rounded small"><?= json_encode($testApiResponse, JSON_PRETTY_PRINT) ?></pre>
                    <?php endif; ?>
                    <?php if (isset($apiError)): ?>
                        <div class="alert alert-danger"><?= esc($apiError) ?></div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
    
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Your Notifications (Direct from Database)</h5>
            <a href="<?= base_url('notification-debug/create-test') ?>" class="btn btn-sm btn-success">Create Test Notification</a>
        </div>
        <div class="card-body">
            <?php if (isset($error)): ?>
                <div class="alert alert-danger"><?= esc($error) ?></div>
            <?php elseif (empty($notifications)): ?>
                <div class="alert alert-warning">
                    <strong>No notifications found.</strong>
                    <?php if ($tableExists): ?>
                        <br>Click "Create Test Notification" above to create one.
                    <?php else: ?>
                        <br>Create the table first, then create a notification.
                    <?php endif; ?>
                </div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Message</th>
                                <th>Read</th>
                                <th>Created</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($notifications as $notif): ?>
                                <tr class="<?= $notif['is_read'] ? '' : 'table-warning' ?>">
                                    <td><?= $notif['id'] ?></td>
                                    <td><?= esc($notif['message']) ?></td>
                                    <td>
                                        <?php if ($notif['is_read']): ?>
                                            <span class="badge bg-success">Read</span>
                                        <?php else: ?>
                                            <span class="badge bg-danger">Unread</span>
                                        <?php endif; ?>
                                    </td>
                                    <td><?= $notif['created_at'] ?></td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <div class="mt-4">
        <a href="<?= base_url('dashboard') ?>" class="btn btn-primary">Back to Dashboard</a>
        <a href="<?= base_url('notification-debug') ?>" class="btn btn-info">Full Debug Page</a>
    </div>
</div>
<?= $this->endSection() ?>


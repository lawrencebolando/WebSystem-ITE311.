<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <h1 class="mb-4">🔍 Notification System Debug</h1>
    
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
        <div class="col-md-12">
            <!-- Status Cards -->
            <div class="row mb-4">
                <div class="col-md-4">
                    <div class="card <?= $tableExists ? 'border-success' : 'border-danger' ?>">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?= $tableExists ? '✅' : '❌' ?> Table Status
                            </h5>
                            <p class="card-text">
                                <?= $tableExists ? 'Notifications table exists' : 'Notifications table NOT found' ?>
                            </p>
                            <?php if (!$tableExists): ?>
                                <a href="<?= base_url('create-tables') ?>" class="btn btn-primary btn-sm">Create Table</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card <?= $isLoggedIn ? 'border-success' : 'border-warning' ?>">
                        <div class="card-body">
                            <h5 class="card-title">
                                <?= $isLoggedIn ? '✅' : '⚠️' ?> Login Status
                            </h5>
                            <p class="card-text">
                                <?= $isLoggedIn ? 'Logged in' : 'Not logged in' ?>
                            </p>
                            <?php if ($isLoggedIn): ?>
                                <small class="text-muted">User ID: <?= $userId ?? 'N/A' ?></small>
                            <?php else: ?>
                                <a href="<?= base_url('login') ?>" class="btn btn-warning btn-sm">Login</a>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="card border-info">
                        <div class="card-body">
                            <h5 class="card-title">📊 Statistics</h5>
                            <p class="card-text">
                                <strong>Unread:</strong> <?= $unreadCount ?? 0 ?><br>
                                <strong>Total:</strong> <?= count($allNotifications ?? []) ?>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Actions -->
            <div class="card mb-4">
                <div class="card-header">
                    <h5>Actions</h5>
                </div>
                <div class="card-body">
                    <a href="<?= base_url('notification-debug/create-test') ?>" class="btn btn-success me-2">
                        <i class="bi bi-plus-circle"></i> Create Test Notification
                    </a>
                    <a href="<?= base_url('test-notification/create') ?>" class="btn btn-primary me-2">
                        <i class="bi bi-bell"></i> Create via Test Controller
                    </a>
                    <a href="<?= base_url('notifications') ?>" class="btn btn-info me-2" target="_blank">
                        <i class="bi bi-arrow-right"></i> Test API Endpoint
                    </a>
                    <button onclick="location.reload()" class="btn btn-secondary">
                        <i class="bi bi-arrow-clockwise"></i> Refresh
                    </button>
                </div>
            </div>
            
            <!-- Notifications List -->
            <div class="card">
                <div class="card-header">
                    <h5>Your Notifications</h5>
                </div>
                <div class="card-body">
                    <?php if (isset($error)): ?>
                        <div class="alert alert-danger">
                            <strong>Error:</strong> <?= esc($error) ?>
                        </div>
                    <?php endif; ?>
                    
                    <?php if (empty($allNotifications)): ?>
                        <div class="alert alert-info">
                            <strong>No notifications found.</strong>
                            <?php if ($tableExists && $isLoggedIn): ?>
                                <br>Click "Create Test Notification" above to create one.
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
                                        <th>Created At</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($allNotifications as $notif): ?>
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
                                            <td>
                                                <?php if (!$notif['is_read']): ?>
                                                    <a href="<?= base_url('notifications/mark_read/' . $notif['id']) ?>" class="btn btn-sm btn-outline-primary">
                                                        Mark as Read
                                                    </a>
                                                <?php endif; ?>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            
            <!-- Debug Info -->
            <div class="card mt-4">
                <div class="card-header">
                    <h5>Debug Information</h5>
                </div>
                <div class="card-body">
                    <pre class="bg-light p-3 rounded"><code><?php
echo "Table Exists: " . ($tableExists ? 'YES' : 'NO') . "\n";
echo "Logged In: " . ($isLoggedIn ? 'YES' : 'NO') . "\n";
echo "User ID: " . ($userId ?? 'N/A') . "\n";
echo "Unread Count: " . ($unreadCount ?? 0) . "\n";
echo "Total Notifications: " . count($allNotifications ?? []) . "\n";
echo "\n";
echo "API Endpoint: " . base_url('notifications') . "\n";
echo "Test Create: " . base_url('test-notification/create') . "\n";
                    ?></code></pre>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>


<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <h1 class="mb-4">🔍 Notification System Diagnostic</h1>
    
    <div class="alert alert-info">
        <strong>This page will test everything and tell you exactly what's wrong.</strong>
    </div>
    
    <!-- Diagnostic Results -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Diagnostic Results</h5>
        </div>
        <div class="card-body">
            <?php foreach ($diagnostics as $testName => $result): ?>
                <div class="row mb-3 pb-3 border-bottom">
                    <div class="col-md-3">
                        <strong><?= ucfirst(str_replace('_', ' ', $testName)) ?>:</strong>
                    </div>
                    <div class="col-md-9">
                        <?php
                        $badgeClass = 'bg-secondary';
                        if ($result['status'] === 'pass') $badgeClass = 'bg-success';
                        if ($result['status'] === 'fail') $badgeClass = 'bg-danger';
                        if ($result['status'] === 'warning') $badgeClass = 'bg-warning';
                        if ($result['status'] === 'info') $badgeClass = 'bg-info';
                        if ($result['status'] === 'skip') $badgeClass = 'bg-secondary';
                        ?>
                        <span class="badge <?= $badgeClass ?> me-2"><?= strtoupper($result['status']) ?></span>
                        <span><?= $result['message'] ?></span>
                        <?php if (isset($result['value'])): ?>
                            <br><small class="text-muted">Value: <strong><?= $result['value'] ?></strong></small>
                        <?php endif; ?>
                        <?php if (isset($result['notification_id'])): ?>
                            <br><small class="text-success">✅ Test notification created with ID: <?= $result['notification_id'] ?></small>
                        <?php endif; ?>
                        <?php if (isset($result['unread_count'])): ?>
                            <br><small class="text-info">Unread: <?= $result['unread_count'] ?>, Total: <?= $result['notifications_count'] ?? 0 ?></small>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <!-- Fixes -->
    <div class="card mb-4">
        <div class="card-header bg-warning">
            <h5 class="mb-0">🔧 Recommended Fixes</h5>
        </div>
        <div class="card-body">
            <?php if (!$diagnostics['logged_in']['status'] === 'pass'): ?>
                <div class="alert alert-danger">
                    <strong>❌ NOT LOGGED IN</strong><br>
                    <a href="<?= base_url('login') ?>" class="btn btn-primary btn-sm">Login Now</a>
                </div>
            <?php endif; ?>
            
            <?php if ($diagnostics['table_exists']['status'] === 'fail'): ?>
                <div class="alert alert-danger">
                    <strong>❌ TABLE DOES NOT EXIST</strong><br>
                    <p>You need to create the notifications table first.</p>
                    <a href="<?= base_url('create-tables') ?>" class="btn btn-primary">Create Table</a>
                </div>
            <?php endif; ?>
            
            <?php if ($diagnostics['notifications_in_db']['status'] === 'warning'): ?>
                <div class="alert alert-warning">
                    <strong>⚠️ NO NOTIFICATIONS IN DATABASE</strong><br>
                    <p>You need to create a notification to test.</p>
                    <a href="<?= base_url('notification-debug/create-test') ?>" class="btn btn-success">Create Test Notification</a>
                </div>
            <?php endif; ?>
            
            <?php if ($diagnostics['api_endpoint']['status'] === 'fail'): ?>
                <div class="alert alert-danger">
                    <strong>❌ API ENDPOINT FAILING</strong><br>
                    <p>Check the error message above and fix the issue.</p>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Notifications List -->
    <?php if (!empty($notifications)): ?>
        <div class="card">
            <div class="card-header">
                <h5>Your Notifications (Last 10)</h5>
            </div>
            <div class="card-body">
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
            </div>
        </div>
    <?php endif; ?>
    
    <!-- Actions -->
    <div class="mt-4">
        <a href="<?= base_url('dashboard') ?>" class="btn btn-primary">Back to Dashboard</a>
        <a href="<?= base_url('notification-debug') ?>" class="btn btn-info">Debug Page</a>
        <a href="<?= base_url('quick-test') ?>" class="btn btn-secondary">Quick Test</a>
        <button onclick="location.reload()" class="btn btn-success">Refresh Diagnostic</button>
    </div>
    
    <!-- JavaScript Test -->
    <div class="card mt-4">
        <div class="card-header">
            <h5>JavaScript Test</h5>
        </div>
        <div class="card-body">
            <p>Open your browser console (F12) and check for these messages:</p>
            <ul>
                <li>🔔 Notifications script loaded</li>
                <li>📡 Fetching notifications</li>
                <li>✅ Notifications response received</li>
            </ul>
            <button onclick="testNotificationAPI()" class="btn btn-primary">Test API Call</button>
            <div id="api-test-result" class="mt-3"></div>
        </div>
    </div>
</div>

<script>
function testNotificationAPI() {
    const resultDiv = document.getElementById('api-test-result');
    resultDiv.innerHTML = '<div class="spinner-border spinner-border-sm"></div> Testing...';
    
    fetch('<?= base_url('notifications') ?>')
        .then(response => response.json())
        .then(data => {
            console.log('API Test Result:', data);
            if (data.success) {
                resultDiv.innerHTML = `
                    <div class="alert alert-success">
                        <strong>✅ API Works!</strong><br>
                        Unread Count: ${data.unread_count}<br>
                        Notifications: ${data.notifications.length}
                    </div>
                `;
            } else {
                resultDiv.innerHTML = `
                    <div class="alert alert-danger">
                        <strong>❌ API Error:</strong><br>
                        ${data.message || 'Unknown error'}
                    </div>
                `;
            }
        })
        .catch(error => {
            console.error('API Test Error:', error);
            resultDiv.innerHTML = `
                <div class="alert alert-danger">
                    <strong>❌ API Test Failed:</strong><br>
                    ${error.message}
                </div>
            `;
        });
}
</script>
<?= $this->endSection() ?>


<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="csrf-token" content="<?= csrf_hash() ?>">
    <meta name="csrf-token-name" content="<?= csrf_token() ?>">

    <title><?= esc($title ?? 'Home') ?> - ITE311-BOLANDO</title>

    

    <!-- Bootstrap CSS -->

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">

    

    <!-- Bootstrap Icons (optional) -->

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">

</head>

<body>

    <!-- Navigation Bar -->

    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">

        <div class="container">

            <a class="navbar-brand" href="<?= base_url('/') ?>">ITE311-BOLANDO</a>

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">

                <span class="navbar-toggler-icon"></span>

            </button>

            <div class="collapse navbar-collapse" id="navbarNav">

                <ul class="navbar-nav ms-auto">

                    <li class="nav-item">

                        <a class="nav-link <?= (uri_string() == '' || uri_string() == 'home') ? 'active' : '' ?>" href="<?= base_url('/') ?>">Home</a>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link <?= uri_string() == 'about' ? 'active' : '' ?>" href="<?= base_url('about') ?>">About</a>

                    </li>

                    <li class="nav-item">

                        <a class="nav-link <?= uri_string() == 'contact' ? 'active' : '' ?>" href="<?= base_url('contact') ?>">Contact</a>

                    </li>

                    <?php if (session()->get('isLoggedIn')): ?>

                        <?php $userRole = session()->get('role'); ?>

                        <li class="nav-item">

                            <a class="nav-link <?= uri_string() == 'dashboard' ? 'active' : '' ?>" href="<?= base_url('dashboard') ?>">

                                <i class="bi bi-speedometer2"></i> Dashboard

                            </a>

                        </li>

                        <!-- Notifications Dropdown -->
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle position-relative" href="#" id="notificationsDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-bell"></i> Notifications
                                <span class="badge bg-danger position-absolute top-0 start-100 translate-middle" id="notification-badge" style="display: none;">0</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="notificationsDropdown" style="min-width: 300px; max-height: 400px; overflow-y: auto;">
                                <li><h6 class="dropdown-header">Notifications</h6></li>
                                <li><hr class="dropdown-divider"></li>
                                <li id="notifications-list">
                                    <div class="px-3 py-2 text-center text-muted">
                                        <small>Loading notifications...</small>
                                    </div>
                                </li>
                                <li id="no-notifications" style="display: none;">
                                    <div class="px-3 py-2 text-center text-muted">
                                        <small>No notifications</small>
                                    </div>
                                </li>
                            </ul>
                        </li>

                        <?php if ($userRole === 'admin'): ?>

                            <li class="nav-item dropdown">

                                <a class="nav-link dropdown-toggle" href="#" id="adminDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                                    <i class="bi bi-gear"></i> Admin

                                </a>

                                <ul class="dropdown-menu" aria-labelledby="adminDropdown">

                                    <li><a class="dropdown-item" href="#"><i class="bi bi-people"></i> Manage Users</a></li>

                                    <li><a class="dropdown-item" href="<?= base_url('admin/courses') ?>"><i class="bi bi-book"></i> Manage Courses</a></li>

                                    <li><a class="dropdown-item" href="#"><i class="bi bi-bar-chart"></i> Reports</a></li>

                                    <li><hr class="dropdown-divider"></li>

                                    <li><a class="dropdown-item" href="#"><i class="bi bi-sliders"></i> Settings</a></li>

                                </ul>

                            </li>

                        <?php elseif ($userRole === 'instructor'): ?>

                            <li class="nav-item dropdown">

                                <a class="nav-link dropdown-toggle" href="#" id="instructorDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">

                                    <i class="bi bi-person-badge"></i> Instructor

                                </a>

                                <ul class="dropdown-menu" aria-labelledby="instructorDropdown">

                                    <li><a class="dropdown-item" href="#"><i class="bi bi-book"></i> My Courses</a></li>

                                    <li><a class="dropdown-item" href="#"><i class="bi bi-people"></i> My Students</a></li>

                                    <li><a class="dropdown-item" href="#"><i class="bi bi-clipboard-check"></i> Grade Submissions</a></li>

                                </ul>

                            </li>

                        <?php else: ?>

                            <li class="nav-item">

                                <a class="nav-link" href="#">

                                    <i class="bi bi-book"></i> My Courses

                                </a>

                            </li>

                            <li class="nav-item">

                                <a class="nav-link" href="#">

                                    <i class="bi bi-clipboard-check"></i> My Progress

                                </a>

                            </li>

                        <?php endif; ?>

                        <li class="nav-item">

                            <a class="nav-link" href="<?= base_url('logout') ?>">

                                <i class="bi bi-box-arrow-right"></i> Logout

                            </a>

                        </li>

                    <?php else: ?>

                        <li class="nav-item">

                            <a class="nav-link <?= uri_string() == 'login' ? 'active' : '' ?>" href="<?= base_url('login') ?>">Login</a>

                        </li>

                        <li class="nav-item">

                            <a class="nav-link <?= uri_string() == 'register' ? 'active' : '' ?>" href="<?= base_url('register') ?>">Register</a>

                        </li>

                    <?php endif; ?>

                </ul>

            </div>

        </div>

    </nav>

    <!-- Main Content -->

    <main class="container my-5">

        <?= $this->renderSection('content') ?>

    </main>

    <!-- Footer -->

    <footer class="bg-light text-center py-3 mt-5">

        <div class="container">

            <p class="mb-0">&copy; <?= date('Y') ?> ITE311-BOLANDO. All rights reserved.</p>

        </div>

    </footer>

    <!-- Bootstrap JS Bundle -->

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL" crossorigin="anonymous"></script>
    
    <!-- jQuery (if not already included) -->
    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>
    
    <!-- Notifications System -->
    <?php if (session()->get('isLoggedIn')): ?>
    <script>
    $(document).ready(function() {
        console.log('🔔 Notifications script loaded');
        console.log('User logged in: <?= session()->get("isLoggedIn") ? "YES" : "NO" ?>');
        console.log('User ID: <?= session()->get("user_id") ?? "N/A" ?>');
        
        // Function to fetch notifications
        function fetchNotifications() {
            console.log('📡 Fetching notifications from: <?= base_url("notifications") ?>');
            
            $.ajax({
                url: '<?= base_url('notifications') ?>',
                type: 'GET',
                dataType: 'json',
                timeout: 10000, // 10 second timeout
                success: function(response) {
                    console.log('✅ Notifications response received:', response);
                    if (response.success) {
                        console.log('📊 Unread count:', response.unread_count);
                        console.log('📋 Notifications:', response.notifications);
                        updateNotificationBadge(response.unread_count);
                        updateNotificationList(response.notifications);
                    } else {
                        console.error('❌ Notification fetch failed:', response.message);
                        // Show user-friendly error message
                        if (response.message && response.message.includes('table does not exist')) {
                            $('#notifications-list').html('<div class="px-3 py-2 text-warning"><small>⚠️ Notifications table not found. <a href="<?= base_url("create-tables") ?>" class="text-primary">Create it now</a></small></div>');
                        } else {
                            $('#notifications-list').html('<div class="px-3 py-2 text-muted"><small>' + (response.message || 'No notifications available') + '</small></div>');
                        }
                    }
                },
                error: function(xhr, status, error) {
                    console.error('❌ Error fetching notifications:', error);
                    console.error('Status:', xhr.status);
                    console.error('Status Text:', status);
                    console.error('Response:', xhr.responseText);
                    
                    let errorMsg = 'Error loading notifications.';
                    if (xhr.status === 404) {
                        errorMsg = 'Notifications endpoint not found (404). Check routes.';
                    } else if (xhr.status === 500) {
                        errorMsg = 'Server error (500). Check if notifications table exists.';
                    } else if (status === 'timeout') {
                        errorMsg = 'Request timeout. Server may be slow.';
                    } else if (xhr.status === 0) {
                        errorMsg = 'Network error. Check internet connection.';
                    }
                    
                    // Show error in dropdown
                    $('#notifications-list').html('<div class="px-3 py-2 text-danger"><small>' + errorMsg + ' <a href="<?= base_url("notification-debug") ?>" class="text-primary">Debug</a> | <a href="<?= base_url("create-tables") ?>" class="text-primary">Create Table</a></small></div>');
                }
            });
        }

        // Update notification badge
        function updateNotificationBadge(count) {
            console.log('🏷️ Updating badge with count:', count);
            const $badge = $('#notification-badge');
            if (count > 0) {
                $badge.text(count).show();
                console.log('✅ Badge shown with count:', count);
            } else {
                $badge.hide();
                console.log('ℹ️ Badge hidden (count is 0)');
            }
        }

        // Update notification list
        function updateNotificationList(notifications) {
            console.log('📝 Updating notification list with:', notifications);
            const $list = $('#notifications-list');
            const $noNotifications = $('#no-notifications');
            
            if (!notifications || notifications.length === 0) {
                console.log('ℹ️ No notifications to display');
                $list.hide();
                $noNotifications.show();
                return;
            }
            
            console.log('✅ Displaying', notifications.length, 'notifications');
            $noNotifications.hide();
            $list.show().empty();
            
            notifications.forEach(function(notification) {
                const readClass = notification.is_read ? '' : 'bg-light';
                const readIcon = notification.is_read ? '' : '<i class="bi bi-circle-fill text-primary" style="font-size: 0.5rem;"></i> ';
                
                const notificationItem = `
                    <li>
                        <div class="dropdown-item-text ${readClass} px-3 py-2">
                            <div class="d-flex justify-content-between align-items-start">
                                <div class="flex-grow-1">
                                    ${readIcon}${notification.message}
                                    <br>
                                    <small class="text-muted">${notification.time_ago}</small>
                                </div>
                                ${!notification.is_read ? `
                                <button class="btn btn-sm btn-outline-primary ms-2 mark-read-btn" data-id="${notification.id}" title="Mark as read">
                                    <i class="bi bi-check"></i>
                                </button>
                                ` : ''}
                            </div>
                        </div>
                    </li>
                `;
                $list.append(notificationItem);
            });
        }

        // Mark notification as read
        $(document).on('click', '.mark-read-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const notificationId = $(this).data('id');
            const $button = $(this);
            
            $button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm"></span>');
            
            // Get CSRF token
            const csrfToken = $('meta[name="csrf-token"]').attr('content');
            const csrfTokenName = $('meta[name="csrf-token-name"]').attr('content');
            const postData = {};
            postData[csrfTokenName] = csrfToken;
            
            $.ajax({
                url: '<?= base_url('notifications/mark_read/') ?>' + notificationId,
                type: 'POST',
                dataType: 'json',
                data: postData,
                headers: {
                    'X-Requested-With': 'XMLHttpRequest',
                    'X-CSRF-TOKEN': csrfToken
                },
                success: function(response) {
                    console.log('Mark as read response:', response);
                    if (response.success) {
                        // Refresh notifications
                        fetchNotifications();
                    } else {
                        console.error('Mark as read failed:', response.message);
                        alert(response.message || 'Failed to mark notification as read.');
                        $button.prop('disabled', false).html('<i class="bi bi-check"></i>');
                    }
                },
                error: function(xhr, status, error) {
                    console.error('Error marking notification as read:', error);
                    console.error('Response:', xhr.responseText);
                    if (xhr.status === 403) {
                        alert('CSRF token expired. Please refresh the page.');
                        setTimeout(function() { location.reload(); }, 2000);
                    } else {
                        alert('An error occurred. Please try again.');
                    }
                    $button.prop('disabled', false).html('<i class="bi bi-check"></i>');
                }
            });
        });

        // Fetch notifications on page load
        fetchNotifications();
        
        // Refresh notifications every 60 seconds
        setInterval(fetchNotifications, 60000);
    });
    </script>
    <?php endif; ?>

</body>

</html>

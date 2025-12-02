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

</body>

</html>

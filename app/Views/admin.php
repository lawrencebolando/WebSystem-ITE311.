<<<<<<< HEAD
<div class="container py-4">
  <h3 class="mb-3 text-primary">Admin Dashboard</h3>
  <p>Welcome, <?= esc($name) ?>!</p>
=======
<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container py-4">
  <h3 class="mb-3 text-primary">Admin Dashboard</h3>
>>>>>>> 4a1a97d7431256126dcbdcf0e1514639c3bfc431

  <div class="row g-3">
    <div class="col-md-3">
      <div class="card shadow-sm">
        <div class="card-body">
          <h6 class="text-muted mb-1">Total Users</h6>
<<<<<<< HEAD
          <div class="fs-4 fw-semibold">—</div>
=======
          <div class="fs-4 fw-semibold"><?= $totalUsers ?? 0 ?></div>
>>>>>>> 4a1a97d7431256126dcbdcf0e1514639c3bfc431
        </div>
      </div>
    </div>
    <div class="col-md-3">
      <div class="card shadow-sm">
        <div class="card-body">
          <h6 class="text-muted mb-1">Total Courses</h6>
<<<<<<< HEAD
          <div class="fs-4 fw-semibold">—</div>
=======
          <div class="fs-4 fw-semibold"><?= $totalCourses ?? 0 ?></div>
>>>>>>> 4a1a97d7431256126dcbdcf0e1514639c3bfc431
        </div>
      </div>
    </div>
  </div>

  <div class="card mt-4 shadow-sm">
<<<<<<< HEAD
=======
    <div class="card-header fw-semibold">Announcements</div>
    <div class="card-body">
      <a href="<?= base_url('add-announcement') ?>" class="btn btn-success me-2">Add Announcement</a>
      <a href="<?= base_url('announcements') ?>" class="btn btn-primary">View All Announcements</a>
    </div>
  </div>

  <div class="card mt-4 shadow-sm">
>>>>>>> 4a1a97d7431256126dcbdcf0e1514639c3bfc431
    <div class="card-header fw-semibold">Recent Activity</div>
    <div class="card-body">
      <p class="text-muted mb-0">No recent activity to show.</p>
    </div>
  </div>
<<<<<<< HEAD
</div>
=======
</div>
<?= $this->endSection() ?>
>>>>>>> 4a1a97d7431256126dcbdcf0e1514639c3bfc431

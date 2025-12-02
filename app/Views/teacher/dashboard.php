<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container py-4">
  <h3 class="mb-3 text-primary"><i class="bi bi-person-badge"></i> Teacher Dashboard</h3>
  <p class="lead">Welcome back, <?= esc($user['name'] ?? 'Teacher') ?>!</p>

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

  <!-- Statistics Cards -->
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="card shadow-sm border-primary">
        <div class="card-body">
          <h6 class="text-muted mb-1"><i class="bi bi-book"></i> My Courses</h6>
          <div class="fs-2 fw-bold text-primary"><?= $totalCourses ?? 0 ?></div>
          <small class="text-muted">Total courses you're teaching</small>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm border-success">
        <div class="card-body">
          <h6 class="text-muted mb-1"><i class="bi bi-people"></i> Total Students</h6>
          <div class="fs-2 fw-bold text-success"><?= $totalStudents ?? 0 ?></div>
          <small class="text-muted">Students enrolled in your courses</small>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm border-info">
        <div class="card-body">
          <h6 class="text-muted mb-1"><i class="bi bi-clipboard-check"></i> Pending Grading</h6>
          <div class="fs-2 fw-bold text-info">0</div>
          <small class="text-muted">Submissions awaiting review</small>
        </div>
      </div>
    </div>
  </div>

  <!-- My Courses Section -->
  <div class="card shadow-sm mb-3">
    <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
      <span><i class="bi bi-book"></i> My Courses</span>
      <a href="<?= base_url('courses') ?>" class="btn btn-sm btn-primary">Create New Course</a>
    </div>
    <div class="card-body">
      <?php if (!empty($myCourses)): ?>
        <div class="row g-3">
          <?php foreach ($myCourses as $course): ?>
            <div class="col-md-6 col-lg-4">
              <div class="card border-0 bg-light h-100">
                <div class="card-body">
                  <h6 class="card-title text-primary"><?= esc($course['title']) ?></h6>
                  <p class="card-text text-muted small"><?= esc(substr($course['description'] ?? '', 0, 100)) ?>...</p>
                  <div class="d-flex justify-content-between align-items-center">
                    <span class="badge bg-<?= $course['status'] === 'active' ? 'success' : 'secondary' ?>">
                      <?= ucfirst($course['status']) ?>
                    </span>
                    <small class="text-muted">
                      <?= ($course['student_count'] ?? 0) ?> students
                    </small>
                  </div>
                  <div class="mt-2">
                    <a href="<?= base_url('courses/' . $course['id']) ?>" class="btn btn-sm btn-outline-primary">View Course</a>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="text-center py-4">
          <i class="bi bi-book" style="font-size: 3rem;" class="text-muted mb-3"></i>
          <p class="text-muted">You haven't created any courses yet.</p>
          <a href="<?= base_url('courses') ?>" class="btn btn-primary">Create Your First Course</a>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Quick Actions -->
  <div class="row g-3">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-header fw-semibold"><i class="bi bi-megaphone"></i> Announcements</div>
        <div class="card-body">
          <a href="<?= base_url('add-announcement') ?>" class="btn btn-success me-2">
            <i class="bi bi-plus-circle"></i> Add Announcement
          </a>
          <a href="<?= base_url('announcements') ?>" class="btn btn-primary">
            <i class="bi bi-list"></i> View All
          </a>
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="card shadow-sm">
        <div class="card-header fw-semibold"><i class="bi bi-clipboard-check"></i> Submissions</div>
        <div class="card-body">
          <p class="text-muted mb-0">No new submissions to review.</p>
          <a href="#" class="btn btn-sm btn-outline-primary mt-2">View All Submissions</a>
        </div>
      </div>
    </div>
  </div>
</div>
<?= $this->endSection() ?>


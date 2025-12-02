<div class="container py-4" style="max-height: calc(100vh - 200px); overflow-y: auto;">
  <h3 class="mb-3 text-primary">Student Dashboard</h3>
  
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

  <!-- Enrolled Courses Section -->
  <div class="card shadow-sm mb-4">
    <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
      <span>My Enrolled Courses</span>
      <span class="badge bg-primary"><?= count($enrollments ?? []) ?></span>
    </div>
    <div class="card-body">
      <?php if (!empty($enrollments)): ?>
        <div class="row g-3">
          <?php foreach ($enrollments as $enrollment): ?>
            <div class="col-md-6 col-lg-4">
              <div class="card border-0 bg-light">
                <div class="card-body">
                  <h6 class="card-title text-primary"><?= esc($enrollment['course_title']) ?></h6>
                  <p class="card-text text-muted small"><?= esc($enrollment['course_description']) ?></p>
                  <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                      Enrolled: <?= date('M d, Y', strtotime($enrollment['enrollment_date'])) ?>
                    </small>
                    <span class="badge bg-<?= $enrollment['status'] === 'active' ? 'success' : 'secondary' ?>">
                      <?= ucfirst($enrollment['status']) ?>
                    </span>
                  </div>
                  <div class="mt-2">
                    <div class="progress" style="height: 6px;">
                      <div class="progress-bar" role="progressbar" style="width: <?= $enrollment['progress'] ?>%">
                      </div>
                    </div>
                    <small class="text-muted"><?= number_format($enrollment['progress'], 1) ?>% Complete</small>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="text-center py-4">
          <i class="bi bi-book-open" style="font-size: 3rem;" class="text-muted mb-3"></i>
          <p class="text-muted">No enrolled courses yet.</p>
          <p class="text-muted small">Browse available courses below to get started!</p>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Available Courses Section -->
  <div class="card shadow-sm mb-4">
    <div class="card-header fw-semibold d-flex justify-content-between align-items-center">
      <span>Available Courses</span>
      <span class="badge bg-secondary"><?= count($available_courses ?? []) ?></span>
    </div>
    <div class="card-body">
      <?php if (!empty($available_courses)): ?>
        <div class="row g-3">
          <?php foreach ($available_courses as $course): ?>
            <div class="col-md-6 col-lg-4">
              <div class="card border-0 bg-light">
                <div class="card-body">
                  <h6 class="card-title text-primary"><?= esc($course['title']) ?></h6>
                  <p class="card-text text-muted small"><?= esc($course['description']) ?></p>
                  <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                      Instructor: <?= esc($course['instructor_name'] ?? 'TBA') ?>
                    </small>
                    <form method="POST" action="<?= base_url('student/enroll') ?>" class="d-inline">
                        <?= csrf_field() ?>
                        <input type="hidden" name="course_id" value="<?= $course['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-primary">
                          <i class="bi bi-plus"></i> Enroll
                        </button>
                    </form>
                  </div>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php else: ?>
        <div class="text-center py-4">
          <i class="bi bi-graduation-cap" style="font-size: 3rem;" class="text-muted mb-3"></i>
          <p class="text-muted">No available courses at the moment.</p>
          <p class="text-muted small">Check back later for new courses!</p>
        </div>
      <?php endif; ?>
    </div>
  </div>

  <!-- Quick Stats Row -->
  <div class="row g-3 mb-4">
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-header fw-semibold">Upcoming Deadlines</div>
        <div class="card-body">
          <p class="text-muted mb-0">No deadlines.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-header fw-semibold">Recent Grades</div>
        <div class="card-body">
          <p class="text-muted mb-0">No grades available.</p>
        </div>
      </div>
    </div>
    <div class="col-md-4">
      <div class="card shadow-sm h-100">
        <div class="card-header fw-semibold">Overall Progress</div>
        <div class="card-body">
          <div class="text-center">
            <h4 class="text-primary mb-0"><?= number_format($overall_progress ?? 0, 1) ?>%</h4>
            <small class="text-muted">Average completion</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

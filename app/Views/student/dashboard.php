<?= $this->extend('template') ?>

<?= $this->section('content') ?>
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
      <span class="badge bg-primary" id="enrolled-courses-count"><?= count($enrollments ?? []) ?></span>
    </div>
    <div class="card-body" id="enrolled-courses-list">
      <?php if (!empty($enrollments)): ?>
        <div class="row g-3">
          <?php foreach ($enrollments as $enrollment): ?>
            <div class="col-md-6 col-lg-4" id="enrolled-course-<?= $enrollment['course_id'] ?>">
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
        <div class="text-center py-4" id="no-enrollments-message">
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
      <span class="badge bg-secondary" id="available-courses-count"><?= count($available_courses ?? []) ?></span>
    </div>
    <div class="card-body">
      <?php if (!empty($available_courses)): ?>
        <div class="row g-3" id="available-courses-list">
          <?php foreach ($available_courses as $course): ?>
            <div class="col-md-6 col-lg-4" id="course-card-<?= $course['id'] ?>">
              <div class="card border-0 bg-light">
                <div class="card-body">
                  <h6 class="card-title text-primary"><?= esc($course['title']) ?></h6>
                  <p class="card-text text-muted small"><?= esc($course['description']) ?></p>
                  <div class="d-flex justify-content-between align-items-center">
                    <small class="text-muted">
                      Instructor: <?= esc($course['instructor_name'] ?? 'TBA') ?>
                    </small>
                    <button type="button" 
                            class="btn btn-sm btn-primary enroll-btn" 
                            data-course-id="<?= $course['id'] ?>"
                            data-course-title="<?= esc($course['title']) ?>">
                      <i class="bi bi-plus"></i> Enroll
                    </button>
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

<!-- jQuery (if not already included) -->
<script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

<!-- AJAX Enrollment Script -->
<script>
$(document).ready(function() {
    // Get CSRF token from meta tag
    function getCsrfToken() {
        const token = $('meta[name="csrf-token"]').attr('content');
        const tokenName = $('meta[name="csrf-token-name"]').attr('content');
        return { token: token, name: tokenName };
    }
    
    // Handle enroll button clicks
    $(document).on('click', '.enroll-btn', function(e) {
        e.preventDefault();
        
        const $button = $(this);
        const courseId = $button.data('course-id');
        const courseTitle = $button.data('course-title');
        const $courseCard = $('#course-card-' + courseId);
        
        // Disable button and show loading state
        $button.prop('disabled', true).html('<span class="spinner-border spinner-border-sm" role="status"></span> Enrolling...');
        
        // Get CSRF token
        const csrf = getCsrfToken();
        
        // Debug: Log CSRF token info
        console.log('CSRF Token:', csrf);
        
        // Prepare POST data with CSRF token
        const postData = {
            course_id: courseId
        };
        // Add CSRF token with correct name (required for POST data)
        if (csrf.name && csrf.token) {
            postData[csrf.name] = csrf.token;
            console.log('Adding CSRF to POST data:', csrf.name, '=', csrf.token.substring(0, 10) + '...');
        } else {
            console.error('CSRF token not found!');
            showAlert('danger', 'CSRF token missing. Please refresh the page.');
            $button.prop('disabled', false).html('<i class="bi bi-plus"></i> Enroll');
            return;
        }
        
        // Send AJAX request using $.ajax() for better control
        $.ajax({
            url: '<?= base_url('course/enroll') ?>',
            type: 'POST',
            data: postData,
            dataType: 'json',
            headers: {
                'X-Requested-With': 'XMLHttpRequest'
            },
            beforeSend: function(xhr) {
                // Also send CSRF token as header (for cookie-based CSRF)
                if (csrf.token) {
                    xhr.setRequestHeader('X-CSRF-TOKEN', csrf.token);
                }
            },
            success: function(response) {
                if (response.success) {
                    // Show success message
                    showAlert('success', response.message);
                    
                    // Remove course from available courses
                    $courseCard.fadeOut(300, function() {
                        $(this).remove();
                        updateAvailableCoursesCount();
                    });
                    
                    // Add course to enrolled courses
                    addToEnrolledCourses(response.enrollment, response.course);
                    
                    // Update enrolled courses count
                    updateEnrolledCoursesCount();
                } else {
                    // Show error message
                    showAlert('danger', response.message);
                    
                    // Re-enable button
                    $button.prop('disabled', false).html('<i class="bi bi-plus"></i> Enroll');
                }
            },
            error: function(xhr, status, error) {
                console.error('Enrollment error:', error, xhr);
                let errorMessage = 'An error occurred. Please try again.';
                
                // Check for CSRF error specifically
                if (xhr.status === 403 || xhr.responseText.includes('not allowed')) {
                    errorMessage = 'CSRF token expired. Please refresh the page and try again.';
                    // Optionally refresh the page to get a new token
                    setTimeout(function() {
                        location.reload();
                    }, 2000);
                } else if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseText) {
                    try {
                        const errorResponse = JSON.parse(xhr.responseText);
                        if (errorResponse.message) {
                            errorMessage = errorResponse.message;
                        }
                    } catch (e) {
                        // If parsing fails, check if it's HTML error page
                        if (xhr.responseText.includes('not allowed')) {
                            errorMessage = 'CSRF token expired. Please refresh the page and try again.';
                        }
                    }
                }
                
                showAlert('danger', errorMessage);
                
                // Re-enable button
                $button.prop('disabled', false).html('<i class="bi bi-plus"></i> Enroll');
            }
        });
    });
    
    // Function to show alert messages
    function showAlert(type, message) {
        const alertClass = type === 'success' ? 'alert-success' : 'alert-danger';
        const alertHtml = `
            <div class="alert ${alertClass} alert-dismissible fade show" role="alert" id="enrollment-alert">
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        `;
        
        // Remove existing alert if any
        $('#enrollment-alert').remove();
        
        // Add new alert at the top
        $('.container.py-4').prepend(alertHtml);
        
        // Auto-dismiss after 5 seconds
        setTimeout(function() {
            $('#enrollment-alert').fadeOut(300, function() {
                $(this).remove();
            });
        }, 5000);
    }
    
    // Function to add course to enrolled courses list
    function addToEnrolledCourses(enrollment, course) {
        const enrollmentDate = new Date(enrollment.enrollment_date).toLocaleDateString('en-US', { 
            month: 'short', 
            day: 'numeric', 
            year: 'numeric' 
        });
        
        // Use enrollment data if available (has course_title from join), otherwise use course data
        const courseTitle = enrollment.course_title || course.title || 'Course';
        const courseDescription = enrollment.course_description || course.description || '';
        const progress = parseFloat(enrollment.progress || 0).toFixed(1);
        
        const enrollmentCard = `
            <div class="col-md-6 col-lg-4" id="enrolled-course-${enrollment.course_id}">
                <div class="card border-0 bg-light">
                    <div class="card-body">
                        <h6 class="card-title text-primary">${courseTitle}</h6>
                        <p class="card-text text-muted small">${courseDescription}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <small class="text-muted">
                                Enrolled: ${enrollmentDate}
                            </small>
                            <span class="badge bg-success">Active</span>
                        </div>
                        <div class="mt-2">
                            <div class="progress" style="height: 6px;">
                                <div class="progress-bar" role="progressbar" style="width: ${progress}%">
                                </div>
                            </div>
                            <small class="text-muted">${progress}% Complete</small>
                        </div>
                    </div>
                </div>
            </div>
        `;
        
        // Remove "no enrollments" message if exists
        $('#no-enrollments-message').remove();
        
        // Get or create the row container
        let $row = $('#enrolled-courses-list .row');
        if ($row.length === 0) {
            $('#enrolled-courses-list').html('<div class="row g-3"></div>');
            $row = $('#enrolled-courses-list .row');
        }
        
        // Add new enrollment card with fade-in effect
        const $newCard = $(enrollmentCard).hide();
        $row.append($newCard);
        $newCard.fadeIn(300);
    }
    
    // Function to update available courses count
    function updateAvailableCoursesCount() {
        const count = $('#available-courses-list .col-md-6, #available-courses-list .col-lg-4').length;
        $('#available-courses-count').text(count);
        
        // Show empty state if no courses left
        if (count === 0) {
            $('#available-courses-list').html(`
                <div class="text-center py-4">
                    <i class="bi bi-graduation-cap" style="font-size: 3rem;" class="text-muted mb-3"></i>
                    <p class="text-muted">No available courses at the moment.</p>
                    <p class="text-muted small">Check back later for new courses!</p>
                </div>
            `);
        }
    }
    
    // Function to update enrolled courses count
    function updateEnrolledCoursesCount() {
        const count = $('#enrolled-courses-list .col-md-6, #enrolled-courses-list .col-lg-4').length;
        $('#enrolled-courses-count').text(count);
    }
});
</script>
<?= $this->endSection() ?>


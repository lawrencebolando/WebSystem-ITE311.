<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <h2 class="mb-4">Available Courses</h2>
    
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

    <!-- Search Form -->
    <div class="row mb-4">
        <div class="col-md-12">
            <div class="d-flex justify-content-end">
                <form id="searchForm" class="d-flex" style="max-width: 400px;">
                    <div class="input-group">
                        <input type="text" 
                               id="searchInput" 
                               class="form-control" 
                               placeholder="Search courses..." 
                               name="search_term"
                               value="<?= esc($searchTerm ?? '') ?>">
                        <button type="submit" class="btn btn-outline-primary">
                            <i class="bi bi-search"></i> Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Courses Container -->
    <div id="coursesContainer" class="row g-4">
        <?php if (!empty($courses)): ?>
            <?php foreach ($courses as $course): ?>
                <div class="col-md-6 col-lg-4 course-card">
                    <div class="card shadow-sm h-100">
                        <div class="card-body">
                            <h5 class="card-title text-primary"><?= esc($course['title']) ?></h5>
                            <p class="card-text text-muted"><?= esc($course['description'] ?? 'No description available.') ?></p>
                            <div class="mb-2">
                                <small class="text-muted">
                                    <i class="bi bi-person"></i> Instructor: <?= esc($course['instructor_name'] ?? 'TBA') ?>
                                </small>
                            </div>
                            <?php if (isset($course['category'])): ?>
                                <div class="mb-2">
                                    <span class="badge bg-secondary"><?= esc($course['category']) ?></span>
                                </div>
                            <?php endif; ?>
                            <div class="d-flex gap-2">
                                <a href="<?= base_url('courses/' . $course['id']) ?>" class="btn btn-primary btn-sm">
                                    <i class="bi bi-eye"></i> View Course
                                </a>
                                <a href="<?= base_url('materials/view/' . $course['id']) ?>" class="btn btn-success btn-sm">
                                    <i class="bi bi-cloud-upload"></i> Materials
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <div class="col-12">
                <div class="alert alert-info">
                    <i class="bi bi-info-circle"></i> No courses available at the moment.
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- jQuery Script for Search Functionality -->
<script>
// Wait for jQuery and DOM to be ready
(function() {
    function initSearch() {
        if (typeof jQuery === 'undefined') {
            console.error('jQuery is not loaded');
            return;
        }
        
        const $ = jQuery;
        
        $(document).ready(function() {
            console.log('Search script initialized');
            
            // Client-side filtering (instant feedback as user types)
            $('#searchInput').on('keyup input paste', function() {
                const value = $(this).val().toLowerCase().trim();
                
                // Remove any existing no-results message
                $('#no-results-message').remove();
                
                if (value === '') {
                    // Show all courses if search is empty
                    $('.course-card').show();
                    return;
                }
                
                let visibleCount = 0;
                
                $('.course-card').each(function() {
                    const $card = $(this);
                    const text = $card.text().toLowerCase();
                    
                    // Check if search term matches any part of the card text
                    if (text.indexOf(value) > -1) {
                        $card.show();
                        visibleCount++;
                    } else {
                        $card.hide();
                    }
                });
                
                // Show message if no courses match
                if (visibleCount === 0) {
                    $('#coursesContainer').append(`
                        <div class="col-12" id="no-results-message">
                            <div class="alert alert-info">
                                <i class="bi bi-info-circle"></i> No courses match your search.
                            </div>
                        </div>
                    `);
                }
            });

            // Server-side search with AJAX (when form is submitted)
            $('#searchForm').on('submit', function(e) {
        e.preventDefault();
        
        const searchTerm = $('#searchInput').val().trim();
        
        // If search is empty, just use client-side filtering
        if (searchTerm === '') {
            $('#searchInput').trigger('keyup');
            return;
        }
        
        // Show loading state
        const originalContent = $('#coursesContainer').html();
        $('#coursesContainer').html('<div class="col-12 text-center py-4"><div class="spinner-border text-primary" role="status"><span class="visually-hidden">Loading...</span></div><p class="mt-2 text-muted">Searching courses...</p></div>');
        
                // Make AJAX request
                $.ajax({
            url: '<?= base_url('courses/search') ?>',
            type: 'GET',
            data: { search_term: searchTerm },
            dataType: 'json',
                    success: function(response) {
                        const coursesContainer = $('#coursesContainer');
                        coursesContainer.empty();
                        
                        if (response.success && response.courses && response.courses.length > 0) {
                            // Display courses
                            $.each(response.courses, function(index, course) {
                                const courseHtml = `
                                    <div class="col-md-6 col-lg-4 course-card">
                                        <div class="card shadow-sm h-100">
                                            <div class="card-body">
                                                <h5 class="card-title text-primary">${escapeHtml(course.title || '')}</h5>
                                                <p class="card-text text-muted">${escapeHtml(course.description || 'No description available.')}</p>
                                                <div class="mb-2">
                                                    <small class="text-muted">
                                                        <i class="bi bi-person"></i> Instructor: ${escapeHtml(course.instructor_name || 'TBA')}
                                                    </small>
                                                </div>
                                        ${course.category ? `<div class="mb-2"><span class="badge bg-secondary">${escapeHtml(course.category)}</span></div>` : ''}
                                        <div class="d-flex gap-2">
                                            <a href="<?= base_url('courses/') ?>${course.id}" class="btn btn-primary btn-sm">
                                                <i class="bi bi-eye"></i> View Course
                                            </a>
                                            <a href="<?= base_url('materials/view/') ?>${course.id}" class="btn btn-success btn-sm">
                                                <i class="bi bi-cloud-upload"></i> Materials
                                            </a>
                                        </div>
                                            </div>
                                        </div>
                                    </div>
                                `;
                                coursesContainer.append(courseHtml);
                            });
                        } else {
                            // No courses found
                            coursesContainer.html(`
                                <div class="col-12">
                                    <div class="alert alert-info">
                                        <i class="bi bi-info-circle"></i> No courses found matching "${escapeHtml(searchTerm)}".
                                    </div>
                                </div>
                            `);
                        }
                    },
                    error: function(xhr, status, error) {
                        $('#coursesContainer').html(`
                            <div class="col-12">
                                <div class="alert alert-danger">
                                    <i class="bi bi-exclamation-triangle"></i> Error loading search results. Please try again.
                                    <br><small>Error: ${error}</small>
                                </div>
                            </div>
                        `);
                        console.error('Search error:', error);
                        console.error('Response:', xhr.responseText);
                    }
                });
            });
    
            // Helper function to escape HTML
            function escapeHtml(text) {
                if (!text) return '';
                const map = {
                    '&': '&amp;',
                    '<': '&lt;',
                    '>': '&gt;',
                    '"': '&quot;',
                    "'": '&#039;'
                };
                return text.toString().replace(/[&<>"']/g, m => map[m]);
            }
            
            // Trigger initial filter if search input has a value
            setTimeout(function() {
                if ($('#searchInput').val().trim() !== '') {
                    $('#searchInput').trigger('keyup');
                }
            }, 100);
        });
    }
    
    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', initSearch);
    } else {
        initSearch();
    }
})();
</script>
<?= $this->endSection() ?>


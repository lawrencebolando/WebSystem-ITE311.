<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0"><i class="bi bi-plus-circle"></i> Create New Course</h5>
                </div>
                <div class="card-body">
                    <!-- Flash Messages -->
                    <?php if (session()->getFlashdata('error')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <?= session()->getFlashdata('error') ?>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <?php if (session()->getFlashdata('errors')): ?>
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <ul class="mb-0">
                                <?php foreach (session()->getFlashdata('errors') as $error): ?>
                                    <li><?= $error ?></li>
                                <?php endforeach; ?>
                            </ul>
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    <?php endif; ?>

                    <form action="<?= base_url('admin/courses/store') ?>" method="POST">
                        <?= csrf_field() ?>

                        <div class="mb-3">
                            <label for="title" class="form-label">Course Title <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?= session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['title']) ? 'is-invalid' : '' ?>" 
                                   id="title" 
                                   name="title" 
                                   value="<?= old('title') ?>" 
                                   required>
                            <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['title'])): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors')['title'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="mb-3">
                            <label for="description" class="form-label">Description <span class="text-danger">*</span></label>
                            <textarea class="form-control <?= session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['description']) ? 'is-invalid' : '' ?>" 
                                      id="description" 
                                      name="description" 
                                      rows="5" 
                                      required><?= old('description') ?></textarea>
                            <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['description'])): ?>
                                <div class="invalid-feedback">
                                    <?= session()->getFlashdata('errors')['description'] ?>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="instructor_id" class="form-label">Instructor <span class="text-danger">*</span></label>
                                <select class="form-select <?= session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['instructor_id']) ? 'is-invalid' : '' ?>" 
                                        id="instructor_id" 
                                        name="instructor_id" 
                                        required>
                                    <option value="">Select Instructor</option>
                                    <?php foreach ($teachers as $teacher): ?>
                                        <option value="<?= $teacher['id'] ?>" <?= old('instructor_id') == $teacher['id'] ? 'selected' : '' ?>>
                                            <?= esc($teacher['name']) ?> (<?= esc($teacher['email']) ?>)
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                                <?php if (session()->getFlashdata('errors') && isset(session()->getFlashdata('errors')['instructor_id'])): ?>
                                    <div class="invalid-feedback">
                                        <?= session()->getFlashdata('errors')['instructor_id'] ?>
                                    </div>
                                <?php endif; ?>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">Category</label>
                                <input type="text" 
                                       class="form-control" 
                                       id="category" 
                                       name="category" 
                                       value="<?= old('category') ?>" 
                                       placeholder="e.g., Web Development, Database">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="level" class="form-label">Level</label>
                                <select class="form-select" id="level" name="level">
                                    <option value="beginner" <?= old('level') == 'beginner' ? 'selected' : '' ?>>Beginner</option>
                                    <option value="intermediate" <?= old('level') == 'intermediate' ? 'selected' : '' ?>>Intermediate</option>
                                    <option value="advanced" <?= old('level') == 'advanced' ? 'selected' : '' ?>>Advanced</option>
                                </select>
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="duration" class="form-label">Duration (minutes)</label>
                                <input type="number" 
                                       class="form-control" 
                                       id="duration" 
                                       name="duration" 
                                       value="<?= old('duration') ?>" 
                                       min="0" 
                                       placeholder="e.g., 1800">
                            </div>

                            <div class="col-md-4 mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" 
                                       class="form-control" 
                                       id="price" 
                                       name="price" 
                                       value="<?= old('price') ?? '0.00' ?>" 
                                       step="0.01" 
                                       min="0" 
                                       placeholder="0.00">
                            </div>
                        </div>

                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status">
                                <option value="draft" <?= old('status') == 'draft' ? 'selected' : '' ?>>Draft</option>
                                <option value="published" <?= old('status') == 'published' || !old('status') ? 'selected' : '' ?>>Published</option>
                                <option value="archived" <?= old('status') == 'archived' ? 'selected' : '' ?>>Archived</option>
                            </select>
                            <small class="form-text text-muted">Published courses will be visible to students for enrollment.</small>
                        </div>

                        <div class="d-flex justify-content-between">
                            <a href="<?= base_url('admin/courses') ?>" class="btn btn-secondary">
                                <i class="bi bi-arrow-left"></i> Cancel
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle"></i> Create Course
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $this->endSection() ?>


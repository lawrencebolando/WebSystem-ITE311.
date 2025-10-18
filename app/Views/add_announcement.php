<?= $this->extend('template') ?>

<?= $this->section('content') ?>
<div class="container py-4">
    <h3 class="mb-3 text-primary">Add New Announcement</h3>

    <?php if (session()->getFlashdata('success')): ?>
        <div class="alert alert-success">
            <?= session()->getFlashdata('success') ?>
        </div>
    <?php endif; ?>

    <?php if (session()->getFlashdata('error')): ?>
        <div class="alert alert-danger">
            <?= session()->getFlashdata('error') ?>
        </div>
    <?php endif; ?>

    <div class="card shadow-sm">
        <div class="card-body">
            <form action="<?= base_url('add-announcement') ?>" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="title" class="form-label">Announcement Title</label>
                    <input type="text" class="form-control <?= isset($validation) && $validation->hasError('title') ? 'is-invalid' : '' ?>" id="title" name="title" value="<?= old('title') ?>" placeholder="Enter announcement title" required>
                    <?php if (isset($validation) && $validation->hasError('title')): ?>
                        <div class="invalid-feedback d-block">
                            <?= $validation->getError('title') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Announcement Content</label>
                    <textarea class="form-control <?= isset($validation) && $validation->hasError('content') ? 'is-invalid' : '' ?>" id="content" name="content" rows="8" placeholder="Type your announcement here..." required><?= old('content') ?></textarea>
                    <?php if (isset($validation) && $validation->hasError('content')): ?>
                        <div class="invalid-feedback d-block">
                            <?= $validation->getError('content') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="d-flex gap-2">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-check"></i> Post Announcement
                    </button>
                    <a href="<?= base_url('announcements') ?>" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

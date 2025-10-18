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
            <form action="/add-announcement" method="post">
                <?= csrf_field() ?>

                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" class="form-control" id="title" name="title" value="<?= old('title') ?>" required>
                    <?php if (isset($validation) && $validation->hasError('title')): ?>
                        <div class="text-danger mt-1">
                            <?= $validation->getError('title') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea class="form-control" id="content" name="content" rows="5" required><?= old('content') ?></textarea>
                    <?php if (isset($validation) && $validation->hasError('content')): ?>
                        <div class="text-danger mt-1">
                            <?= $validation->getError('content') ?>
                        </div>
                    <?php endif; ?>
                </div>

                <button type="submit" class="btn btn-primary">Add Announcement</button>
                <a href="/announcements" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
</div>
<?= $this->endSection() ?>

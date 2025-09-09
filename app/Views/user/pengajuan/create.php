<?= $this->extend('layouts/teknisi') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <h4>Form Pengajuan Kas</h4>
            </div>
            <div class="card-body">
                <?php if (isset($validation)): ?>
                    <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
                <?php endif; ?>

                <form method="post" action="<?= site_url('user/pengajuan/store') ?>">
                    <div class="mb-3">
                        <label for="nominal" class="form-label">Nominal (Rp)</label>
                        <input type="number" class="form-control" id="nominal" name="nominal" required>
                    </div>
                    <div class="mb-3">
                        <label for="keterangan" class="form-label">Keterangan</label>
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="deadline" class="form-label">Deadline (Opsional)</label>
                        <input type="date" class="form-control" id="deadline" name="deadline">
                    </div>
                    <button type="submit" class="btn btn-primary">Ajukan</button>
                    <a href="<?= site_url('user/pengajuan') ?>" class="btn btn-secondary">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
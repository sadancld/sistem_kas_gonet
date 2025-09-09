<?= $this->extend('layouts/teknisi') ?>

<?= $this->section('content') ?>
<div class="row">
    <div class="col-md-12">
        <h2>History Pengajuan</h2>

        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
        <?php endif; ?>

        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tanggal</th>
                        <th>Nominal</th>
                        <th>Keterangan</th>
                        <th>Deadline</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($pengajuan as $p): ?>
                        <tr>
                            <td><?= $p['id'] ?></td>
                            <td><?= date('d/m/Y H:i', strtotime($p['created_at'])) ?></td>
                            <td>Rp <?= number_format($p['nominal'], 0, ',', '.') ?></td>
                            <td><?= $p['keterangan'] ?></td>
                            <td><?= $p['deadline'] ? date('d/m/Y', strtotime($p['deadline'])) : '-' ?></td>
                            <td>
                                <span class="badge bg-<?=
                                                        $p['status'] == 'diterima' ? 'success' : ($p['status'] == 'ditolak' ? 'danger' : ($p['status'] == 'diproses' ? 'warning' : 'secondary'))
                                                        ?>">
                                    <?= ucfirst($p['status']) ?>
                                </span>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
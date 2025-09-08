<?php include(APPPATH . 'Views/layouts/header.php'); ?>

<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Manajemen Pengajuan</h1>
</div>

<?php if (session()->getFlashdata('success')): ?>
    <div class="alert alert-success"><?= session()->getFlashdata('success') ?></div>
<?php endif; ?>

<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>User</th>
                <th>Nominal</th>
                <th>Keterangan</th>
                <th>Deadline</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pengajuan as $p): ?>
            <tr>
                <td><?= $p['id'] ?></td>
                <td><?= $p['username'] ?></td>
                <td>Rp <?= number_format($p['nominal'], 0, ',', '.') ?></td>
                <td><?= $p['keterangan'] ?></td>
                <td><?= $p['deadline'] ? date('d/m/Y', strtotime($p['deadline'])) : '-' ?></td>
                <td>
                    <span class="badge bg-<?= 
                        $p['status'] == 'diterima' ? 'success' : 
                        ($p['status'] == 'ditolak' ? 'danger' : 
                        ($p['status'] == 'diproses' ? 'warning' : 'secondary')) 
                    ?>">
                        <?= ucfirst($p['status']) ?>
                    </span>
                </td>
                <td>
                    <?php if ($p['status'] == 'pending'): ?>
                        <a href="<?= site_url('admin/pengajuan/approve/' . $p['id']) ?>" class="btn btn-sm btn-success">Setujui</a>
                        <a href="<?= site_url('admin/pengajuan/reject/' . $p['id']) ?>" class="btn btn-sm btn-danger">Tolak</a>
                    <?php elseif ($p['status'] == 'diterima'): ?>
                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#processModal<?= $p['id'] ?>">
                            Proses
                        </button>
                    <?php endif; ?>
                </td>
            </tr>

            <!-- Modal untuk proses pengajuan -->
            <div class="modal fade" id="processModal<?= $p['id'] ?>" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Proses Pengajuan</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <form method="post" action="<?= site_url('admin/pengajuan/process/' . $p['id']) ?>" enctype="multipart/form-data">
                            <div class="modal-body">
                                <div class="mb-3">
                                    <label class="form-label">Metode Pembayaran</label>
                                    <select class="form-select" name="metode" required>
                                        <option value="uang_sendiri">Pakai Uang Sendiri (Reimburse)</option>
                                        <option value="minta_uang">Minta Uang ke Admin</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Upload Nota/Struk</label>
                                    <input type="file" class="form-control" name="file_nota" accept=".jpg,.jpeg,.png,.pdf" required>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary">Proses</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>

<?php include(APPPATH . 'Views/layouts/footer.php'); ?>
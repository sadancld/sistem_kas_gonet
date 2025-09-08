<?php include(APPPATH . 'Views/layouts/user/header.php'); ?>

<div class="row">
    <div class="col-md-12">
        <h2>Pengajuan Kas</h2>
        <div class="card">
            <div class="card-body">
                <p>Silakan ajukan permintaan kas untuk keperluan operasional.</p>
                <a href="<?= site_url('user/pengajuan/create') ?>" class="btn btn-primary">Ajukan Kas Baru</a>
                <a href="<?= site_url('user/pengajuan/history') ?>" class="btn btn-secondary">Lihat History</a>
            </div>
        </div>
    </div>
</div>

<?php include(APPPATH . 'Views/layouts/user/footer.php'); ?>
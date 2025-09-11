<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title ?? 'Sistem Kas GoNet' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        main {
            flex: 1;
        }

        img {
            height: 35px;
        }
    </style>
</head>

<body>
    <!-- NAVBAR -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top shadow">
        <div class="container-fluid">
             <a href="/admin/dashboard" class="navbar-brand" id="sidebarToggle">
          <img src="/uploads/logo.png" alt="Logo Gonet" class="brand-logo">
          <span class="arsip-surat">Sistem Kas <span class="brand-name">GONET</span></span>
        </a>

            <div class="d-flex ms-auto">
                <span class="navbar-text text-white me-3">
                    Halo, <?= session()->get('username') ?> (<?= ucfirst(session()->get('role')) ?>)
                </span>
                <a class="btn btn-sm btn-outline-light" href="<?= site_url('logout') ?>">
                    <i class="bi bi-box-arrow-right"></i> Logout
                </a>
            </div>
        </div>
    </nav>

    <div class="container-fluid flex-grow-1">
        <div class="row">
            <!-- SIDEBAR -->
            <div class="col-md-2 col-lg-2 bg-light shadow-sm" id="sidebarMenu">
                <div class="pt-3">
                    <ul class="nav flex-column">
                        <li class="nav-item">
                            <a class="nav-link <?= service('uri')->getSegment(2) === 'dashboard' ? 'active fw-bold' : '' ?>"
                                href="<?= site_url('admin/dashboard') ?>">
                                <i class="bi bi-speedometer2"></i> Dashboard
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= service('uri')->getSegment(2) === 'users' ? 'active fw-bold' : '' ?>" href="<?= site_url('admin/users') ?>">
                                <i class="bi bi-people"></i> Manajemen User
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= service('uri')->getSegment(2) === 'laporan' ? 'active fw-bold' : '' ?>" href="<?= site_url('admin/laporan') ?>">
                                <i class="bi bi-bar-chart"></i> Laporan
                            </a>
                        </li>

                         <!-- Divider -->
                         <hr class="border-top my-2">

                        <li class="nav-item">
                            <a class="nav-link <?= service('uri')->getSegment(2) === 'kas_masuk' ? 'active fw-bold' : '' ?>" href="<?= site_url('admin/kas_masuk') ?>">
                                <i class="bi bi-cash-coin"></i> Kas Masuk
                            </a>
                        </li>
                         <li class="nav-item">
                            <a class="nav-link <?= service('uri')->getSegment(2) === 'kas_keluar' ? 'active fw-bold' : '' ?>" href="<?= site_url('admin/kas_keluar') ?>">
                                <i class="bi bi-cash-stack"></i> Kas Keluar
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link <?= service('uri')->getSegment(2) === 'pengajuan' ? 'active fw-bold' : '' ?>" href="<?= site_url('admin/pengajuan') ?>">
                                <i class="bi bi-clipboard-check"></i> Pengajuan
                            </a>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- CONTENT -->
            <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 py-3">
                <?= $this->renderSection('content') ?>
            </main>
        </div>
    </div>

    <!-- FOOTER -->
    <footer class="bg-dark text-white text-center py-3 mt-auto">
        <div class="container">
            <small>&copy; <?= date('Y') ?> Sistem Kas GoNet. All right be served.</small>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
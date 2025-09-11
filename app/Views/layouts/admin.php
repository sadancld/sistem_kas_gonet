<?php if (session()->get('role') === 'admin') : ?>
    <!DOCTYPE html>
    <html lang="id">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Akses Ditolak - Sistem Kas GoNet</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body {
                background: linear-gradient(135deg, #4361ee, #3f37c9);
                height: 100vh;
                display: flex;
                align-items: center;
                justify-content: center;
                font-family: 'Poppins', sans-serif;
            }

            .access-denied {
                background: white;
                padding: 3rem;
                border-radius: 15px;
                box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
                text-align: center;
                max-width: 500px;
            }

            .access-denied i {
                font-size: 5rem;
                color: #e63946;
                margin-bottom: 1.5rem;
            }
        </style>
    </head>

    <body>
        <div class="access-denied">
            <i class="bi bi-shield-exclamation"></i>
            <h1 class="text-danger">Akses Ditolak</h1>
            <p class="lead">Anda tidak memiliki izin untuk mengakses halaman ini.</p>
            <a href="<?= site_url('login') ?>" class="btn btn-primary mt-3">Kembali ke Login</a>
        </div>
    </body>

    </html>
<?php endif; ?>
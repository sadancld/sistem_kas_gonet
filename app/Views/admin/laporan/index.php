<?= $this->extend('layouts/admin') ?>
<?= $this->section('content') ?>

<div class="container">
    <h1 class="mb-4">Laporan Kas & Aktivitas</h1>

    <div class="row">
        <!-- Diagram Batang Kas -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <i class="bi bi-bar-chart"></i> Ringkasan Kas
                </div>
                <div class="card-body">
                    <canvas id="kasChart" height="200"></canvas>
                </div>
            </div>
        </div>

        <!-- Diagram Lingkaran Pengajuan & User -->
        <div class="col-md-6 mb-4">
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <i class="bi bi-pie-chart"></i> Ringkasan Pengajuan & User
                </div>
                <div class="card-body">
                    <canvas id="pengajuanUserChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Data Ringkasan Kas
    const kasLabels = ['Kas Masuk', 'Kas Keluar', 'Saldo'];
    const kasData = [
        <?= (float) $total_masuk['total'] ?>,
        <?= (float) $total_keluar['total'] ?>,
        <?= (float) $saldo['saldo_akhir'] ?? 0 ?>
    ];

    new Chart(document.getElementById('kasChart'), {
        type: 'bar',
        data: {
            labels: kasLabels,
            datasets: [{
                label: 'Jumlah (Rp)',
                data: kasData,
                backgroundColor: [
                    'rgba(0, 200, 83, 0.7)',   // Masuk - Hijau
                    'rgba(255, 99, 132, 0.7)', // Keluar - Merah
                    'rgba(54, 162, 235, 0.7)'  // Saldo - Biru
                ],
                borderColor: [
                    'rgba(0, 200, 83, 1)',
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { display: false },
                title: { display: true, text: 'Ringkasan Kas' }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + value.toLocaleString();
                        }
                    }
                }
            }
        }
    });

    // Data Ringkasan Pengajuan & User
    const pieLabels = ['Total Pengajuan', 'Pengajuan Pending', 'Total User'];
    const pieData = [
        <?= (int) $total_pengajuan ?>,
        <?= (int) $pengajuan_pending ?>,
        <?= (int) $total_users ?>
    ];

    new Chart(document.getElementById('pengajuanUserChart'), {
        type: 'pie',
        data: {
            labels: pieLabels,
            datasets: [{
                data: pieData,
                backgroundColor: [
                    'rgba(255, 159, 64, 0.7)',  // Total Pengajuan - Orange
                    'rgba(255, 205, 86, 0.7)',  // Pending - Kuning
                    'rgba(75, 192, 192, 0.7)'   // User - Hijau Tosca
                ],
                borderColor: [
                    'rgba(255, 159, 64, 1)',
                    'rgba(255, 205, 86, 1)',
                    'rgba(75, 192, 192, 1)'
                ],
                borderWidth: 1
            }]
        },
        options: {
            responsive: true,
            plugins: {
                title: { display: true, text: 'Ringkasan Pengajuan & User' }
            }
        }
    });
</script>

<?= $this->endSection() ?>

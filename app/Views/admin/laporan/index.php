<?= $this->extend('layouts/admin') ?>

<?= $this->section('content') ?>
<div class="container">
    <h1 class="mb-4">Laporan Kas (Kas Keluar, Total Pemasukan & Saldo)</h1>

    <!-- Filter dengan Kalender -->
    <form method="get" class="mb-4">
        <div class="row g-2 align-items-center">
            <!-- Dari Tanggal -->
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-calendar-date"></i>
                    </span>
                    <input type="date" name="start_date" value="<?= esc($start_date ?? '') ?>" class="form-control">
                </div>
            </div>

            <!-- Sampai Tanggal -->
            <div class="col-md-3">
                <div class="input-group">
                    <span class="input-group-text">
                        <i class="bi bi-calendar-date-fill"></i>
                    </span>
                    <input type="date" name="end_date" value="<?= esc($end_date ?? '') ?>" class="form-control">
                </div>
            </div>

            <!-- Tombol -->
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">
                    <i class="bi bi-funnel"></i> Filter
                </button>
                <a href="<?= base_url('admin/laporan') ?>" class="btn btn-secondary">
                    <i class="bi bi-arrow-repeat"></i> Reset
                </a>
            </div>
        </div>
    </form>

    <canvas id="kasChart" height="120"></canvas>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    const ctx = document.getElementById('kasChart').getContext('2d');

    const bulanMasuk = <?= json_encode(array_column($kas['masuk'], 'bulan')) ?>;
    const totalMasuk = <?= json_encode(array_map('floatval', array_column($kas['masuk'], 'total'))) ?>;

    const bulanKeluar = <?= json_encode(array_column($kas['keluar'], 'bulan')) ?>;
    const totalKeluar = <?= json_encode(array_map('floatval', array_column($kas['keluar'], 'total'))) ?>;

    // Gabungkan semua tanggal
    const allMonths = [...new Set([...bulanMasuk, ...bulanKeluar])];

    const masukData = allMonths.map(m => {
        const idx = bulanMasuk.indexOf(m);
        return idx >= 0 ? totalMasuk[idx] : 0;
    });

    const keluarData = allMonths.map(m => {
        const idx = bulanKeluar.indexOf(m);
        return idx >= 0 ? totalKeluar[idx] : 0;
    });

    let runningTotalMasuk = 0;
    const totalPemasukan = masukData.map(val => {
        runningTotalMasuk += val;
        return runningTotalMasuk;
    });

    let saldo = 0;
    const saldoKas = allMonths.map((m, i) => {
        saldo += (masukData[i] - keluarData[i]);
        return saldo;
    });

    new Chart(ctx, {
        data: {
            labels: allMonths,
            datasets: [
                {
                    label: 'Saldo Kas',
                    data: saldoKas,
                    type: 'bar',
                    backgroundColor: 'rgba(54, 162, 235, 0.7)',
                    yAxisID: 'y',
                },
                {
                    label: 'Kas Keluar',
                    data: keluarData,
                    type: 'bar',
                    backgroundColor: 'rgba(255, 99, 132, 0.7)',
                    yAxisID: 'y',
                },
                {
                    label: 'Total Pemasukan',
                    data: totalPemasukan,
                    type: 'bar',
                    backgroundColor: 'rgba(0, 200, 83, 0.7)',
                    yAxisID: 'y',
                }
            ]
        },
        options: {
            responsive: true,
            plugins: {
                legend: { position: 'top' },
                title: { display: true, text: 'Traffic Kas (Periode Filter)' }
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
</script>
<?= $this->endSection() ?>

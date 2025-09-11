<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KasSaldoModel;
use App\Models\KasMasukModel;
use App\Models\KasKeluarModel;
use App\Models\PengajuanModel;
use App\Models\UserModel;

class Laporan extends BaseController
{
    public function index()
    {
        $kasSaldoModel   = new KasSaldoModel();
        $kasMasukModel   = new KasMasukModel();
        $kasKeluarModel  = new KasKeluarModel();
        $pengajuanModel  = new PengajuanModel();
        $userModel       = new UserModel();

        // Ambil data sama seperti di dashboard
        $data = [
            'title'             => 'Laporan Kas',
            'saldo'             => $kasSaldoModel->first(),
            'total_masuk'       => $kasMasukModel->selectSum('nominal', 'total')->first(),
            'total_keluar'      => $kasKeluarModel->selectSum('nominal', 'total')->first(),
            'total_pengajuan'   => $pengajuanModel->countAll(),
            'total_users'       => $userModel->where('role !=', 'admin')->countAllResults(),
            'pengajuan_pending' => $pengajuanModel->where('status', 'pending')->countAllResults()
        ];

        return view('admin/laporan/index', $data);
    }
}

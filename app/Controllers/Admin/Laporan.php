<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\LaporanModel;

class Laporan extends BaseController
{
    public function index()
    {
        $laporanModel = new LaporanModel();

        $start_date = $this->request->getGet('start_date');
        $end_date   = $this->request->getGet('end_date');

        $data['title'] = 'Laporan Kas';
        $data['kas'] = $laporanModel->getKasSummary($start_date, $end_date);
        $data['start_date'] = $start_date;
        $data['end_date']   = $end_date;

        return view('admin/laporan/index', $data);
    }
}

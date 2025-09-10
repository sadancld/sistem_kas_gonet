<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengajuanModel;
use App\Models\KasKeluarModel;
use App\Models\KasSaldoModel;
use App\Models\NotificationModel;

class Pengajuan extends BaseController
{
    public function index()
    {
        $model = new PengajuanModel();
        $model->select('pengajuan.*, users.username');
        $model->join('users', 'users.id = pengajuan.user_id');
        $data['pengajuan'] = $model->findAll();

        // ambil data kas keluar kalau mau ditampilkan
        $kasKeluarModel = new KasKeluarModel();
        $data['kasKeluar'] = $kasKeluarModel->findAll();

        return view('admin/pengajuan/index', $data);
    }

    public function approve($id)
    {
        $model = new PengajuanModel();
        $model->update($id, ['status' => 'diterima']);

        $notifModel = new NotificationModel();
        $pengajuan = $model->find($id);
        $notifModel->save([
            'user_id' => $pengajuan['user_id'],
            'message' => 'Pengajuan kas Anda telah disetujui.'
        ]);

        return redirect()->to('/admin/pengajuan')->with('success', 'Pengajuan berhasil disetujui.');
    }

    public function reject($id)
    {
        $model = new PengajuanModel();
        $model->update($id, ['status' => 'ditolak']);

        $notifModel = new NotificationModel();
        $pengajuan = $model->find($id);
        $notifModel->save([
            'user_id' => $pengajuan['user_id'],
            'message' => 'Pengajuan kas Anda ditolak.'
        ]);

        return redirect()->to('/admin/pengajuan')->with('success', 'Pengajuan berhasil ditolak.');
    }

    public function process($id)
    {
        helper(['form']);
        $rules = [
            'file_nota' => 'uploaded[file_nota]|max_size[file_nota,1024]|ext_in[file_nota,jpg,jpeg,png,pdf]'
        ];

        if ($this->validate($rules)) {
            $pengajuanModel = new PengajuanModel();
            $kasKeluarModel = new KasKeluarModel();
            $kasSaldoModel = new KasSaldoModel();

            $pengajuan = $pengajuanModel->find($id);
            $metode = $pengajuan['tipe'];

            // upload file
            $file = $this->request->getFile('file_nota');
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/nota', $newName);

            // simpan kas keluar
            $kasKeluarModel->save([
                'pengajuan_id' => $id,
                'nominal'      => $pengajuan['nominal'],
                'keterangan'   => $pengajuan['keterangan'],
                'file_nota'    => $newName
            ]);

            // update saldo jika minta uang
            if ($metode == 'minta_uang') {
                $saldo = $kasSaldoModel->first();
                if ($saldo) {
                    $newSaldo = $saldo['saldo_akhir'] - $pengajuan['nominal'];
                    $kasSaldoModel->update($saldo['id'], ['saldo_akhir' => $newSaldo]);
                }
            }

            // update status pengajuan
            $pengajuanModel->update($id, ['status' => 'diproses']);

            return redirect()->to('/admin/pengajuan')->with('success', 'Pengajuan berhasil diproses.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan dalam memproses pengajuan.');
        }
    }
}

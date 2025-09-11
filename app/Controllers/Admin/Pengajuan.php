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
        $model->select('pengajuan.*, users.username, kas_keluar.file_nota');
        $model->join('users', 'users.id = pengajuan.user_id');
        $model->join('kas_keluar', 'kas_keluar.pengajuan_id = pengajuan.id', 'left');
        $data['pengajuan'] = $model->findAll();

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
        $pengajuanModel = new PengajuanModel();
        $kasKeluarModel = new KasKeluarModel();
        $kasSaldoModel = new KasSaldoModel();

        $pengajuan = $pengajuanModel->find($id);
        $kasKeluar = $kasKeluarModel->where('pengajuan_id', $id)->first();
        $metode = $pengajuan['tipe'];

        // jika tipe = uang_sendiri, admin tidak perlu upload nota
        if ($metode == 'uang_sendiri') {
            if (!$kasKeluar) {
                $kasKeluarModel->save([
                    'pengajuan_id' => $id,
                    'nominal'      => $pengajuan['nominal'],
                    'keterangan'   => $pengajuan['keterangan'],
                    'file_nota'    => null
                ]);
            }

            $pengajuanModel->update($id, ['status' => 'selesai']);
            return redirect()->to('/admin/pengajuan')->with('success', 'Pengajuan uang sendiri berhasil diproses.');
        }

        // jika tipe = minta_uang
        if ($kasKeluar && !empty($kasKeluar['file_nota'])) {
            // file_nota sudah ada, langsung proses tanpa upload
            $saldo = $kasSaldoModel->first();
            if ($saldo) {
                $newSaldo = $saldo['saldo_akhir'] - $pengajuan['nominal'];
                $kasSaldoModel->update($saldo['id'], ['saldo_akhir' => $newSaldo]);
            }

            $pengajuanModel->update($id, ['status' => 'selesai']);
            return redirect()->to('/admin/pengajuan')->with('success', 'Pengajuan berhasil diproses (file nota sudah ada).');
        }

        // jika belum ada file_nota, wajib upload
        helper(['form']);
        $rules = [
            'file_nota' => 'uploaded[file_nota]|max_size[file_nota,1024]|ext_in[file_nota,jpg,jpeg,png,pdf]'
        ];

        if ($this->validate($rules)) {
            $file = $this->request->getFile('file_nota');
            $newName = $file->getRandomName();
            $file->move(ROOTPATH . 'public/uploads/nota', $newName);

            $kasKeluarModel->save([
                'pengajuan_id' => $id,
                'nominal'      => $pengajuan['nominal'],
                'keterangan'   => $pengajuan['keterangan'],
                'file_nota'    => $newName
            ]);

            $saldo = $kasSaldoModel->first();
            if ($saldo) {
                $newSaldo = $saldo['saldo_akhir'] - $pengajuan['nominal'];
                $kasSaldoModel->update($saldo['id'], ['saldo_akhir' => $newSaldo]);
            }

            $pengajuanModel->update($id, ['status' => 'selesai']);
            return redirect()->to('/admin/pengajuan')->with('success', 'Pengajuan berhasil diproses dengan upload nota.');
        } else {
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan dalam memproses pengajuan.');
        }
    }
}

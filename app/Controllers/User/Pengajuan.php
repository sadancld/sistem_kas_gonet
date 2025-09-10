<?php

namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\PengajuanModel;
use App\Models\KasKeluarModel;

class Pengajuan extends BaseController
{
    public function index()
    {
        $model = new PengajuanModel();
        $session = session();

        $data['pengajuan'] = $model
            ->where('user_id', $session->get('id'))
            ->orderBy('created_at', 'DESC')
            ->findAll();

        return view('user/pengajuan/index', $data);
    }

    public function create()
    {
        helper(['form']);
        return view('user/pengajuan/create');
    }

    public function store()
    {
        helper(['form']);
        $rules = [
            'nominal'    => 'required|numeric',
            'keterangan' => 'required',
            'deadline'   => 'permit_empty|valid_date',
            'tipe'       => 'required'
        ];

        if ($this->validate($rules)) {
            $session = session();
            $pengajuanModel = new PengajuanModel();

            // Simpan ke tabel pengajuan
            $dataPengajuan = [
                'user_id'    => $session->get('id'),
                'nominal'    => $this->request->getVar('nominal'),
                'keterangan' => $this->request->getVar('keterangan'),
                'deadline'   => $this->request->getVar('deadline'),
                'tipe'       => $this->request->getVar('tipe'),
                'status'     => 'pending'
            ];

            $pengajuanModel->save($dataPengajuan);
            $pengajuanId = $pengajuanModel->getInsertID();

            // Jika tipe uang sendiri => simpan ke kas_keluar
            if ($this->request->getVar('tipe') === 'uang_sendiri') {
                $fileNota = $this->request->getFile('file_nota');
                $fileName = null;

                if ($fileNota && $fileNota->isValid() && !$fileNota->hasMoved()) {
                    $fileName = $fileNota->getRandomName();
                    $fileNota->move(FCPATH . 'uploads/nota', $fileName);
                }

                $kasKeluarModel = new KasKeluarModel();
                $kasKeluarModel->save([
                    'pengajuan_id' => $pengajuanId,
                    'nominal'      => $this->request->getVar('nominal'),
                    'keterangan'   => $this->request->getVar('keterangan'),
                    'file_nota'    => $fileName
                ]);
            }

            return redirect()->to('/user/pengajuan')->with('success', 'Pengajuan berhasil dikirim.');
        } else {
            return view('user/pengajuan/create', [
                'validation' => $this->validator
            ]);
        }
    }
}

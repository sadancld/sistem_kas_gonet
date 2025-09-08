<?php
namespace App\Controllers\User;

use App\Controllers\BaseController;
use App\Models\PengajuanModel;

class Pengajuan extends BaseController
{
    public function index()
    {
        return view('user/pengajuan/index');
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
            'nominal' => 'required|numeric',
            'keterangan' => 'required',
            'deadline' => 'valid_date'
        ];
        
        if ($this->validate($rules)) {
            $model = new PengajuanModel();
            $session = session();
            
            $data = [
                'user_id' => $session->get('id'),
                'nominal' => $this->request->getVar('nominal'),
                'keterangan' => $this->request->getVar('keterangan'),
                'deadline' => $this->request->getVar('deadline'),
                'status' => 'pending'
            ];
            
            $model->save($data);
            return redirect()->to('/user/pengajuan/history')->with('success', 'Pengajuan berhasil dikirim.');
        } else {
            return view('user/pengajuan/create', [
                'validation' => $this->validator
            ]);
        }
    }

    public function history()
    {
        $model = new PengajuanModel();
        $session = session();
        $data['pengajuan'] = $model->where('user_id', $session->get('id'))->findAll();
        return view('user/pengajuan/history', $data);
    }
}
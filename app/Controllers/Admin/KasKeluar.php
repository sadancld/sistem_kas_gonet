<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\PengajuanModel;

class KasKeluar extends BaseController
{
    public function index()
    {
        $pengajuanModel = new PengajuanModel();
        // join ke user biar bisa tampil username
        $pengajuanModel->select('pengajuan.*, users.username');
        $pengajuanModel->join('users', 'users.id = pengajuan.user_id', 'left');
        $data['title'] = 'Kas Keluar';
        $data['pengajuan'] = $pengajuanModel->findAll();

        return view('admin/kas_keluar/index', $data);
    }

    public function edit($id)
    {
        $model = new PengajuanModel();
        $data['title'] = 'Edit Kas Keluar';
        $data['pengajuan'] = $model->find($id);

        if (!$data['pengajuan']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Data dengan ID $id tidak ditemukan");
        }

        return view('admin/kas_keluar/edit', $data);
    }

    public function update($id)
    {
        $model = new PengajuanModel();
        $data = [
            'nominal'    => $this->request->getVar('nominal'),
            'keterangan' => $this->request->getVar('keterangan'),
            'deadline'   => $this->request->getVar('deadline'),
            'status'     => $this->request->getVar('status'),
        ];
        $model->update($id, $data);

        return redirect()->to('/admin/kas_keluar')->with('success', 'Data kas keluar berhasil diperbarui.');
    }

    public function delete($id)
    {
        $model = new PengajuanModel();
        $model->delete($id);

        return redirect()->to('/admin/kas_keluar')->with('success', 'Data kas keluar berhasil dihapus.');
    }
}

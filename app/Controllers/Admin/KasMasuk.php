<?php
namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\KasMasukModel;
use App\Models\KasSaldoModel;

class KasMasuk extends BaseController
{
    public function index()
    {
        $model = new KasMasukModel();
        $data['kas_masuk'] = $model->findAll();
        return view('admin/kas_masuk/index', $data);
    }

    public function create()
    {
        helper(['form']);
        return view('admin/kas_masuk/create');
    }

    public function store()
    {
        helper(['form']);
        $rules = [
            'nominal' => 'required|numeric',
            'keterangan' => 'required'
        ];
        
        if ($this->validate($rules)) {
            $kasMasukModel = new KasMasukModel();
            $kasSaldoModel = new KasSaldoModel();
            
            $data = [
                'nominal' => $this->request->getVar('nominal'),
                'keterangan' => $this->request->getVar('keterangan')
            ];
            
            $kasMasukModel->save($data);
            
            // Update saldo
            $saldo = $kasSaldoModel->first();
            if ($saldo) {
                $newSaldo = $saldo['saldo_akhir'] + $this->request->getVar('nominal');
                $kasSaldoModel->update($saldo['id'], ['saldo_akhir' => $newSaldo]);
            } else {
                $kasSaldoModel->save(['saldo_akhir' => $this->request->getVar('nominal')]);
            }
            
            return redirect()->to('/admin/kas_masuk')->with('success', 'Kas masuk berhasil ditambahkan.');
        } else {
            return view('admin/kas_masuk/create', [
                'validation' => $this->validator
            ]);
        }
    }

    // 👉 Tambahkan edit
    public function edit($id)
    {
        $model = new KasMasukModel();
        $data['kas'] = $model->find($id);

        if (!$data['kas']) {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound("Data kas masuk dengan ID $id tidak ditemukan");
        }

        return view('admin/kas_masuk/edit', $data);
    }

    // 👉 Tambahkan update
    public function update($id)
    {
        $model = new KasMasukModel();

        $data = [
            'nominal' => $this->request->getVar('nominal'),
            'keterangan' => $this->request->getVar('keterangan')
        ];

        $model->update($id, $data);

        return redirect()->to('/admin/kas_masuk')->with('success', 'Data kas masuk berhasil diperbarui.');
    }

    // 👉 Tambahkan delete
    public function delete($id)
    {
        $model = new KasMasukModel();
        $model->delete($id);

        return redirect()->to('/admin/kas_masuk')->with('success', 'Data kas masuk berhasil dihapus.');
    }
}

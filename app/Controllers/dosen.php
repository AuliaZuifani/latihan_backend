<?php

namespace App\Controllers;

use App\Models\DosenModel;
use CodeIgniter\API\ResponseTrait;

class Dosen extends BaseController
{
    use ResponseTrait;

    protected $dosenModel;

    public function __construct()
    {
        $this->dosenModel = new DosenModel();
    }

    public function index()
    {
        $data = $this->dosenModel->findAll();
        return $this->respond($data, 200);
    }

    public function show($id = null)
    {
        $data = $this->dosenModel->find($id);
        if ($data) {
            return $this->respond($data, 200);
        } else {
            return $this->failNotFound("Data dosen dengan ID $id tidak ditemukan.");
        }
    }

    public function create()
    {
        $data = $this->request->getJSON();

        // Validasi sederhana
        if (!$this->dosenModel->insert($data)) {
            return $this->fail($this->dosenModel->errors());
        }

        return $this->respondCreated([
            'status' => 201,
            'message' => 'Data dosen berhasil ditambahkan.'
        ]);
    }

    public function update($id = null)
    {
        $data = $this->request->getJSON();
        $data['id_dosen'] = $id;

        if (!$this->dosenModel->find($id)) {
            return $this->failNotFound("Data dosen dengan ID $id tidak ditemukan.");
        }

        if (!$this->dosenModel->save($data)) {
            return $this->fail($this->dosenModel->errors());
        }

        return $this->respond([
            'status' => 200,
            'message' => 'Data dosen berhasil diupdate.'
        ]);
    }

    public function delete($id = null)
    {
        if (!$this->dosenModel->find($id)) {
            return $this->failNotFound("Data dosen dengan ID $id tidak ditemukan.");
        }

        $this->dosenModel->delete($id);

        return $this->respondDeleted([
            'status' => 200,
            'message' => 'Data dosen berhasil dihapus.'
        ]);
    }
}

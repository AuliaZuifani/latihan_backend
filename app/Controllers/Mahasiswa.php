<?php

namespace App\Controllers;

use App\Models\UserModel;
use App\Models\DosenModel;
use App\Models\KajurModel;
use App\Models\MahasiswaModel;
use CodeIgniter\API\ResponseTrait;

// Menambahkan Header CORS Global
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, X-Requested-With, Authorization");

class Mahasiswa extends BaseController
{
    use ResponseTrait;
    protected $userModel;
    protected $mahasiswaModel;
    protected $dosenModel;
    protected $kajurModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
        $this->dosenModel = new DosenModel();
        $this->mahasiswaModel = new MahasiswaModel();
        $this->kajurModel = new KajurModel();
    }

    public function index()
    {
        $data = $this->mahasiswaModel->findAll();
        return $this->respond($data, 200);
    }

    public function show($id = null)
    {
        $data = $this->mahasiswaModel->where("npm", $id)->findAll();
        if ($data) {
            return $this->respond($data, 200);
        } else {
            return $this->failNotFound("Data tidak ditemukan");
        }
    }

    public function showName($nama = null)
    {
        try {
            if (empty($nama)) {
                return $this->fail("Nama mahasiswa harus diisi", 400);
            }

            $data = $this->mahasiswaModel
                ->where("nama_mahasiswa", $nama)
                ->findAll();

            if (!empty($data)) {
                return $this->respond([
                    "status" => 200,
                    "message" => "Data mahasiswa ditemukan",
                    "data" => $data,
                ], 200);
            } else {
                return $this->failNotFound("Data mahasiswa dengan nama " . $nama . " tidak ditemukan");
            }
        } catch (\Exception $e) {
            return $this->fail("Terjadi kesalahan: " . $e->getMessage(), 500);
        }
    }

    public function create()
    {
        $data = $this->request->getJSON();

        // Akses sebagai object
        $npmCheck = $this->mahasiswaModel->where('npm', $data->npm)->first();
        if ($npmCheck) {
            return $this->fail(["message" => "NPM sudah digunakan"], 400);
        }

        $userCheck = $this->userModel
            ->where("id_user", $data->id_user)
            ->where("username", $data->nama_mahasiswa)
            ->first();
        if (!$userCheck) {
            return $this->fail([
                "message" => "ID User tidak sesuai dengan yang ada di tabel user / Nama mahasiswa tidak ada di table user",
            ], 400);
        }

        $kajurCheck = $this->kajurModel
            ->where("id_kajur", $data->id_kajur)
            ->first();
        if (!$kajurCheck) {
            return $this->fail([
                "message" => "ID Kajur tidak ditemukan di tabel kajur",
            ], 400);
        }

        // Ubah ke array sebelum save
        $dataArray = [
            'npm' => $data->npm,
            'id_user' => $data->id_user,
            'id_dosen' => $data->id_dosen,
            'id_kajur' => $data->id_kajur,
            'nama_mahasiswa' => $data->nama_mahasiswa
        ];

        if (!$this->mahasiswaModel->save($dataArray)) {
            return $this->fail($this->mahasiswaModel->errors());
        }

        return $this->respond([
            "status" => 200,
            "message" => ["success" => "Berhasil Menambah Data"],
        ], 200);
    }

    public function update($id = null)
    {
       $data = (array) $this->request->getJSON();
        $data["npm"] = $id;

        $ifExist = $this->mahasiswaModel->where("npm", $id)->findAll();
        if (!$ifExist) {
            return $this->failNotFound("Data tidak ditemukan");
        }

        $npmCheck = $this->mahasiswaModel
            ->where("npm", $data["npm"])
            ->where("npm !=", $id)
            ->first();
        if ($npmCheck) {
            return $this->fail(["message" => "NPM sudah digunakan"], 400);
        }

        $userCheck = $this->userModel
            ->where("id_user", $data["id_user"])
            ->where("username", $data["nama_mahasiswa"])
            ->first();
        if (!$userCheck) {
            return $this->fail([
                "message" => "ID User dan username tidak sesuai dengan data di tabel user",
            ], 400);
        }

        $kajurCheck = $this->kajurModel
            ->where("id_kajur", $data["id_kajur"])
            ->first();
        if (!$kajurCheck) {
            return $this->fail([
                "message" => "ID Kajur tidak ditemukan di tabel kajur",
            ], 400);
        }

        if (!$this->mahasiswaModel->save($data)) {
            return $this->fail($this->mahasiswaModel->errors());
        }

        return $this->respond([
            "status" => 200,
            "message" => ["success" => "Berhasil Mengubah Data"],
        ], 200);
    }

    public function delete($npm = null)
    {
        $mahasiswa = $this->mahasiswaModel->where("npm", $npm)->first();

        if ($mahasiswa) {
            $this->mahasiswaModel->where("npm", $npm)->delete();
            return $this->respondDeleted([
                "status" => 200,
                "message" => ["success" => "Data berhasil dihapus."],
            ]);
        } else {
            return $this->failNotFound("Data dengan NPM $npm tidak ditemukan.");
        }
    }
}

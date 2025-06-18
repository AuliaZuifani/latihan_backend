<?php

namespace App\Models;

use CodeIgniter\Model;

class DosenModel extends Model
{
    protected $table = 'dosen_wali';         // Nama tabel di database
    protected $primaryKey = 'id_dosen';      // Primary key tabel

    protected $allowedFields = [
        'nama_dosen',
        'nidn',
        'id_user'
    ];

    protected $useTimestamps = false;        // Ubah ke true jika kamu pakai created_at/updated_at

    protected $returnType = 'array';         // Hasil dikembalikan dalam bentuk array
}

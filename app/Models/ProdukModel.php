<?php

namespace App\Models;

use CodeIgniter\Model;

class ProdukModel extends Model
{
    protected $table = 'produk';
    protected $primaryKey = 'id_produk';
    protected $allowedFields = [
        'id_produk',
        'nama_produk',
        'harga',
        'kategori_id',
        'status_id'
    ];
}

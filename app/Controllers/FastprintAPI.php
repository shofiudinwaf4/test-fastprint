<?php

namespace App\Controllers;

use App\Models\ProdukModel;
use App\Models\StatusModel;
use CodeIgniter\Controller;
use App\Models\KategoriModel;

class FastprintAPI extends Controller
{
    public function index()
    {
        $url = 'https://recruitment.fastprint.co.id/tes/api_tes_programmer';

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HEADER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'username' => 'x',
                'password' => 'x'
            ]),
            CURLOPT_COOKIEJAR => WRITEPATH . 'cookie.txt'
        ]);

        $response = curl_exec($ch);
        curl_close($ch);

        preg_match('/x-credentials-username:\s*(.*)/i', $response, $match);
        $username = trim(explode(' ', $match[1])[0]);

        preg_match('/Date:\s*(.*)/i', $response, $dateMatch);
        $serverDate = $dateMatch[1];

        $day = date('d', strtotime($serverDate));
        $month = date('m', strtotime($serverDate));
        $year = date('y', strtotime($serverDate));

        $password = md5("bisacoding-$day-$month-$year");

        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => http_build_query([
                'username' => $username,
                'password' => $password
            ]),
            CURLOPT_COOKIEFILE => WRITEPATH . 'cookie.txt'
        ]);

        $result = curl_exec($ch);
        curl_close($ch);

        $json = json_decode($result, true);

        if ($json['error'] == 1) {
            return $this->response->setJSON($json);
        }

        $produkModel = new ProdukModel();
        $kategoriModel = new KategoriModel();
        $statusModel = new StatusModel();

        foreach ($json['data'] as $row) {

            $kategori = $kategoriModel
                ->where('nama_kategori', $row['kategori'])
                ->first();

            if (!$kategori) {
                $kategoriId = $kategoriModel->insert([
                    'nama_kategori' => $row['kategori']
                ]);
            } else {
                $kategoriId = $kategori['id_kategori'];
            }

            $status = $statusModel
                ->where('nama_status', $row['status'])
                ->first();

            if (!$status) {
                $statusId = $statusModel->insert([
                    'nama_status' => $row['status']
                ]);
            } else {
                $statusId = $status['id_status'];
            }

            $produkModel->save([
                'id_produk'   => $row['id_produk'],
                'nama_produk' => $row['nama_produk'],
                'harga'       => $row['harga'],
                'kategori_id' => $kategoriId,
                'status_id'   => $statusId
            ]);
        }

        return $this->response->setJSON([
            'message' => 'Data berhasil disimpan',
            'total' => count($json['data'])
        ]);
    }
}

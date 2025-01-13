<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Helpers\BpjsHelper;

class BpjsController extends BaseController
{
    // http://localhost:8080/bpjs
    public function index()
    {
        $bpjs = new BpjsHelper();

        // Contoh pemanggilan API referensi faskes
        $response = $bpjs->sendRequest('referensi/faskes/1101', 'GET');

        return $this->response->setJSON($response);
    }

    // https://faskes.bpjs-kesehatan.go.id/aplicares/Referensi/propinsi
    public function getPropinsi()
    {
        $bpjs = new BpjsHelper();

        $response = $bpjs->sendRequest('Referensi/propinsi', 'GET');

        return $this->response->setJSON($response);
    }

    // https://faskes.bpjs-kesehatan.go.id/aplicares/Referensi/dati2/{id}
    public function getDati2($id)
    {
        $bpjs = new BpjsHelper();

        $response = $bpjs->sendRequest('Referensi/dati2/' . $id, 'GET');

        return $this->response->setJSON($response);
    }

    // https://faskes.bpjs-kesehatan.go.id/aplicares/Pencarian/getList
    // {\"params\":{},\"jnscari\":\"carifaskes\",\"jnscari1\":\"bylocation\",\"dati2ppk\":\"0226\",\"jnsppk\":\"P\",\"lat\":-8.6562761,\"lng\":115.15932969999999}
    public function getList()
    {
        $bpjs = new BpjsHelper();

        $data = [
            "params" => [],
            "jnscari" => "carifaskes",
            "jnscari1" => "bylocation",
            "dati2ppk" => "0226",
            "jnsppk" => "P",
            "lat" => -8.6562761,
            "lng" => 115.15932969999999
        ];

        $response = $bpjs->sendRequest('Pencarian/getList', 'POST', $data);

        return $this->response->setJSON($response);
    }
}

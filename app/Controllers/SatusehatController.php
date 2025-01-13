<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Helpers\SatusehatHelper;
class SatusehatController extends BaseController
{
    public function index()
    {
        //
    }
    
    // http://localhost:8080/satusehat/getPatient/{patientId}
    public function getPatient($patientId)
    {
        $satusehat = new SatusehatHelper();

        // Contoh: Mendapatkan data pasien berdasarkan ID
        $response = $satusehat->sendRequest('Patient/' . $patientId, 'GET');

        return $this->response->setJSON($response);
    }

    // http://localhost:8080/satusehat/createPatient
    public function createPatient()
    {
        $satusehat = new SatusehatHelper();

        // Data pasien yang ingin dikirim
        $data = [
            "resourceType" => "Patient",
            "identifier" => [
                [
                    "use" => "official",
                    "value" => "123456789"
                ]
            ],
            "name" => [
                [
                    "use" => "official",
                    "family" => "Doe",
                    "given" => ["John"]
                ]
            ],
            "gender" => "male",
            "birthDate" => "1990-01-01"
        ];

        // Contoh: Membuat pasien baru
        $response = $satusehat->sendRequest('Patient', 'POST', $data);

        return $this->response->setJSON($response);
    }
}

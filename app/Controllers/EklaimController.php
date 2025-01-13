<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use CodeIgniter\HTTP\ResponseInterface;
use App\Helpers\EklaimHelper;
class EklaimController extends BaseController
{
    public function index()
    {
        //
    }

    // http://localhost:8080/eklaim/getDataSEP/{sepNumber}
    public function getDataSEP($sepNumber)
    {
        $eklaim = new EklaimHelper();

        // Contoh pemanggilan API untuk mendapatkan data SEP
        $response = $eklaim->sendRequest('SEP/' . $sepNumber, 'GET');

        return $this->response->setJSON($response);
    }

    // http://localhost:8080/eklaim/createSEP
    public function createSEP()
    {
        $eklaim = new EklaimHelper();

        // Contoh data yang diperlukan untuk membuat SEP
        $data = [
            "request" => [
                "t_sep" => [
                    "noKartu" => "1234567890123",
                    "tglSep" => "2025-01-13",
                    "ppkPelayanan" => "0195R001",
                    "jnsPelayanan" => "2",
                    "klsRawat" => [
                        "klsRawatHak" => "3",
                        "klsRawatNaik" => "2",
                        "pembiayaan" => "1",
                        "penanggungJawab" => "BPJS"
                    ],
                    "noMR" => "MR123456",
                    "rujukan" => [
                        "asalRujukan" => "1",
                        "tglRujukan" => "2025-01-12",
                        "noRujukan" => "1234567890",
                        "ppkRujukan" => "0195R001"
                    ],
                    "catatan" => "Rawat jalan",
                    "diagAwal" => "A09",
                    "poli" => [
                        "tujuan" => "ANA",
                        "eksekutif" => "0"
                    ],
                    "cob" => ["cob" => "0"],
                    "katarak" => ["katarak" => "0"],
                    "jaminan" => [
                        "lakaLantas" => "0",
                        "penjamin" => ["penjamin" => "0"]
                    ],
                    "skdp" => ["noSurat" => "1234"],
                    "dpjpLayan" => "1234",
                    "noTelp" => "08123456789",
                    "user" => "admin"
                ]
            ]
        ];

        // Contoh pemanggilan API untuk membuat SEP
        $response = $eklaim->sendRequest('SEP/insert', 'POST', $data);

        return $this->response->setJSON($response);
    }
}

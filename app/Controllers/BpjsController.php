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
}

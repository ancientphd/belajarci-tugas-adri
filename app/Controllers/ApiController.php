<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

use App\Models\UserModel;
use App\Models\TransactionModel;
use App\Models\TransactionDetailModel;

class ApiController extends ResourceController
{
    protected $apiKey;
    protected $user;
    protected $transaction;
    protected $transaction_detail;

    function __construct()
    {
        $this->apiKey = env('API_KEY');
        $this->user = new UserModel();
        $this->transaction = new TransactionModel();
        $this->transaction_detail = new TransactionDetailModel();
    }

    public function index()
    {
        $data = [ 
            'results' => [],
            'status' => ["code" => 401, "description" => "Unauthorized"]
        ];

        $key = $this->request->getHeaderLine('key');

        if ($key === $this->apiKey) {
            $penjualan = $this->transaction->findAll();

        foreach ($penjualan as &$pj) {
            $details = $this->transaction_detail->where('transaction_id', $pj['id'])->findAll();
            $pj['details'] = $details;

            // ❗ Tambahkan ini untuk menghitung jumlah item
            $pj['total_item'] = array_sum(array_column($details, 'jumlah'));
        }


            $data['status'] = ["code" => 200, "description" => "OK"];
            $data['results'] = $penjualan;
        }

        return $this->respond($data);
    }

    public function show($id = null)
    {
        //
    }

    public function new()
    {
        //
    }

    public function create()
    {
        //
    }

    public function edit($id = null)
    {
        //
    }

    public function update($id = null)
    {
        //
    }

    public function delete($id = null)
    {
        //
    }
}
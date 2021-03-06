<?php namespace App\Controllers;

use CodeIgniter\RESTful\ResourceController;

class Banks extends ResourceController
{
    protected $modelName = 'App\Models\Bank_model';
    protected $format    = 'json';

    public function index()
    {
        // ------------------------------------------------------------------------
        // rows penerbit atau tabel unit_usaha
        // ------------------------------------------------------------------------
        $rows = $this->model->findAll();

        // ------------------------------------------------------------------------
        // modification json output value type: int
        // ------------------------------------------------------------------------
        foreach ($rows as $key => $value) {
            // RAW URL Encode image name
            $value['image'] = rawurlencode($value['gambar']);

            $rows_all[] = [
                'id'                => intval($value['id_bank']),
                'name'              => $value['nama'],
                'account_number'    => $value['no_rekening'],
                'on_behalf'         => $value['atas_nama'],
                'image'             => [
                    'origin'    => "https://anakhebatindonesia.com/joimg/bank/" . $value['image'],
                ],
            ];
        }
        return $this->setResponseAPI($rows_all,200);
    }

    public function show($id = NULL)
    {
        $get = $this->model->get($id);

        // ------------------------------------------------------------------------
        // modification image value
        // ------------------------------------------------------------------------
        $get->image = rawurlencode($get->image);
        $get->image = [
            'origin'    => "https://anakhebatindonesia.com/joimg/author/{$get->image}",
            'thumbnail' => "https://anakhebatindonesia.com/joimg/author/small/small_{$get->image}"
        ];
        $get->title = $get->name;

        if($get){
            $code = 200;
            $response = [
                'status' => $code,
                'error' => false,
                'data' => $get,
            ];
        } else {
            $code = 401;
            $msg = ['message' => 'Not Found'];
            $response = [
                'status' => $code,
                'error' => true,
                'data' => $msg,
            ];
        }
        return $this->setResponseAPI($response, $code);
    }

    protected function setResponseAPI($body,$statusCode)
    {
        $options = [
            'max-age'  => 1200,
            's-maxage' => 3600,
            'etag'     => 'abcde'
        ];
        
        $this->response->setHeader('Access-Control-Allow-Origin', '*')
            ->setHeader('Access-Control-Allow-Headers', '*')
            ->setHeader('Access-Control-Allow-Methods', 'GET, POST, OPTIONS, PUT, DELETE')
            ->setCache($options);
        return $this->respond($body, $statusCode);
    }
 
}
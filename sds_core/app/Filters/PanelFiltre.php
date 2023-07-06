<?php

namespace App\Filters;

use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\Filters\FilterInterface;

class PanelFiltre implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        if (session()->has('kullanici_sds')){
            return redirect()->to(base_url('anasayfa'));
        }
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        // Do something here
    }
}
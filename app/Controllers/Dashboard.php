<?php

namespace App\Controllers;

class Dashboard extends BaseController
{
    public function index()
    {
        $data = [
            'title' => 'Starter Project CodeIgniter 4'
        ];

        return view('dashboard/index', $data);
    }
}
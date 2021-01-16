<?php

namespace App\Controllers;

use App\Models\BuilderModel;

class Builder extends BaseController
{
    protected $builderModel;

    public function __construct()
    {
        $this->builderModel = new BuilderModel();   
        helper('form'); 
    }

    public function index()
    {
        $data = [
            'title' => 'Crud Query Builder',
            'all_data' => $this->builderModel->select_data() // selecting all data
        ];

        return view('builder/index', $data);
    }

    public function add_data()
    {
        // validation
        $rules = $this->validate([
            'name' => 'required',
            'department' => 'required',
            'position' => 'required',
            'age' => 'required|numeric' 
        ]);

        if (!$rules) {
            session()->setFlashData('failed', \Config\Services::validation()->getErrors());
            return redirect()->back();
        }

        $data = [
            'name'       => $this->request->getPost('name'),
            'department' => $this->request->getPost('department'),
            'position'   => $this->request->getPost('position'),
            'age'        => $this->request->getPost('age')
        ];

        $this->builderModel->add_data($data);
        session()->setFlashData('success', 'data has been added to database.');
        return redirect()->back();
    }

    public function delete_data($id)
    {
        $this->builderModel->delete_data($id);
        session()->setFlashData('success', 'data has been deleted from database.');
        return redirect()->back();
    }

    public function update_data($id)
    {
        // validation
        $rules = $this->validate([
            'name' => 'required',
            'department' => 'required',
            'position' => 'required',
            'age' => 'required|numeric'
        ]);

        if (!$rules) {
            session()->setFlashData('failed', \Config\Services::validation()->getErrors());
            return redirect()->back();
        }

        $data = [
            'name'       => $this->request->getPost('name'),
            'department' => $this->request->getPost('department'),
            'position'   => $this->request->getPost('position'),
            'age'        => $this->request->getPost('age')
        ];

        $this->builderModel->update_data($id, $data);
        session()->setFlashData('success', 'data has been updated from database.');
        return redirect()->back();
    }
}

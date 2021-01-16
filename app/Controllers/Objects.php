<?php

namespace App\Controllers;

use App\Models\ObjectModel;

class Objects extends BaseController
{
    protected $objectModel;

    public function __construct()
    {
        $this->objectModel = new ObjectModel();
        helper('form');    
    }

    public function index()
    {
        $data = [
            'title' => 'CRUD Object Model',
            'all_data' => $this->objectModel->findAll()
        ];

        return view('objects/index', $data);
    }

    public function add_data()
    {
        $data['title'] = 'Add Data';
        if ($this->request->getPost()) {
            $rules = [
                'name' => 'required|alpha_space',
                'gender' => 'required',
                'address' => 'required',
                'photo' => 'uploaded[photo]|max_size[photo,2048]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]'
            ];

            if ($this->validate($rules)) {
                $photo = $this->request->getFile('photo');
                $photoName = $photo->getRandomName();
                $photo->move('photos', $photoName);

                $inserted = [
                    'name' => $this->request->getPost('name'),
                    'gender' => $this->request->getPost('gender'),
                    'address' => $this->request->getPost('address'),
                    'photo' => $photoName
                ];

                $this->objectModel->insert($inserted);
                session()->setFlashData('success', 'data has been added to database');
                return redirect()->to('/objects');
            } else {
                session()->setFlashData('failed', \Config\Services::validation()->getErrors());
                return redirect()->back()->withInput();
            }
        }
        return view('objects/form_add', $data);
    }

    public function delete_data($id)
    {
        $photoId = $this->objectModel->find($id);
        unlink('photos/'.$photoId['photo']);

        $this->objectModel->delete($id);
        session()->setFlashData('success', 'data has been deleted from database.');
        return redirect()->to('/objects');
    }

    public function update_data($id)
    {
        $data = [
            'title' => 'Update Data',
            'dataById' => $this->objectModel->where('id', $id)->first()
        ];

        if ($this->request->getPost()) {
            $rules = [
                'name' => 'required|alpha_space',
                'gender' => 'required',
                'address' => 'required',
                'photo' => 'max_size[photo,2048]|is_image[photo]|mime_in[photo,image/jpg,image/jpeg,image/png]'
            ];

            if ($this->validate($rules)) {
                $photo = $this->request->getFile('photo');
                if ($photo->getError() == 4) {
                    $photoName = $this->request->getPost('Oldphoto');
                } else {
                    $photoName = $photo->getRandomName();
                    $photo->move('photos', $photoName);
                    $photo = $this->objectModel->find($id);
                    if ($photo['photo'] == $photo['photo']) {
                        unlink('photos/' . $this->request->getPost('Oldphoto'));
                    }
                }

                $inserted = [
                    'name' => $this->request->getPost('name'),
                    'gender' => $this->request->getPost('gender'),
                    'address' => $this->request->getPost('address'),
                    'photo' => $photoName
                ];

                $this->objectModel->update($id, $inserted);
                session()->setFlashData('success', 'data has been updated from database');
                return redirect()->to('/objects');
            } else {
                session()->setFlashData('failed', \Config\Services::validation()->getErrors());
                return redirect()->back()->withInput();
            }
        }
        return view('objects/form_update', $data); 
    }
}

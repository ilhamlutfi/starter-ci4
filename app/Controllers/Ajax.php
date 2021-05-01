<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\AjaxModel;

class Ajax extends BaseController
{
	protected $ajax;

	public function __construct()
	{
		$this->ajax = new AjaxModel();
	}

	public function index()
	{
		$data = [
			'title' => 'CRUD Ajax jQuery'
		];

		return view('ajax/index', $data);
	}

	public function get_data()
	{
		if ($this->request->isAJAX()) {
			$data = [
				'data_products' => $this->ajax->findAll()
			];

			$result = [
				'output' => view('ajax/view_data', $data)
			];

			echo json_encode($result);
		} else {
			exit('404 Not Found');
		}
	}

	public function get_modal()
	{
		if ($this->request->isAJAX()) {
			$result = [
				'output' => view('ajax/view_modal')
			];

			echo json_encode($result);
		} else {
			exit('404 Not Found');
		}
	}

	public function save_data()
	{
		if ($this->request->isAJAX()) {
			$validation = \Config\Services::validation();

			$rules = $this->validate([
				'name' => [
					'label' => 'product name',
					'rules' => 'required|min_length[3]',
				],
				'description' => [
					'label' => 'product desc',
					'rules' => 'required|min_length[3]',
				],
				'price' => [
					'label' => 'product price',
					'rules' => 'required|numeric',
				],
				'date' => [
					'label' => 'product date',
					'rules' => 'required',
				]
			]);

			if (!$rules) {
				$result = [
					'error' => [
						'name' => $validation->getError('name'),
						'description' => $validation->getError('description'),
						'price' => $validation->getError('price'),
						'date' => $validation->getError('date')
					]
				];
			} else {
				$this->ajax->insert([
					'name' => strip_tags($this->request->getPost('name')),
					'description' => strip_tags($this->request->getPost('description')),
					'price' => strip_tags($this->request->getPost('price')),
					'date' => strip_tags($this->request->getPost('date'))
				]);

				$result = [
					'success' => 'Data has been added to database'
				];
			}
			echo json_encode($result);
		} else {
			exit('404 Not Found');
		}
	}

	public function get_modal_edit()
	{
		if ($this->request->isAJAX()) {
			$id = $this->request->getVar('id');

			$row = $this->ajax->find($id);

			$data = [
				'id'	=> $row['id'],
				'name'	=> $row['name'],
				'description'	=> $row['description'],
				'price'	=> $row['price'],
				'date'	=> $row['date']
			];

			$result = [
				'output' => view('ajax/view_modal_edit', $data)
			];

			echo json_encode($result);
		} else {
			exit('404 Not Found');
		}
	}

	public function update_data()
	{
		if ($this->request->isAJAX()) {
			$validation = \Config\Services::validation();

			$rules = $this->validate([
				'name' => [
					'label' => 'product name',
					'rules' => 'required|min_length[3]',
				],
				'description' => [
					'label' => 'product desc',
					'rules' => 'required|min_length[3]',
				],
				'price' => [
					'label' => 'product price',
					'rules' => 'required|numeric',
				],
				'date' => [
					'label' => 'product date',
					'rules' => 'required',
				]
			]);

			if (!$rules) {
				$result = [
					'error' => [
						'name' => $validation->getError('name'),
						'description' => $validation->getError('description'),
						'price' => $validation->getError('price'),
						'date' => $validation->getError('date')
					]
				];
			} else {
				$id = $this->request->getPost('id');
				$this->ajax->update($id, [
					'name' => strip_tags($this->request->getPost('name')),
					'description' => strip_tags($this->request->getPost('description')),
					'price' => strip_tags($this->request->getPost('price')),
					'date' => strip_tags($this->request->getPost('date'))
				]);

				$result = [
					'success' => 'Data has been updated from database'
				];
			}
			echo json_encode($result);
		} else {
			exit('404 Not Found');
		}
	}

	public function delete_data()
	{
		if ($this->request->isAJAX()) {
			$id = $this->request->getVar('id');

			$this->ajax->delete($id);

			$result = [
				'output' => "Data has been deleted from database"
			];

			echo json_encode($result);
		} else {
			exit('404 Not Found');
		}
	}
}

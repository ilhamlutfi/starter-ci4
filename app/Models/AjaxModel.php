<?php

namespace App\Models;

use CodeIgniter\Model;

class AjaxModel extends Model
{
	protected $table         = 'products';
	protected $primaryKey    = 'id';
	protected $returnType    = 'array';
	protected $allowedFields = ['name', 'description', 'price', 'date'];
	protected $useTimestamps = true;
	protected $createdField  = 'created_at';
	protected $updatedField  = 'updated_at';
}

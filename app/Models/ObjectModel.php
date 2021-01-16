<?php

namespace App\Models;

use CodeIgniter\Model;

class ObjectModel extends Model
{
    protected $table         = 'students';
    protected $primaryKey    = 'id';
    protected $returnType    = 'array';
    protected $allowedFields = ['name', 'gender', 'address', 'photo'];
    protected $useTimestamps = true;
    protected $createdField  = 'created_at';
    protected $updatedField  = 'updated_at';
}
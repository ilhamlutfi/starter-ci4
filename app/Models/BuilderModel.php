<?php

namespace App\Models;

use CodeIgniter\Model;

class BuilderModel extends Model
{
    protected $db, $builder;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->builder = $this->db->table('employees'); // tabel employees  
    }

    // func select all data or by id
    public function select_data($id = FALSE)
    {
        if ($id == FALSE) {
            return $this->builder->get()->getResultObject();
        }

        return $this->builder->getWhere(['id' => $id])->getRow();
    }

    // func insert data to db
    public function add_data($data)
    {
        $this->builder->insert($data);
    }

    // func delete data from db
    public function delete_data($id)
    {
        $this->builder->where('id', $id);
        $this->builder->delete();
    }

    // func update data from db
    public function update_data($id, $data)
    {
        $this->builder->where('id', $id);
        $this->builder->update($data);
    }
}

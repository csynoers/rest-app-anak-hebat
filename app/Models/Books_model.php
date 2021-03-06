<?php namespace App\Models;

use CodeIgniter\Model;
 
class Books_model extends Model {
 
    protected $table = 'book';
    protected $primaryKey = 'id_book';
 
    public function getBooks($id = false)
    {
        if($id === false){
            return $this->findAll();
        } else {
            return $this->getWhere([$this->primaryKey => $id])->getRowObject();
        }  
    }
     
    public function insertBooks($data)
    {
        return $this->db->table($this->table)->insert($data);
    }
 
    public function updateBooks($data, $id)
    {
        return $this->db->table($this->table)->update($data, [$this->primaryKey => $id]);
    }
 
    public function deleteBooks($id)
    {
        return $this->db->table($this->table)->delete([$this->primaryKey => $id]);
    }
} 
<?php defined('BASEPATH') OR exit('No direct script access allowed');

class EmailModel extends CI_Model {

	public function __construct(){
		$this->load->database();
	}
	public function getAll($table, $limit, $start, $search = NULL) {
        if ($search == NULL) 
            $search = ""; 
        if($table == 'contacts'){
	        $query = $this->db->order_by('id', 'DESC')
	        				->limit($limit, $start)
	                        ->like('name', $search)
	                        ->or_like('email',$search)
	                        ->or_like('mobile',$search)
	                        ->get($table); 
	   	}else{
	   		$query = $this->db->order_by('id', 'DESC')
	        				->limit($limit, $start)
	                        ->like('name', $search)
	                        ->get($table);
	   	}                

        if ($query->num_rows() > 0) {
            return $query->result();
        }
   	}
	public function getList($table){
		return $this->db->order_by('id', 'DESC')->get($table)->result();
	}
	public function findById($table, $id){
		try {
			return $this->db->get_where($table,['id'=>$id])->row();
		} catch (Exception $e) {
			return false;
		}	
	}
	public function findBy($id,$val, $table){
		try {
			return $this->db->get_where($table,[$id=>$val]);
		} catch (Exception $e) {
			return false;
		}
	}
	public function findByEmail($table, $email){
		return $this->db->get_where($table,['email'=>$email]);
	}
	public function findByName($table, $name){
		return $this->db->get_where($table,['name'=>$name]);
	}
	public function save($table, $data){
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}
	public function update($table, $id, $data){
		return $this->db->where('id', $id)->update($table, $data);
	}
	public function delete($table, $id){
		return $this->db->delete($table , ['id' => $id]);
	}
	public function deleteBy($id, $val, $table){
		return $this->db->delete($table , [$id => $val]);
	}
	public function deletePivot($table,$id,$val){
		return $this->db->delete($table , [$id => $val]);
	}
	public function getPivotDataByGroupId($table, $group_id){
		return $this->db->get_where($table,['group_id'=>$group_id]);
	}
	public function dataCount($table, $search = NULL){
		if ($search == NULL) 
            $search = "";
        if($table == 'contacts'){
        	return $this->db->like('name', $search)->or_like('email',$search)->or_like('mobile',$search)->get($table)->num_rows();
        }else{
        	return $this->db->like('name', $search)->get($table)->num_rows();
        }
	}
}
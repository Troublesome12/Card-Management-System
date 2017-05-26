<?php defined('BASEPATH') OR exit('No direct script access allowed');

class AuthModel extends CI_Model {
	public function checkLogin($email, $password) {

		$this ->db-> select('*');
		$this ->db-> from('users');
		$this ->db-> where('email', $email);
		$this ->db-> where('password', $password);
		$this ->db-> limit(1);

		$query = $this -> db -> get();
 
		if($query -> num_rows() == 1)
			return $query->row();
		else
			return false;
	}

	public function saveLogInfo($user_id, $ip) {
		$data = array(
			'user_id' => $user_id,
			'ip_address' => $ip,
			'created_at' => date() 
		);

		$data = array_filter($data);
        $this->db->insert('logs', $data);
	}
}
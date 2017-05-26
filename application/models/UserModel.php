<?php defined('BASEPATH') OR exit('No direct script access allowed');

class UserModel extends CI_Model {
	
	public function getSettings() {
		return $this->db->get('settings')->row();
	}

	public function saveSettings() {
        $data = array(
            'facebook_link' => $this->input->post('facebook'),
            'twitter_link' => $this->input->post('twitter'),
            'linkedin_link' => $this->input->post('linkedin'),
            'google_plus_link' => $this->input->post('google'),
            'copyright' => $this->input->post('copyright'),
        );
        $data = array_filter($data);
        $this->db->where('id', 1)->update('settings', $data);
	}

	public function getUserList() {
		return $this->db->get('users')->result();
	}

	public function getPermissionList() {
		return $this->db->get('permissions')->result();
	}

	public function getUserPermission($user_id) {
		$this->db->select("user_permission.permission_id AS id, permissions.name");
		$this->db->from('user_permission');
		$this->db->join('permissions', 'permissions.id = user_permission.permission_id');
		$this->db->where('user_permission.user_id', $user_id);
		return $this->db->get()->result();
	}

	public function addPermission($id = 0) {
        $isAdmin = $this->input->post('isAdmin');
        if($this->input->post('permissions') || $isAdmin) {
            if($this->input->post('user_id')) {
            	$user_id = $this->input->post('user_id');
            } else {
            	$user_id = $id;
            }

            if(!$isAdmin) {    //the user is not admin
                $permissions = $this->input->post('permissions');
                foreach ($permissions as $permission_id) {
                    $data = array(
                      'user_id' => $user_id,
                      'permission_id' => $permission_id
                    );

                    $this->db->insert('user_permission', $data);
                }
            } else {    //the user is admin
                $this->db->insert('user_permission', ['user_id' => $user_id, 'permission_id' => 1]);    //card management
                $this->db->insert('user_permission', ['user_id' => $user_id, 'permission_id' => 2]);    //email management
            }
        }
    }

    public function deletePermission($user_id) {
        $this->db->where('user_id', $user_id)->delete('user_permission');
    }

    public function deleteEvent($user_id) {
        $this->db->where('user_id', $user_id)->delete('events');
    }

    public function deleteLog($user_id) {
        $this->db->where('user_id', $user_id)->delete('logs');  
    }

	public function editPermission() {
        $user_id = $this->input->post('user_id');
        $this->deletePermission($user_id);
        $this->addPermission();
    }

    public function deleteUser($user_id) {
    	$this->db->where('id', $user_id)
                  ->delete('users');
    }

    public function insertUser() {
    	$password = base64_encode(hash_hmac('whirlpool', $this->input->post('password'), true));
    	$data = array(  
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'password' => $password,
            'isAdmin' => $this->input->post('isAdmin')
        );
        
        $data = array_filter($data);
        $this->db->insert('users', $data);
        return $this->db->insert_id();
    }

    public function editUserWithImage($image) {
    	$password = base64_encode(hash_hmac('whirlpool', $this->input->post('password'), true));
    	$id = $this->input->post('id');

        $data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'password' => $password,
            'image' => $image
        );
        $this->db->where('id', $id)->update('users', $data);
    }

    public function editUser() {
    	$password = base64_encode(hash_hmac('whirlpool', $this->input->post('password'), true));
    	$id = $this->input->post('id');

        $data = array(
            'name' => $this->input->post('name'),
            'email' => $this->input->post('email'),
            'password' => $password
        );
        $this->db->where('id', $id)->update('users', $data);
    }

    public function getUserImage($id) {
    	$this->db->select('image');
    	return $this->db->get_where('users', ['id', $id])->row();
    }

    public function getUserById($id) {
        return $this->db->where('id', $id)->get('users')->row();
    }

    public function getLogs($limit, $start, $search = NULL) {
        if ($search == "NIL") 
            $search = ""; 

        $this->db->limit($limit, $start);
        $this->db->select("*");
        $this->db->from('logs');
        $this->db->join('users', 'users.id = logs.user_id');                
        $this->db->like('name', $search);
        $this->db->or_like('email', $search);
        $this->db->or_like('ip_address', $search);
        $this->db->or_like('created_at', $search);
        $this->db->order_by('logs.id', 'DESC');
        return $this->db->get()->result();
    }

    public function dataCount($search = NULL) {
        if ($search == "NIL") 
            $search = "";

        $this->db->from('logs');
        $this->db->join('users', 'users.id = logs.user_id');
        $this->db->like('name', $search);
        $this->db->or_like('email', $search);
        $this->db->or_like('ip_address', $search);
        $this->db->or_like('created_at', $search);
        return $this->db->get()->num_rows(); 
    }

    public function cardCount() {
        return $this->db->count_all('cards'); 
    }

    public function contactCount() {
        return $this->db->count_all('contacts');
    }

    public function userCount() {
        return $this->db->count_all('users');   
    }

    public function viewCount() {
        return $this->db->count_all('logs');  
    }

    public function getAllUsers() {
        return $this->db->get('users')->result();
    }

    public function getUserEvents($user_id) {
        return $this->db->where('user_id', $user_id)->get('events')->result();
    }

    public function addEvent($id) {
        $start = date('Y-m-d', strtotime($this->input->post('start')));
        $end = date('Y-m-d', strtotime($this->input->post('end')));
        
        $data=array(
            'user_id'=>$id,
            'title'=>$this->input->post('title'),
            'description'=>$this->input->post('description'),
            'color'=>$this->input->post('color'),
            'start'=>$start,
            'end'=>$end
        );
        
        $data=array_filter($data);
        $this->db->insert('events', $data);
    }

    public function editEvent() {
        $id=$this->input->post('id');
        $start = date('Y-m-d', strtotime($this->input->post('start')));
        $end = date('Y-m-d', strtotime($this->input->post('end')));
        
        $data=array(
            'start'=>$start,
            'end'=>$end,
            'title'=>$this->input->post('title'),
            'description'=>$this->input->post('description'),
            'color'=>$this->input->post('color')
        );
        
        $this->db->where('id',$id)->update('events',$data);
    }

    public function editEventDate() {
        $Event = $this->input->post('event');
        if($Event[0] && $Event[1] && $Event[2]){
            $id = $Event[0];
            $start = date('Y-m-d', strtotime($Event[1]));
            $end = date('Y-m-d', strtotime('-1 day',strtotime($Event[2])));
            $data=array(
                'start'=> $start,
                'end'=> $end
            );
            $data=array_filter($data); 
            $this->db->where('id',$Event[0])->update('events',$data);
        }
    }

    public function eventDelete() {
        $id = $this->uri->segment(3);
        $this->db->where('id', $id)->delete('events');
    }
}
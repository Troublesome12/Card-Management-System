<?php defined('BASEPATH') OR exit('No direct script access allowed');


class User extends CI_Controller {
    public $user;

	public function __construct() {
		parent::__construct();
		$this->load->model('UserModel', 'userModel');
		
        if(!$this->session->userdata('logged_in'))
            return redirect('auth');

        $user_id = $this->session->userdata('logged_in')['id'];
        $this->user = $this->userModel->getUserById($user_id);
	}

    public function index() {
        $data['settings'] = $this->userModel->getSettings();
        $data['user'] = $this->user;  //information of logged in user
        $data['cardCount'] = $this->userModel->cardCount();
        $data['contactCount'] = $this->userModel->contactCount();
        $data['userCount'] = $this->userModel->userCount();
        $data['viewCount'] = $this->userModel->viewCount();
        $data['users'] = $this->userModel->getAllUsers();
        $data['events'] = $this->userModel->getUserEvents($this->user->id);

        $data['title'] = 'Home';
        $data['active'] = 'Home';
        $this->load->view('partials/head', $data);
        $this->load->view('partials/navbar', $data);
        $this->load->view('users/home', $data);
    }

	public function Logout() {
        $this->session->unset_userdata('logged_in');
        redirect('auth');
    }

    public function settings() {
        if(!$this->user->isAdmin) {
            $this->load->view('errors/forbidden.php');
            return;
        }

    	$data['settings'] = $this->userModel->getSettings();
    	$data['user'] = $this->user;	//information of logged in user
    	$data['users'] = $this->userModel->getUserList();
        $data['permission_list'] = $this->userModel->getPermissionList();
        $data['user_permissions'] = $this->userModel->getUserPermission($this->user->id);

    	$data['title'] = 'Settings';
        $data['active'] = 'Settings';
		$this->load->view('partials/head', $data);
		$this->load->view('partials/navbar', $data);
		$this->load->view('users/settings', $data);
		$this->load->view('partials/bottom', $data);
    }

    public function imageUpload(){
        if(!$this->user->isAdmin) {
            $this->load->view('errors/forbidden.php');
            return;
        }

        $config['upload_path']          = './assets/images/';
        $config['allowed_types']        = 'png';
         
        $filename = $_FILES['logo']['name'];
		$extension = pathinfo($filename, PATHINFO_EXTENSION);

        $new_name = 'logo.'.$extension;
		$config['file_name'] = $new_name;

        $this->load->library('upload', $config);
        
        if(! $this->upload->do_upload('logo')) {
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata(['message' => '<h3>Something went wrong with the image</h3>', 'type' => 'error']);
            $this->settings();
        }
    }

    public function userImageUpload(){

        $config['upload_path']          = './assets/images/';
        $config['allowed_types']        = 'jpg|jpeg|png';
         
        $filename = $_FILES['image']['name'];
        $extension = pathinfo($filename, PATHINFO_EXTENSION);

        $new_name = time().'.'.$extension;
        $config['file_name'] = $new_name;

        $this->load->library('upload', $config);
        
        if(! $this->upload->do_upload('image')) {
            $error = array('error' => $this->upload->display_errors());
            $this->session->set_flashdata(['message' => '<h3>Something went wrong with the image</h3>', 'type' => 'error']);
            $this->create();
        } else {
            return $new_name;
        }
    }

    public function saveSettings() {
        if(!$this->user->isAdmin) {
            $this->load->view('errors/forbidden.php');
            return;
        }

    	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		if($this->form_validation->run('settings')){	//if the validation passes the settings rules
			
			if(strlen($_FILES['logo']['name']) > 4) {
				unlink('./assets/images/logo.png');
				$this->imageUpload();
			}
			$this->userModel->saveSettings();
			$this->session->set_flashdata(['message' => '<h3>The settings has been saved successfully!</h3>', 'type' => 'success']);
			return redirect('card');
		} else {
			$this->settings();
		}	
    }

    public function editPermission() {
        if(!$this->user->isAdmin) {
            $this->load->view('errors/forbidden.php');
            return;
        }

        $this->userModel->editPermission();
        $this->session->set_flashdata(['message' => '<h3>The permission has been updated successfully!</h3>', 'type' => 'success']);
        redirect('user/settings');
    }

    public function deleteUser() {
        if(!$this->user->isAdmin) {
            $this->load->view('errors/forbidden.php');
            return;
        }
        
        $userId = $this->input->post('id');
        $this->userModel->deletePermission($userId);
        $this->userModel->deleteEvent($userId);
        $this->userModel->deleteLog($userId);
        $this->userModel->deleteUser($userId);
        $this->session->set_flashdata(['message' => '<h3>The user has been removed successfully!</h3>', 'type' => 'success']);
    }

    public function createUser() {
        if(!$this->user->isAdmin) {
            $this->load->view('errors/forbidden.php');
            return;
        }

        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
        if($this->form_validation->run('createUser')){  //if the validation passes the creating user rules
            $userId = $this->userModel->insertUser();
            $this->userModel->addPermission($userId);
            $this->session->set_flashdata(['message' => '<h3>The user has been added successfully!</h3>', 'type' => 'success']);
            return redirect('user/settings');
        } else {
            $this->settings();
        }
    }

    public function accountSettings() {
        $data['settings'] = $this->userModel->getSettings();
        $data['user'] = $this->user;  //information of logged in user
        $data['user_permissions'] = $this->userModel->getUserPermission($this->user->id);

        $data['title'] = 'Account Settings';
        $data['active'] = 'Settings';
        $this->load->view('partials/head', $data);
        $this->load->view('partials/navbar', $data);
        $this->load->view('users/accountSettings', $data);
        $this->load->view('partials/bottom', $data);  
    }

    public function update() {
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
        if($this->form_validation->run('editUser')){    //if the validation passes the editing user rules
            $id = $this->input->post('id');
            if(strlen($_FILES['image']['name']) > 4) {
                $old_image = $this->userModel->getUserImage($id)->image;
                if(strlen($old_image) > 4) {
                    unlink('./assets/images/'.$old_image);
                }
                $image = $this->userImageUpload();
                $this->userModel->editUserWithImage($image);
            } else {
                $this->userModel->editUser();
            }
            $this->session->set_flashdata(['message' => '<h3>The user has been edited successfully!</h3>', 'type' => 'success']);
            return redirect('card');
        } else {
            $this->accountSettings();
        }
    }

    public function log() {
        $this->load->library("pagination");
        if(!$this->user->isAdmin) {
            $this->load->view('errors/forbidden.php');
            return;
        }

        $this->load->helper('cookie');
        $config["base_url"] = base_url()."user/log";
        $config["total_rows"] = $this->userModel->dataCount(NULL);
        $config["per_page"] = 10;
        $config["uri_segment"] = 3;
        $this->pagination->initialize($config); 
        $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

        $data["logs"] = $this->userModel
                        ->getLogs($config["per_page"], $page, NULL);
        $data["links"] = $this->pagination->create_links();
        $data['user'] = $this->user;
        $data['settings'] = $this->userModel->getSettings();

        //loading views
        $data['title'] = 'User Log';
        $data['active'] = 'Log';
        $this->load->view('partials/head', $data);
        $this->load->view('partials/navbar', $data);
        $this->load->view('users/log', $data);
        $this->load->view('partials/bottom', $data);
    }

    function searchLog() {
        if(!$this->user->isAdmin) {
            $this->load->view('errors/forbidden.php');
            return;
        }
        
        $this->load->library("pagination");
        // get search string
        $search = ($this->input->post("search"))? 
            $this->input->post("search") : "NIL";

        $search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;
        
        $config["base_url"] = base_url()."user/searchLog/$search/";
        $config["total_rows"] = $this->userModel->dataCount($search);
        $config["per_page"] = 10;
        $config["uri_segment"] = 4;

        $this->pagination->initialize($config); 
        $page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        
        $data["logs"] = $this->userModel
                        ->getLogs($config["per_page"], $page, $search);
        $data["links"] = $this->pagination->create_links();
        $data['user'] = $this->user;
        $data['settings'] = $this->userModel->getSettings();

        //loading views
        $data['title'] = 'User Log';
        $data['active'] = 'Log';
        $this->load->view('partials/head', $data);
        $this->load->view('partials/navbar', $data);
        $this->load->view('users/log', $data);
        $this->load->view('partials/bottom', $data);
    }

    public function addEvent() {
        $this->userModel->addEvent($this->user->id);
        $this->session->set_flashdata(['message' => '<h3>The event has been added successfully!</h3>', 'type' => 'success']);
        redirect('user');
    }

    public function editEvent() {
        $this->userModel->editEvent();
        $this->session->set_flashdata(['message' => '<h3>The event has been edited successfully!</h3>', 'type' => 'success']);
        redirect('user');
    }

    public function editEventDate() {
        $this->userModel->editEventDate();
        redirect('user'); 
    }

    public function eventDelete() {
        $this->userModel->eventDelete();
        $this->session->set_flashdata(['message' => '<h3>The event has been deleted successfully!</h3>', 'type' => 'success']);
        redirect('user'); 
    }
}
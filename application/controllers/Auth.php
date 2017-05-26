<?php defined('BASEPATH') OR exit('No direct script access allowed');


class Auth extends CI_Controller {

	public function __construct() {
		parent::__construct();
		$this->load->model('AuthModel', 'authModel');

		if($this->session->userdata('logged_in'))
			return redirect('user');
	}

	public function index() {
		$this->load->view('auth/login');
	}

	public function login() {
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		if($this->form_validation->run('login')){	//if the validation passes the creating card rules
			$user_id = $this->checkDatabase();
			if($user_id) {
				$this->saveLogInfo($user_id);
				return redirect('user');
			} else
				$this->index();
		} else {
			$this->index();
		}
	}

	public function checkDatabase() {
		$email = $this->input->post('email');
		$password = base64_encode(hash_hmac('whirlpool', $this->input->post('password'), true));
		
		$result = $this->authModel->checkLogin($email, $password);
		if($result) {
			$data = array(
				'id' => $result->id,
				'name' => $result->name,
				'email' => $result->email,
				'image' => $result->image
			);
			$this->session->set_userdata('logged_in', $data);
			return $result->id;
		} else {
			$this->session->set_flashdata('error', 'Invalid email or password');
			return false;
		}
	}

	public function getIpAddress() {
	    if(!empty($_SERVER['HTTP_CLIENT_IP'])) {  //check ip from share internet
	      	$ip=$_SERVER['HTTP_CLIENT_IP'];
	  	} elseif(!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {   //to check ip is pass from proxy
			$ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
	    } else
	      	$ip=$_SERVER['REMOTE_ADDR'];
	    return $ip;
	}

	public function saveLogInfo($user_id) {
		$ip = $this->getIpAddress();
		$this->authModel->saveLogInfo($user_id, $ip);
	}
}
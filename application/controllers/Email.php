<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Email extends CI_Controller {
	public $hasPermission = FALSE;
    public $user;

	public function __construct() {
		parent::__construct();
		$this->load->model('EmailModel','emailModel');
		$this->load->model('UserModel', 'userModel');
		$this->load->library("pagination");
		//redirect to login page if not authenticated
		if(!$this->session->userdata('logged_in'))
            return redirect('auth');

        $user_id = $this->session->userdata('logged_in')['id'];
        $permissions = $this->userModel->getUserPermission($user_id);
        foreach ($permissions as $value) {
            if($value->name == 'Email Management') {
                $this->hasPermission = TRUE;
            }
        }

        $this->user = $this->userModel->getUserById($user_id);
	}

	public function index() {
		$user_id = $this->session->userdata('logged_in')['id'];
		$data['user'] = $this->user;
		
        $data['settings'] = $this->userModel->getSettings();
        $data['hasPermission'] = $this->hasPermission;

		// get all contact list and group list from db
        $data['groups'] = $this->emailModel->getList('groups');
        $data['contacts'] = $this->emailModel->getList('contacts');
        // get data from manage table
        $data['manage'] = $this->emailModel->findBy('user_id',$user_id,'manage_emails')->row();
		//loading views
        $data['title'] = 'Send Email';
		$data['active'] = 'Send Email';
		$this->load->view('partials/head', $data);
		$this->load->view('partials/navbar', $data);
        $this->load->view('emails/send_email', $data);
        $this->load->view('partials/bottom', $data);
	}
	// upload send email file
	public function emailFileUpload(){
		$config['upload_path']          = './assets/files/email/';
        $config['allowed_types']        = '*';

        $filename = $_FILES['file']['name'];
		$extension = pathinfo($filename, PATHINFO_EXTENSION);

        $new_name = time().'.'.$extension;
		$config['file_name'] = $new_name;

        $this->load->library('upload', $config);
        
        if(! $this->upload->do_upload('file')) {
            $error = array('error' => $this->upload->display_errors());
            echo "error";
        } else {
        	echo 'assets/files/email/'.$new_name;
        }
	}
	// remove files
	function removeUselessFiles(){

	}
	// email send
	public function sendEmail(){

		$toData = $this->input->post('to');
		$from = $this->input->post('from');
		$subject = $this->input->post('subject');
		$message = $this->input->post('message');
		$user_id = $this->input->post('id');

		$emails = array();
		$i=0;
		foreach($toData as $to){
			if(is_numeric($to)){
				// get email from group
				$contacts = $this->emailModel->getPivotDataByGroupId('contact_group', $to)->result();

				foreach($contacts as $contact){
					$email = $this->emailModel->findById('contacts',$contact->contact_id);
					$emails[$i] = $email->email;
					$i++;
				}
			}else{
				$emails[$i] = $to;
				$i++;
			}
		}
		$emails = array_unique($emails);
		// load email library
		$this->load->library('email');

		// initialize email config get it from email status
		/*$config['protocol'] = 'smtp';
		$config['smtp_host'] = 'smtp.mailtrap.io'; // 'smtp.flickmax.net'
		$config['smtp_port'] = 2525;	// 25
		$config['smtp_user'] = '0e1fad3b05c8e5';
		$config['smtp_pass'] = 'c188f2a283ae40';
		$config['wordwrap'] = TRUE;

		$this->email->initialize($config);*/
		$errors = array();
		for($i=0; sizeof($emails);$i++){

			// store data so that it can be inserted into db
			$data = new stdClass();
			$data->user_id = $this->session->userdata('logged_in')['id'];
			$data->from = $from;
			$data->to = $emails[$i];
			$data->subject = $subject;
			$data->message = $message;

			// sent email
			$this->email->from($from, 'User');
			$this->email->to($emails[$i]);
			$this->email->set_header('Header', 'FlickMax');
			$this->email->subject($subject);
			$this->email->message($message);
			if($this->email->send()){
				$data->status = 1;
			}else{
				$data->status = 0;
				$errors[] = $emails[$i];
			}
			// insert into sent_email_status table
			$this->emailModel->save('sent_email_status', $data);
		}
		print_r($errors);
	}
	// manage email
	public function manage(){
		if(!$this->hasPermission && !$this->user->isAdmin) {
            $this->load->view('errors/forbidden.php');
            return;
        }

		$user_id = $this->session->userdata('logged_in')['id'];
		$data['user'] = $this->user;
		$data['user_id'] = $user_id;
        $data['settings'] = $this->userModel->getSettings();
        $data['hasPermission'] = $this->hasPermission;

		// get all contact list and group list from db
        $data['groups'] = $this->emailModel->getList('groups');
        $data['contacts'] = $this->emailModel->getList('contacts');
        // get data from manage table
        $data['manage'] = $this->emailModel->findBy('user_id',$user_id,'manage_emails')->row();
		//loading views
        $data['title'] = 'Manage Email';
		$data['active'] = 'Manage Email';
		$this->load->view('partials/head', $data);
		$this->load->view('partials/navbar', $data);
        $this->load->view('emails/manage_email', $data);
        $this->load->view('partials/bottom', $data);	
	}
	// insert or update manage_emails table
	public function manageStore(){
		if(!$this->hasPermission && !$this->user->isAdmin) {
            $this->load->view('errors/forbidden.php');
            return;
        }

		// get all data from form
		$groups = $this->input->post('groups');
		$contacts = $this->input->post('contacts');
		$subject = $this->input->post('subject');
		$footer = $this->input->post('footer');
		$user_id = $this->input->post('id');
		$group_id = '';
		if(isset($groups)){
			foreach($groups as $group){
				$group_id .= $group.',';
			}
		}
		$contact_id = '';
		if(isset($contacts)){
			foreach($contacts as $contact){
				$contact_id .= $contact.',';
			}
		}
		// find if user already inserted data on manage_emails table
		$user = $this->emailModel->findBy('user_id', $user_id, 'manage_emails');
		if($user->num_rows() > 0){
			// update table
			$data = new stdClass();
			$data->group_id = $group_id;
			$data->contact_id = $contact_id;
			$data->subject = $subject;
			$data->footer = $footer;
			$this->emailModel->update('manage_emails',$user->row()->id, $data);
			echo "update";
		}else{
			// insert on table
			$data = new stdClass();
			$data->user_id = $user_id;
			$data->group_id = $group_id;
			$data->contact_id = $contact_id;
			$data->subject = $subject;
			$data->footer = $footer;
			$this->emailModel->save('manage_emails', $data);
			echo "save";
		}
	}
	// remove manage delete
	public function manageReset(){
		if(!$this->hasPermission && !$this->user->isAdmin) {
            $this->load->view('errors/forbidden.php');
            return;
        }

		$user_id = $this->input->post('id');
		if($this->emailModel->deleteBy('user_id', $user_id, 'manage_emails')){
			echo "done";
		}else{
			echo "Something went wrong";
		}
	}
	// email contact 
	//get email contact list from `contact` table
	public function contact(){
		$data['user'] = $this->user;
        $data['settings'] = $this->userModel->getSettings();
        $data['hasPermission'] = $this->hasPermission;

		// initialize pagination
		$config["base_url"] = base_url()."email/contact/";
		$config["total_rows"] = $this->emailModel->dataCount('contacts',NULL);
 		$config["per_page"] = 10;
 		$config["uri_segment"] = 3;
 		$this->pagination->initialize($config); 
 		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
 		
    	$data["contacts"] = $this->emailModel->getAll('contacts',$config["per_page"], $page, NULL);
        $data["links"] = $this->pagination->create_links();
        $data['page'] = $page;
        //loading views
        $data['title'] = 'Contacts';
        $data['active'] = 'Contacts';
		// get all contact list from contact table
		$this->load->view('partials/head', $data);
		$this->load->view('partials/navbar', $data);
        $this->load->view('emails/contact', $data);
	}

	// create contact and insert into contact table
	public function createContact(){
		if(!$this->hasPermission && !$this->user->isAdmin) {
            $this->load->view('errors/forbidden.php');
            return;
        }

		// set form validation
		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		if($this->form_validation->run('createContact')){
			// insert into contact table
			$data = new stdClass();
			$data->name = $this->input->post('name');
			$data->email = $this->input->post('email');
			$data->mobile = $this->input->post('mobile');
			if($this->emailModel->save('contacts',$data)){
				// set success message
				$this->session->set_flashdata(['message'=> 'Contact has successfully saved', 'type'=> 'success']);
			}else{
				// set error message
				$this->session->set_flashdata(['message'=> 'Something went wrong', 'type'=> 'error']);
			}
			redirect('email/contact');
		}else{
			$this->contact();
		}
	}

	// update contact tabele
	public function updateContact(){
		if(!$this->hasPermission && !$this->user->isAdmin) {
            $this->load->view('errors/forbidden.php');
            return;
        }

		// get the data from contact table of this id
		$row = $this->emailModel->findById('contacts',$this->input->post('id'));
		// check if new email is already into contact table
		$new_email = trim($this->input->post('email'));

		$email = $this->emailModel->findByEmail('contacts',$new_email);
		if($email->num_rows() > 0 && $email->row()->id != $this->input->post('id')){
			// set exist(warning) message
			echo "exist";
		}else{
			// update contact table
			$row->name = $this->input->post('name');
			$row->email = $new_email;
			$row->mobile = $this->input->post('mobile');
			if($this->emailModel->update('contacts',$this->input->post('id'), $row)){
				echo "success";
			}else{
				// set error message
				echo "warning";
			}
		}
	}

	// delete contact after confirm the delete
	public function deleteContact(){
		if(!$this->hasPermission && !$this->user->isAdmin) {
            $this->load->view('errors/forbidden.php');
            return;
        }

		if($this->emailModel->delete('contacts',$this->input->post('id'))){
			echo "success";
		}else{
			echo "warning";
		}
	}

	function search() {
		$data['user'] = $this->user;
        $data['settings'] = $this->userModel->getSettings();
        $data['hasPermission'] = $this->hasPermission;

		// get search string
        $search = ($this->input->get("search"))? 
        	$this->input->get("search") : NULL;

        $search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;
        
        $config["base_url"] = base_url()."email/search/$search";
		$config["total_rows"] = $this->emailModel->dataCount($this->input->get("from"),$search);
 		$config["per_page"] = 10;
 		$config["uri_segment"] = 4;

 		$this->pagination->initialize($config); 
 		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
        $data[$this->input->get("from")] = $this->emailModel
        				->getAll($this->input->get("from"),$config["per_page"], $page,$search);
		$data["links"] = $this->pagination->create_links();
	    $data["page"] = $page;

	    $view = substr_replace($this->input->get("from"), "", -1);
		// get all contact list from contact table
		//loading views
        $data['title'] = 'Contacts';
        $data['active'] = 'Contacts';
		$this->load->view('partials/head', $data);
		$this->load->view('partials/navbar', $data);
		$this->load->view('emails/'.$view, $data);	
	}

	// import(csv and xls) and export contact page
	public function import(){
		if(!$this->hasPermission && !$this->user->isAdmin) {
            $this->load->view('errors/forbidden.php');
            return;
        }

		$data['user'] = $this->user;
        $data['settings'] = $this->userModel->getSettings();
        $data['hasPermission'] = $this->hasPermission;

        //loading views
        $data['title'] = 'Import';
        $data['active'] = 'Contacts';
		$this->load->view('partials/head', $data);
		$this->load->view('partials/navbar', $data);
        $this->load->view('emails/contact_import');
	}

	public function upload(){
		if(!$this->hasPermission && !$this->user->isAdmin) {
            $this->load->view('errors/forbidden.php');
            return;
        }

		//$file = $this->input->post('contact_file');
		$file = $_FILES['contact_file']['tmp_name'];
    	$handle = fopen($file, "r");
    	$i = 1;
    	// get data from csv or excel file
		if ($file == NULL){
			// set error message
	  		$this->session->set_flashdata(['message'=> 'please import a csv file', 'type'=> 'warning']);
	  		return redirect('email/contact');
	    }
	    else{
	    	while(($filesop = fgetcsv($handle, 1000, ",")) !== false){
	    		if($filesop[0] == 'name' && $filesop[1] =='email' && $filesop[2] == 'mobile'){
	    			continue;
	    		}else{
	    			$email = $this->emailModel->findByEmail('contacts',$filesop[1]);
	    			if($email->num_rows()){
	    				continue;
	    			}else{
	    				if(strlen($filesop[2]== 0) || ($filesop[2] > 0 && strlen($filesop[2]) >= 7)){
		    				$i++;
		    				$row = array(
		    					'name' => $filesop[0],
		    					'email' => $filesop[1],
		    					'mobile' => $filesop[2],
		    				);
			    			$this->emailModel->save('contacts',$row);
			    		}else{
			    			continue;
			    		}
	    			}
	    		}
	      	}
	  	}
	  	if($i==1){
	  		// set error message
	  		$this->session->set_flashdata(['message'=> 'Nothing to insert', 'type'=> 'warning']);
	  		return redirect('email/contact');
	  	}else{
	  		// set success message with $i`th row insertion
	  		$this->session->set_flashdata(['message'=> 'Contact has successfully inserted', 'type'=> 'success']);
	  		return redirect('email/contact');
	  	}
	}

	// get all data from contact table
	function getAllDataOnTable(){
		$contacts = $this->emailModel->getList('contacts');
		$data = "";
		foreach($contacts as $contact){
			$data .= '<tr><td>'.$contact->name.'</td>';
			$data .= '<td>'.$contact->email.'</td>';
			$data .= '<td>'.$contact->mobile.'</td></tr>';
		}
		echo $data;
	}

	// manage group code contunies from here
	function group(){
		$data['user'] = $this->user;
        $data['settings'] = $this->userModel->getSettings();
        $data['hasPermission'] = $this->hasPermission;
        
		// initialize pagination
		$config["base_url"] = base_url()."email/group/";
		$config["total_rows"] = $this->emailModel->dataCount('groups',NULL);
 		$config["per_page"] = 10;
 		$config["uri_segment"] = 3;
 		$this->pagination->initialize($config); 
 		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
 		$data['contacts'] = $this->emailModel->getList('contacts');
    	$data["groups"] = $this->emailModel->getAll('groups',$config["per_page"], $page, NULL);
        $data["links"] = $this->pagination->create_links();
        $data['page'] = $page;
		// get all contact list from contact table
		//loading views
		$data['title'] = 'Groups';
        $data['active'] = 'Groups';
		$this->load->view('partials/head', $data);
		$this->load->view('partials/navbar', $data);
        $this->load->view('emails/group',$data);
	}

	// crarte group
	function createGroup(){
		if(!$this->hasPermission && !$this->user->isAdmin) {
            $this->load->view('errors/forbidden.php');
            return;
        }

		// get data from createGroup form
		$name = $this->input->post('name');
		$emails = $this->input->post('emails');

		// check if already has a group of this name
		$group = $this->emailModel->findByName('groups',$name);
		if($group->num_rows() > 0){
			// set error message
	  		$this->session->set_flashdata(['message'=> 'Group has already exists', 'type'=> 'warning']);
	  		return redirect('email/group');
		}
		$insert = 0;
		$group_id = $this->emailModel->save('groups',array('name'=>$name));
		if($group_id)
			$insert = 1;
		if($insert){
			foreach ($emails as $contactId) {
				// save data into pivot(contact_group) table
				$data = new stdClass();
				$data->group_id = $group_id;
				$data->contact_id = $contactId;
				if($this->emailModel->save('contact_group', $data))
					$insert = 1;
				else{
					$insert = 0;
					break;
				}
			}
		}
		if($insert){
			$this->session->set_flashdata(['message'=> 'Group has successfully created', 'type'=> 'success']);
	  		return redirect('email/group');
		}else{
			// set error message
	  		$this->session->set_flashdata(['message'=> 'Something went wrong', 'type'=> 'warning']);
	  		return redirect('email/group');
		}
	}

	// delete contact after confirm the delete
	public function deleteGroup(){
		if(!$this->hasPermission && !$this->user->isAdmin) {
            $this->load->view('errors/forbidden.php');
            return;
        }

		$this->emailModel->deletePivot('contact_group','group_id',$this->input->post('id'));

		if($this->emailModel->delete('groups',$this->input->post('id'))){
			echo "success";
		}else{
			echo "warning";
		}
	}

	// update group
	function updateGroup(){
		if(!$this->hasPermission && !$this->user->isAdmin) {
            $this->load->view('errors/forbidden.php');
            return;
        }

		// get the data from contact table of this id
		$row = $this->emailModel->findById('groups',$this->input->post('id'));
		// check if new email is already into contact table
		$new_name = trim($this->input->post('name'));
		// check if group name already exists
		$name = $this->emailModel->findByName('groups',$new_name);

		if($name->num_rows() > 0 && $name->row()->id != $this->input->post('id')){
			// set exist(warning) message
			echo "existGroup";
		}else{
			$id = $this->input->post('id');
			$emails = $this->input->post('email');
			// update group name
			$this->emailModel->update('groups', $id, ['name'=> $new_name]);
			
			// update pivot table
			if($emails){
				// update pivot table
				// delete all data from pivot table where group_id = $this->input->post('id')
				$this->emailModel->deletePivot('contact_group', 'group_id', $id);
				$insert = 0;
				foreach ($emails as $email){
					$contact = $this->emailModel->findByEmail('contacts',$email)->row();
					// save data into pivot(contact_group) table
					$data = new stdClass();
					$data->group_id = $id;
					$data->contact_id = $contact->id;
					
					if($this->emailModel->save('contact_group',$data))
						$insert = 1;
					else{
						$insert = 0;
						break;
					}
				}

				if($insert){
					echo "success";
				}else{
					echo "warning";
				}

			}else{
				// set exist(warning) message
				echo "noEmailFound";
			}
		}
	}

	// get all data from contact table
	function getEmailList(){
		$contacts = $this->emailModel->getList('contacts');
		$data = array();
		$i=0;
		foreach($contacts as $contact){
			$data[$i] = $contact->email;
			$i++;
		}
		echo json_encode($data);
	}

	// get all data from contact table
	function getGroupList(){
		$groups = $this->emailModel->getList('groups');
		$data = "";
		foreach($groups as $group){
			$data .= '<tr><td>'.$group->name.'</td>';
			$data .= '<td>';
			$contacts = $this->emailModel->getPivotDataByGroupId('contact_group', $group->id)->result();

			foreach($contacts as $contact){
				$email = $this->emailModel->findById('contacts',$contact->contact_id);
				$data .= $email->email.'<br>';
			}
			$data .= '</td>';
		}
		echo $data;
	}

	public function template() {
		//TODO
	}
}
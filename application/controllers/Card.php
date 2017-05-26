<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Card extends CI_Controller {
    public $hasPermission = FALSE;
    public $user;

	public function __construct() {
		parent::__construct();
		$this->load->model('CardModel', 'cardModel');
        $this->load->model('UserModel', 'userModel');
		$this->load->library("pagination");
        //redirect to login page if not authenticated
        if(!$this->session->userdata('logged_in'))
            return redirect('auth');

        $user_id = $this->session->userdata('logged_in')['id'];
        $permissions = $this->userModel->getUserPermission($user_id);
        foreach ($permissions as $value) {
            if($value->name == 'Card Management') {
                $this->hasPermission = TRUE;
            }
        }

        $this->user = $this->userModel->getUserById($user_id);
	}

	public function index(){
        $this->load->helper('cookie');
		$config["base_url"] = base_url()."card/index";
		$config["total_rows"] = $this->cardModel->dataCount(NULL);
 		$config["per_page"] = 2;
 		$config["uri_segment"] = 3;
 		$this->pagination->initialize($config); 
 		$page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;

    	$data["cards"] = $this->cardModel
        				->getAll($config["per_page"], $page, NULL);
        $data["links"] = $this->pagination->create_links();
        $data['pinnedCard'] = json_decode(get_cookie('pinnedCard'), true);
        $data['template'] = get_cookie('cardTemplate');
        $data['user'] = $this->user;
        $data['settings'] = $this->userModel->getSettings();
        $data['hasPermission'] = $this->hasPermission;

        //loading views
        $data['title'] = 'Card List';
		$data['active'] = 'Card List';
        $this->load->view('partials/head', $data);
		$this->load->view('partials/navbar', $data);
        $this->load->view('cards/index', $data);
	}

	function search() {
        $this->load->helper('cookie');

		// get search string
        $search = ($this->input->post("search"))? 
        	$this->input->post("search") : "NIL";

        $search = ($this->uri->segment(3)) ? $this->uri->segment(3) : $search;
        
        $config["base_url"] = base_url()."card/search/$search/";
		$config["total_rows"] = $this->cardModel->dataCount($search);
 		$config["per_page"] = 2;
 		$config["uri_segment"] = 4;

 		$this->pagination->initialize($config); 
 		$page = ($this->uri->segment(4)) ? $this->uri->segment(4) : 0;
 		
        $data["cards"] = $this->cardModel
        				->getAll($config["per_page"], $page, $search);
		$data["links"] = $this->pagination->create_links();
	    $data['pinnedCard'] = json_decode(get_cookie('pinnedCard'), true);
        $data['template'] = get_cookie('cardTemplate');
        $data['user'] = $this->user;
        $data['settings'] = $this->userModel->getSettings();
        $data['hasPermission'] = $this->hasPermission;

	    //loading views
	    $data['title'] = 'Card List';
        $data['active'] = 'Card List';
		$this->load->view('partials/head', $data);
		$this->load->view('partials/navbar', $data);
        $this->load->view('cards/index', $data);
	}

	public function create() {
        if(!$this->hasPermission && !$this->user->isAdmin) {
            $this->load->view('errors/forbidden.php');
            return;
        }

        $data['user'] = $this->user;
        $data['settings'] = $this->userModel->getSettings();
        $data['hasPermission'] = $this->hasPermission;

        //loading views
		$data['title'] = 'Add Card';
        $data['active'] = 'Add Card';
		$this->load->view('partials/head', $data);
		$this->load->view('partials/navbar', $data);
        $this->load->view('cards/create', $data);
        $this->load->view('partials/bottom', $data);
	}

	public function store() {
        if(!$this->hasPermission && !$this->user->isAdmin) {
            $this->load->view('errors/forbidden.php');
            return;
        }

		$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
		if($this->form_validation->run('createCard')){	//if the validation passes the creating card rules
			$this->cardModel->insertCard();
			$this->session->set_flashdata(['message' => '<h3>The card has been added successfully!</h3>', 'type' => 'success']);
			return redirect('card');
		} else {
			$this->create();
		}
	}

    public function duplicate() {
        if(!$this->hasPermission && !$this->user->isAdmin) {
            $this->load->view('errors/forbidden.php');
            return;
        }

    	if($this->input->post('id')) {
    		$id = $this->input->post('id');
    		$selectedCard = $this->cardModel->getCardById($id);
    		$this->cardModel->duplicateCard();
    		$this->session->set_flashdata(['message' => '<h3>The card has been duplicated successfully</h3>', 'type' => 'success']);
    	} else {
    		$this->session->set_flashdata(['message' => '<h3>Sorry something went wrong</h3>', 'type' => 'error', 'timer' => 2000]);
    	}
    }

    public function delete() {
        if(!$this->hasPermission && !$this->user->isAdmin) {
            $this->load->view('errors/forbidden.php');
            return;
        }

    	if($this->input->post('id')) {
    		$this->cardModel->deleteCard();
    		$this->session->set_flashdata(['message' => '<h3>The card has been deleted successfully</h3>', 'type' => 'success']);
    	} else {
    		$this->session->set_flashdata(['message' => '<h3>Sorry something went wrong</h3>', 'type' => 'error']);
    	}
    }

    public function update() {
        if(!$this->hasPermission && !$this->user->isAdmin) {
            $this->load->view('errors/forbidden.php');
            return;
        }
	
    	$this->cardModel->editCard();
        $this->session->set_flashdata(['message' => '<h3>The card has been edited successfully</h3>', 'type' => 'success']);
        redirect($_SERVER['HTTP_REFERER']);     //redirect to previous page
    }

    public function getCardList() {
    	$cards = $this->cardModel->getCardList();
		$data = "";
		foreach($cards as $card){
			$data .= '<tr><td>'.$card->name.'</td>';
			$data .= '<td>'.$card->designation.'</td>';
			$data .= '<td>'.$card->address.'</td>';
			$data .= '<td>'.$card->mobile.'</td>';
			$data .= '<td>'.$card->email.'</td>';
			$data .= '<td>'.$card->website.'</td></tr>';
		}
		echo $data;
    }

    public function setCookieValue() {
        $this->load->helper('cookie');
        $cardId = $this->input->post('id');
        $cards = json_decode(get_cookie('pinnedCard'), true);
        if($cards == null){
            $cards = array();
        }

        if (($key = array_search(['card_id', $cardId], $cards)) !== false) {    //if card_id already exist on cookie array
            unset($cards[$key]);                                   //delete if from the array
        } else {
            array_push($cards, ['card_id', $cardId]);        //if card_id doesn't exist on cookie array they add it
        }

        $data = json_encode($cards);
        $cookie = array(
            'name'   => 'pinnedCard',
            'value'  => $data,
            'expire' => today.time()+2592000     //1 month (60*60*24*30)
        );
        set_cookie($cookie);
    }

    public function getPinnedCard() {
        $this->load->helper('cookie');
        $data['pinnedCard'] = json_decode(get_cookie('pinnedCard'), true);
        $data['template'] = get_cookie('cardTemplate');
        $data["cards"] = $this->cardModel
                        ->getAllPinnedCard($data['pinnedCard']);
        
        $data["links"] = $this->pagination->create_links();
        $data['user'] = $this->user;
        $data['settings'] = $this->userModel->getSettings();
        $data['hasPermission'] = $this->hasPermission;

        // loading views
        $data['title'] = 'Pinned Cards';
        $data['active'] = 'Card List';
        $this->load->view('partials/head', $data);
        $this->load->view('partials/navbar', $data);
        $this->load->view('cards/index', $data);  
    }

    public function upload() {
        if(!$this->hasPermission && !$this->user->isAdmin) {
            $this->load->view('errors/forbidden.php');
            return;
        }

        $data['user'] = $this->user;
        $data['settings'] = $this->userModel->getSettings();
        $data['hasPermission'] = $this->hasPermission;

        // loading views
        $data['title'] = 'Import Card';
        $data['active'] = 'Import Card';
        $this->load->view('partials/head', $data);
        $this->load->view('partials/navbar', $data);
        $this->load->view('cards/upload', $data);
        $this->load->view('partials/bottom', $data);
    }

    public function import(){
        if(!$this->hasPermission && !$this->user->isAdmin) {
            $this->load->view('errors/forbidden.php');
            return;
        }
        
        $file = $_FILES['file']['tmp_name'];
        $handle = fopen($file, "r");
        $i = 1;
        // get data from csv or excel file
        if ($file == NULL){
            // set error message
            $this->session->set_flashdata(['message'=> 'please import a csv file', 'type'=> 'warning']);
            return redirect('card/upload');
        }
        else{
            while(($filesop = fgetcsv($handle, 1000, ",")) !== false){
                if($filesop[0] == 'name' && $filesop[1] =='designation' && $filesop[2] == 'address'
                    && $filesop[3] == 'mobile' && $filesop[4] == 'email' && $filesop[5] == 'website'){
                    continue;
                }else{
                    if(strlen($filesop[3]==0) || (($filesop[3]) > 0 && strlen($filesop[3]) >= 9)){       
                        $i++;
                        $data = array(
                            'name' => $filesop[0],
                            'designation' => $filesop[1],
                            'address' => $filesop[2],
                            'mobile' => $filesop[3],
                            'email' => $filesop[4],
                            'website' => $filesop[5]
                        );
                        $this->cardModel->saveCard($data);
                    }else{
                        continue;
                    }
                }
            }
        }
        if($i==1){
            // set error message
            $this->session->set_flashdata(['message'=> 'Nothing to insert', 'type'=> 'warning']);
            return redirect('card');
        }else{
            // set success message with $i`th row insertion
            $this->session->set_flashdata(['message'=> 'Card has successfully inserted', 'type'=> 'success']);
            return redirect('card');
        }
    }

    public function template() {
        $data['user'] = $this->user;
        $data['settings'] = $this->userModel->getSettings();
        $data['hasPermission'] = $this->hasPermission;
        
        //loading views
        $data['title'] = 'Card Template';
        $data['active'] = 'Card Template';
        $this->load->view('partials/head', $data);
        $this->load->view('partials/navbar', $data);
        $this->load->view('cards/template', $data);
        $this->load->view('partials/bottom', $data);
    }

    public function selectTemplate() {
        $this->load->helper('cookie');
        $template = $this->uri->segment(3);
        
        $cookie = array(
            'name'   => 'cardTemplate',
            'value'  => $template,
            'expire' => today.time()+2592000     //1 month (60*60*24*30)
        );
        set_cookie($cookie);
        redirect('card');
    }

    public function getCard() {
        if($this->input->post('id')){
            $card_id = $this->input->post('id');
            echo json_encode($this->cardModel->getCard($card_id));
        }
    }
}
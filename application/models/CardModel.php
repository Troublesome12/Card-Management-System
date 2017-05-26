<?php defined('BASEPATH') OR exit('No direct script access allowed');

class CardModel extends CI_Model {
	public function getAll($limit, $start, $search = NULL) {
        if ($search == "NIL") 
            $search = ""; 

        $query = $this->db->limit($limit, $start)
                        ->like('name', $search)
                        ->or_like('designation',$search)
                        ->or_like('address',$search)
                        ->or_like('mobile',$search)
                        ->or_like('email',$search)
                        ->or_like('website',$search)
                        ->order_by('id', 'DESC')
                        ->get('cards');                   

        return $query->result();
   	}

	public function dataCount($search = NULL) {
        if ($search == "NIL") 
            $search = "";
        $query = $this->db->like('name', $search)
                        ->or_like('designation',$search)
                        ->or_like('address',$search)
                        ->or_like('mobile',$search)
                        ->or_like('email',$search)
                        ->or_like('website',$search)
                        ->get('cards');

        return $query->num_rows();
    }

    public function insertCard() {
        $data = array(  
            'name' => $this->input->post('name'),
            'designation' => $this->input->post('designation'),
            'company' => $this->input->post('company'),
            'address' => $this->input->post('address'),
            'mobile' => $this->input->post('mobile'),
            'email' => $this->input->post('email'),
            'website' => $this->input->post('website')
        );
        
        $data = array_filter($data);
        $this->db->insert('cards', $data);
    }

    public function saveCard($data) {        
        $data = array_filter($data);
        $this->db->insert('cards', $data);
    }

    public function deleteCard() {
        $id = $this->input->post('id');
        $this->db->where('id', $id)->delete('cards');
    }

    public function getCardById($id) {
        return $this->db->where('id', $id)->get('cards')->row();
    }

    public function duplicateCard() {
        $id = $this->input->post('id');
        $selectedCard = $this->cardModel->getCardById($id);

        $data = array(  
            'name' => $selectedCard->name,
            'designation' => $selectedCard->designation,
            'company' => $selectedCard->company,
            'address' => $selectedCard->address,
            'mobile' => $selectedCard->mobile,
            'email' => $selectedCard->email,
            'website' => $selectedCard->website
        );

        $this->db->insert('cards', $data);
    }

    public function editCard() {
        $id = $this->input->post('id');
        $data = array(
            'name' => $this->input->post('name'),
            'designation' => $this->input->post('designation'),
            'company' => $this->input->post('company'),
            'address' => $this->input->post('address'),
            'mobile' => $this->input->post('mobile'),
            'email' => $this->input->post('email'),
            'website' => $this->input->post('website')
        );
        $data = array_filter($data);
        $this->db->where('id', $id)->update('cards', $data);
    }

    public function getCardList() {
        return $this->db->order_by('id', 'DESC')->get('cards')->result();                    
    }

    public function getAllPinnedCard($pinnedCards) {
        $data_array = array();
        foreach($pinnedCards as $value):
            $data_array[] = $value[1];
        endforeach;
        if(sizeof($data_array) >=1 ){
            $this->db->where_in('id', $data_array);
            return $this->db->get('cards')->result();
        }
    }

    public function getCard($card_id) {
        return $this->db->where('id', $card_id)->get('cards')->row();  
    }
}
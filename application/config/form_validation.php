<?php

$config = array(
        //rules for login form
        'login' => array(
                array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'trim|required|valid_email|max_length[255]'
                ),
                array(
                        'field' => 'password',
                        'label' => 'Password',
                        'rules' => 'trim|required|max_length[255]'
                )
        ),

        //rules for creating card
        'createCard' => array(
                array(
                        'field' => 'name',
                        'label' => 'Name',
                        'rules' => 'trim|required|max_length[100]'
                ),
                array(
                        'field' => 'designation',
                        'label' => 'Designation',
                        'rules' => 'trim|required|max_length[100]'
                ),
                array(
                        'field' => 'company',
                        'label' => 'company',
                        'rules' => 'trim|max_length[100]'
                ),
                array(
                        'field' => 'address',
                        'label' => 'Address',
                        'rules' => 'trim|required|max_length[255]'
                ),
                array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'trim|required|valid_email|max_length[255]'
                ),
                array(
                        'field' => 'mobile',
                        'label' => 'Mobile no',
                        'rules' => 'trim|required|max_length[16]|min_length[9]'
                ),
                array(
                        'field' => 'website',
                        'label' => 'Website',
                        'rules' => 'trim|valid_url|max_length[255]'
                )
        ),

        //rules for settings
        'settings' => array(
                array(
                        'field' => 'facebook',
                        'label' => 'Facebook',
                        'rules' => 'trim|required|max_length[255]'
                ),
                array(
                        'field' => 'twitter',
                        'label' => 'Twitter',
                        'rules' => 'trim|required|max_length[255]'
                ),
                array(
                        'field' => 'linkedin',
                        'label' => 'Linkedin',
                        'rules' => 'trim|required|max_length[255]'
                ),
                array(
                        'field' => 'google',
                        'label' => 'Google',
                        'rules' => 'trim|required|max_length[255]'
                ),
                array(
                        'field' => 'copyright',
                        'label' => 'Copyright',
                        'rules' => 'trim|required|max_length[255]'
                )
        ),

        //rules for creating user
        'createUser' => array(
                array(
                        'field' => 'name',
                        'label' => 'Name',
                        'rules' => 'trim|required|min_length[4]|max_length[255]'
                ),
                array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'trim|required|valid_email|max_length[255]|is_unique[users.email]'
                ),
                array(
                        'field' => 'password',
                        'label' => 'Password',
                        'rules' => 'trim|min_length[4]|max_length[255]|matches[password_confirm]'
                ),
                array(
                        'field' => 'password_confirm',
                        'label' => 'Password Confirmation',
                        'rules' => 'trim|min_length[4]|max_length[255]|matches[password]'
                )
        ),
        
        //rules for editing user
        'editUser' => array(
                array(
                        'field' => 'name',
                        'label' => 'Name',
                        'rules' => 'trim|required|max_length[255]'
                ),
                array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'trim|required|valid_email|max_length[255]'
                ),
                array(
                        'field' => 'password',
                        'label' => 'Password',
                        'rules' => 'trim|min_length[4]|max_length[255]|matches[password_confirm]'
                ),
                array(
                        'field' => 'password_confirm',
                        'label' => 'Password Confirmation',
                        'rules' => 'trim|min_length[4]|max_length[255]|matches[password]'
                )
        ),
        // rules for create email contact
        'createContact' => array(
                array(
                        'field' => 'name',
                        'label' => 'Name',
                        'rules' => 'trim|required|max_length[100]'
                ),
                array(
                        'field' => 'email',
                        'label' => 'Email',
                        'rules' => 'trim|required|valid_email|is_unique[contacts.email]'
                ),
                array(
                        'field' => 'mobile',
                        'label' => 'Mobile no',
                        'rules' => 'trim|max_length[16]|min_length[9]'
                )
        ),
);
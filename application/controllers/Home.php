<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Announcement_model');
        $this->load->model('News_model');
    }

    public function index()
    {
        $data['announcements'] = $this->Announcement_model->get_latest(3);
        $data['news'] = $this->News_model->get_latest(3);

        $this->load->view('home', $data);
        // $this->load->view('templates/front_header', $data);
        // $this->load->view('home/index', $data);
        // $this->load->view('templates/front_footer');
    }
}

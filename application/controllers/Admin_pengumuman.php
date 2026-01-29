<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_pengumuman extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // proteksi login
        if (!$this->session->userdata('user_id')) {
            redirect('admin/login');
        }

        $this->load->model('Announcement_model');
        date_default_timezone_set('Asia/Jakarta'); // sesuaikan kalau perlu
    }

    // List
    public function index()
{
    // Pagination configuration
    $per_page = 10;
    $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
    $offset = ($page - 1) * $per_page;
    
    // Search functionality
    $search = $this->input->get('search');
    $search_condition = null;
    
    if ($search && !empty(trim($search))) {
        $search_condition = trim($search);
    }
    
    // Get total records for pagination
    if ($search_condition) {
        $total_records = $this->Announcement_model->count_all_search($search_condition);
    } else {
        $total_records = $this->Announcement_model->count_all();
    }
    
    $total_pages = ceil($total_records / $per_page);
    
    // Get announcements for current page
    if ($search_condition) {
        $announcements = $this->Announcement_model->get_search_paginated($search_condition, $per_page, $offset);
    } else {
        $announcements = $this->Announcement_model->get_all_paginated($per_page, $offset);
    }
    
    $data = [
        'title' => 'Kelola Pengumuman',
        'active_menu' => 'pengumuman',
        'announcements' => $announcements,
        'total_records' => $total_records,
        'total_pages' => $total_pages,
        'current_page' => $page,
        'per_page' => $per_page,
        'search_query' => $search_condition
    ];
    
    $this->load->view('templates/admin_header', $data);
    $this->load->view('admin/pengumuman/index', $data);
    $this->load->view('templates/admin_footer');
}

    // Tambah
    public function create()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Judul', 'required');
            $this->form_validation->set_rules('body', 'Isi', 'required');

            if ($this->form_validation->run() == TRUE) {
                $insert = array(
                    'title'        => $this->input->post('title', TRUE),
                    'body'         => $this->input->post('body'),
                    'published_at' => date('Y-m-d H:i:s')  // otomatis sekarang
                );
                $this->db->insert('announcements', $insert);
                $this->session->set_flashdata('success', 'Pengumuman berhasil ditambahkan.');
                return redirect('admin/pengumuman');
            }
        }

        $data['title']       = 'Tambah Pengumuman - Admin';
        $data['active_menu'] = 'pengumuman';
    
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/pengumuman/form');
        $this->load->view('templates/admin_footer');
    }

    // Edit
    public function edit($id)
    {
        $announcement = $this->Announcement_model->get_by_id($id);
        if (!$announcement) {
            show_404();
        }

        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Judul', 'required');
            $this->form_validation->set_rules('body', 'Isi', 'required');

            if ($this->form_validation->run() == TRUE) {
                $update = array(
                    'title'        => $this->input->post('title', TRUE),
                    'body'         => $this->input->post('body'),
                    'updated_at'   => date('Y-m-d H:i:s')
                );
                $this->db->where('id', $id)->update('announcements', $update);
                $this->session->set_flashdata('success', 'Pengumuman berhasil diperbarui.');
                return redirect('admin/pengumuman');
            }
        }

        $data['announcement'] = $announcement;
        $data['title']       = 'Edit Pengumuman - Admin';
        $data['active_menu'] = 'pengumuman';
    
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/pengumuman/form', $data);
        $this->load->view('templates/admin_footer');
    }

    // Hapus
    public function delete($id)
    {
        $this->db->where('id', $id)->delete('announcements');
        $this->session->set_flashdata('success', 'Pengumuman berhasil dihapus.');
        redirect('admin/pengumuman');
    }
}

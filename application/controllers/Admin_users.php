<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_users extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // Wajib login
        if (!$this->session->userdata('user_id')) {
            redirect('admin/login');
        }

        // Hanya super_admin yang boleh masuk
        if ($this->session->userdata('user_role') !== 'super_admin') {
            redirect('errors/forbidden');
        }

        $this->load->model('User_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    // List user
    public function index()
    {
        // Pagination configuration
        $per_page = 10;
        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $offset = ($page - 1) * $per_page;
        
        // Search functionality
        $search = $this->input->get('search');
        $where = [];
        if ($search) {
            $where['search'] = $search;
        }
        
        // Get total records for pagination
        $total_records = $this->User_model->count_all($where);
        $total_pages = ceil($total_records / $per_page);
        
        // Get users for current page
        $users = $this->User_model->get_all_paginated($where, $per_page, $offset);
        
        // Get counts
        $super_admin_count = $this->User_model->count_by_role('super_admin');
        $admin_count = $this->User_model->count_by_role('admin');
        
        $data = [
            'title' => 'Kelola Admin User',
            'active_menu' => 'users',
            'users' => $users,
            'total_records' => $total_records,
            'total_pages' => $total_pages,
            'current_page' => $page,
            'per_page' => $per_page,
            'search_query' => $search,
            'super_admin_count' => $super_admin_count,
            'admin_count' => $admin_count,
            'current_user_id' => $this->session->userdata('user_id')
        ];

        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/users/index', $data);
        $this->load->view('templates/admin_footer');
    }

    // Tambah user baru
    public function create()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Nama', 'required');
            $this->form_validation->set_rules('no_wa', 'Nomor WhatsApp', 'required|is_unique[users.no_wa]');
            $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
            $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
            $this->form_validation->set_rules('role', 'Role', 'required|in_list[admin,super_admin]');

            if ($this->form_validation->run() == TRUE) {
                // Cek username sudah dipakai belum
                $existing = $this->User_model->get_by_username($this->input->post('username', TRUE));
                if ($existing) {
                    $data['custom_error'] = 'Username sudah digunakan oleh akun lain.';
                    $data['title'] = 'Tambah Admin User';
                    $data['active_menu'] = 'users';
                    
                    $this->load->view('templates/admin_header', $data);
                    $this->load->view('admin/users/form', $data);
                    $this->load->view('templates/admin_footer');
                    return;
                }

                $passwordPlain = $this->input->post('password');
                $insert = array(
                    'name'     => $this->input->post('name', TRUE),
                    'no_wa'     => $this->input->post('no_wa', TRUE),
                    'username'    => $this->input->post('username', TRUE),
                    'password' => password_hash($passwordPlain, PASSWORD_DEFAULT),
                    'role'     => $this->input->post('role'),
                    'created_at' => date('Y-m-d H:i:s')
                );

                $this->db->insert('users', $insert);
                $this->session->set_flashdata('success', 'Admin user berhasil ditambahkan.');
                return redirect('admin/users');
            }
        }

        $data['title']       = 'Tambah Admin User';
        $data['active_menu'] = 'users';
    
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/users/form', $data);
        $this->load->view('templates/admin_footer');
    }

    // Edit user
    public function edit($id)
    {
        $user = $this->User_model->get_by_id($id);
        if (!$user) {
            show_404();
        }

        $data['user'] = $user;

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Nama', 'required');
            $this->form_validation->set_rules('no_wa', 'Nomor WhatsApp', 'required|is_unique[users.no_wa]');
            $this->form_validation->set_rules('username', 'Username', 'required|is_unique[users.username]');
            $this->form_validation->set_rules('role', 'Role', 'required|in_list[admin,super_admin]');

            // password opsional saat edit
            if ($this->input->post('password')) {
                $this->form_validation->set_rules('password', 'Password', 'min_length[6]');
            }

            if ($this->form_validation->run() == TRUE) {
                // Cek username bentrok dengan user lain
                $existing = $this->User_model->get_by_username($this->input->post('username', TRUE));
                if ($existing && $existing->id != $user->id) {
                    $data['custom_error'] = 'Username sudah digunakan oleh akun lain.';
                    $data['title'] = 'Edit Admin User';
                    $data['active_menu'] = 'users';
                    
                    $this->load->view('templates/admin_header', $data);
                    $this->load->view('admin/users/form', $data);
                    $this->load->view('templates/admin_footer');
                    return;
                }

                $update = array(
                    'name'  => $this->input->post('name', TRUE),
                    'no_wa'     => $this->input->post('no_wa', TRUE),
                    'username' => $this->input->post('username', TRUE),
                    'role'  => $this->input->post('role'),
                    'updated_at' => date('Y-m-d H:i:s')
                );

                // Jika password diisi, update
                if ($this->input->post('password')) {
                    $passwordPlain = $this->input->post('password');
                    $update['password'] = password_hash($passwordPlain, PASSWORD_DEFAULT);
                }

                $this->db->where('id', $id)->update('users', $update);
                $this->session->set_flashdata('success', 'Admin user berhasil diperbarui.');
                return redirect('admin/users');
            }
        }
        
        $data['title']       = 'Edit Admin User';
        $data['active_menu'] = 'users';
    
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/users/form', $data);
        $this->load->view('templates/admin_footer');
    }

    // Hapus user
    public function delete($id)
    {
        $currentId = $this->session->userdata('user_id');

        // Tidak boleh hapus diri sendiri
        if ($id == $currentId) {
            $this->session->set_flashdata('error', 'Anda tidak dapat menghapus akun yang sedang digunakan.');
            return redirect('admin/users');
        }

        $user = $this->User_model->get_by_id($id);
        if ($user) {
            $this->db->where('id', $id)->delete('users');
            $this->session->set_flashdata('success', 'Admin user berhasil dihapus.');
        }

        redirect('admin/users');
    }
}
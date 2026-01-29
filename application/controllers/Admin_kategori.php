<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_kategori extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();

        // kalau hanya super admin yang boleh kelola kategori:
        if ($this->session->userdata('user_role') !== 'super_admin') {
            redirect('errors/forbidden');
        }

        $this->load->model('Category_model');
    }

    public function index()
    {
        // Pagination configuration
        $per_page = 10;
        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $offset = ($page - 1) * $per_page;
        
        // Search functionality
        $search = $this->input->get('search');
        
        // Get total records for pagination
        if ($search) {
            $total_records = $this->Category_model->count_all_search($search);
        } else {
            $total_records = $this->Category_model->count_all();
        }
        
        $total_pages = ceil($total_records / $per_page);
        
        // Get categories for current page
        if ($search) {
            $categories = $this->Category_model->get_search_paginated($search, $per_page, $offset);
        } else {
            $categories = $this->Category_model->get_all_paginated([], $per_page, $offset);
        }
        
        // Count news for each category
        $category_counts = [];
        foreach ($categories as $category) {
            $category_counts[$category->id] = $this->Category_model->count_news_in_category($category->id);
        }
        
        $data = [
            'title' => 'Kelola Kategori',
            'active_menu' => 'kategori',
            'categories' => $categories,
            'category_counts' => $category_counts,
            'total_records' => $total_records,
            'total_pages' => $total_pages,
            'current_page' => $page,
            'per_page' => $per_page,
            'search_query' => $search
        ];

        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/kategori/index', $data);
        $this->load->view('templates/admin_footer');
    }

    public function create()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Nama Kategori', 'required|min_length[3]|max_length[100]|is_unique[categories.name]');

            if ($this->form_validation->run() == TRUE) {
                $name = $this->input->post('name', TRUE);
                $category_id = $this->Category_model->create($name);
                
                if ($category_id) {
                    $this->session->set_flashdata('success', 'Kategori berhasil ditambahkan.');
                    return redirect('admin/kategori');
                } else {
                    $this->session->set_flashdata('error', 'Gagal menambahkan kategori. Silakan coba lagi.');
                }
            }
        }

        $data['title']       = 'Tambah Kategori';
        $data['active_menu'] = 'kategori';

        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/kategori/form', $data);
        $this->load->view('templates/admin_footer');
    }

    public function edit($id)
    {
        $category = $this->Category_model->get_by_id($id);
        if (!$category) {
            show_404();
        }

        $data['category'] = $category;
        $news_count = $this->Category_model->count_news_in_category($id);
        $data['news_count'] = $news_count;

        if ($this->input->post()) {
            $this->form_validation->set_rules('name', 'Nama Kategori', 'required|min_length[3]|max_length[100]|callback_check_category_name[' . $id . ']');

            if ($this->form_validation->run() == TRUE) {
                $name = $this->input->post('name', TRUE);
                $affected = $this->Category_model->update($id, $name);
                
                if ($affected) {
                    $this->session->set_flashdata('success', 'Kategori berhasil diperbarui.');
                    return redirect('admin/kategori');
                } else {
                    $this->session->set_flashdata('error', 'Tidak ada perubahan atau gagal memperbarui kategori.');
                }
            }
        }
        
        $data['title']       = 'Edit Kategori';
        $data['active_menu'] = 'kategori';

        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/kategori/form', $data);
        $this->load->view('templates/admin_footer');
    }

    // Custom validation callback
    public function check_category_name($name, $id)
    {
        $this->db->where('name', $name);
        $this->db->where('id !=', $id);
        $query = $this->db->get('categories');
        
        if ($query->num_rows() > 0) {
            $this->form_validation->set_message('check_category_name', 'Nama kategori sudah digunakan.');
            return FALSE;
        }
        return TRUE;
    }

    public function delete($id)
    {
        // Cek apakah kategori masih digunakan oleh berita
        $news_count = $this->Category_model->count_news_in_category($id);
        
        if ($news_count > 0) {
            $this->session->set_flashdata('error', 'Kategori masih digunakan oleh ' . $news_count . ' berita. Tidak dapat dihapus.');
            return redirect('admin/kategori');
        }

        $deleted = $this->db->where('id', $id)->delete('categories');
        
        if ($deleted) {
            $this->session->set_flashdata('success', 'Kategori berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus kategori. Silakan coba lagi.');
        }
        
        redirect('admin/kategori');
    }
}
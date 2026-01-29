<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_berita extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // proteksi login
        if (!$this->session->userdata('user_id')) {
            redirect('admin/login');
        }

        $this->load->model('News_model');
        $this->load->model('Category_model');
        $this->load->helper('text');
        date_default_timezone_set('Asia/Jakarta'); // sesuaikan kalau perlu
    }

    // List berita dengan pagination
    public function index()
    {
        // Pagination configuration
        $per_page = 10;
        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $offset = ($page - 1) * $per_page;
        
        // Search functionality
        $search = $this->input->get('search');
        $category_id = $this->input->get('category');
        
        // Get total records for pagination
        if ($search || $category_id) {
            $total_records = $this->News_model->count_all_search($search, $category_id);
        } else {
            $total_records = $this->News_model->count_all();
        }
        
        $total_pages = ceil($total_records / $per_page);
        
        // Get news for current page
        if ($search || $category_id) {
            $news_list = $this->News_model->get_search_paginated($search, $category_id, $per_page, $offset);
        } else {
            $news_list = $this->News_model->get_all_paginated([], $per_page, $offset);
        }
        
        // Get categories for filter
        $categories = $this->Category_model->get_all();
        
        $data = [
            'title' => 'Kelola Berita',
            'active_menu' => 'berita',
            'news_list' => $news_list,
            'categories' => $categories,
            'total_records' => $total_records,
            'total_pages' => $total_pages,
            'current_page' => $page,
            'per_page' => $per_page,
            'search_query' => $search,
            'selected_category' => $category_id
        ];

        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/berita/index', $data);
        $this->load->view('templates/admin_footer');
    }

    // Tambah berita
    public function create()
    {
        $data['categories'] = $this->Category_model->get_all();

        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Judul', 'required');
            $this->form_validation->set_rules('content', 'Konten', 'required');
            $this->form_validation->set_rules('category_id', 'Kategori', 'required');

            if ($this->form_validation->run() == TRUE) {
                // handle upload thumbnail (opsional)
                $thumbnail_path = null;
                if (!empty($_FILES['thumbnail']['name'])) {
                    $config['upload_path']   = './uploads/news/';
                    $config['allowed_types'] = 'jpg|jpeg|png|gif';
                    $config['max_size']      = 2048; // 2MB
                    $config['file_ext_tolower'] = TRUE;
                    $config['encrypt_name']  = TRUE;

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('thumbnail')) {
                        $upload_data   = $this->upload->data();
                        // $thumbnail_path = 'uploads/news/' . $upload_data['file_name'];
                        $thumbnail_path = $upload_data['file_name'];
                    } else {
                        $data['upload_error'] = $this->upload->display_errors();
                        // tampilkan kembali form dengan error
                        return $this->load->view('admin/berita/form', $data);
                    }
                }

                $title = $this->input->post('title', TRUE);
                $slug  = url_title(convert_accented_characters($title), 'dash', TRUE);

                $insert = array(
                    'category_id'   => $this->input->post('category_id'),
                    'title'         => $title,
                    'slug'          => $slug,
                    'content'       => $this->input->post('content'),
                    'thumbnail_path'=> $thumbnail_path,
                    'published_at'  => date('Y-m-d H:i:s')  // otomatis sekarang
                );

                $this->db->insert('news', $insert);
                $this->session->set_flashdata('success', 'Berita berhasil ditambahkan.');
                return redirect('admin/berita');
            }
        }
        $data['title']       = 'Tambah Berita - Admin';
        $data['active_menu'] = 'berita';

        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/berita/form', $data);
        $this->load->view('templates/admin_footer');
        
    }

    // Edit berita
    public function edit($id)
    {
        $news = $this->News_model->get_by_id($id);
        if (!$news) {
            show_404();
        }

        $data['news']       = $news;
        $data['categories'] = $this->Category_model->get_all();

        if ($this->input->post()) {
            $this->form_validation->set_rules('title', 'Judul', 'required');
            $this->form_validation->set_rules('content', 'Konten', 'required');
            $this->form_validation->set_rules('category_id', 'Kategori', 'required');

            if ($this->form_validation->run() == TRUE) {
                $thumbnail_path = $news->thumbnail_path;

                // jika upload thumbnail baru
                if (!empty($_FILES['thumbnail']['name'])) {
                    $config['upload_path']   = './uploads/news/';
                    $config['allowed_types'] = 'jpg|jpeg|png|gif';
                    $config['max_size']      = 2048;
                    $config['file_ext_tolower'] = TRUE;
                    $config['encrypt_name']  = TRUE;

                    $this->load->library('upload', $config);

                    if ($this->upload->do_upload('thumbnail')) {
                        // hapus file lama jika ada
                        if ($thumbnail_path && file_exists(FCPATH . $thumbnail_path)) {
                            @unlink(FCPATH . $thumbnail_path);
                        }
                        $upload_data   = $this->upload->data();
                        // $thumbnail_path = 'uploads/news/' . $upload_data['file_name'];
                        $thumbnail_path = $upload_data['file_name'];
                    } else {
                        $data['upload_error'] = $this->upload->display_errors();
                        return $this->load->view('admin/berita/form', $data);
                    }
                }

                $title = $this->input->post('title', TRUE);
                $slug  = url_title(convert_accented_characters($title), 'dash', TRUE);

                $update = array(
                    'category_id'   => $this->input->post('category_id'),
                    'title'         => $title,
                    'slug'          => $slug,
                    'content'       => $this->input->post('content'),
                    'thumbnail_path'=> $thumbnail_path,
                    'updated_at'    => date('Y-m-d H:i:s')
                );

                $this->db->where('id', $id)->update('news', $update);
                $this->session->set_flashdata('success', 'Berita berhasil diperbarui.');
                return redirect('admin/berita');
            }
        }

        $data['title']       = 'Edit Berita - Admin';
        $data['active_menu'] = 'berita';

        // $this->load->view('admin/dashboard', $data);
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/berita/form', $data);
        $this->load->view('templates/admin_footer');
    }

    // Hapus
    public function delete($id)
    {
        $news = $this->News_model->get_by_id($id);
        if ($news) {
            if ($news->thumbnail_path && file_exists(FCPATH . $news->thumbnail_path)) {
                @unlink(FCPATH . $news->thumbnail_path);
            }
            $this->db->where('id', $id)->delete('news');
        }
        $this->session->set_flashdata('success', 'Berita berhasil dihapus.');
        redirect('admin/berita');
    }
}

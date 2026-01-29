<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_tahun_kelulusan extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Graduation_year_model');
        
        // proteksi login - hanya super admin
        if ($this->session->userdata('user_role') !== 'super_admin') {
            redirect('errors/forbidden');
        }
        date_default_timezone_set('Asia/Jakarta'); // sesuaikan kalau perlu
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
            $total_records = $this->Graduation_year_model->count_all_search($search);
        } else {
            $total_records = $this->Graduation_year_model->count_all();
        }
        
        $total_pages = ceil($total_records / $per_page);
        
        // Get years for current page
        if ($search) {
            $years = $this->Graduation_year_model->get_search_paginated($search, $per_page, $offset);
        } else {
            $years = $this->Graduation_year_model->get_all_paginated([], $per_page, $offset);
        }
        
        // Count graduates for each year
        $year_counts = [];
        foreach ($years as $year) {
            $year_counts[$year->id] = $this->Graduation_year_model->count_graduates_in_year($year->year);
        }
        
        $data = [
            'title' => 'Kelola Tahun Kelulusan',
            'active_menu' => 'tahun',
            'years' => $years,
            'year_counts' => $year_counts,
            'total_records' => $total_records,
            'total_pages' => $total_pages,
            'current_page' => $page,
            'per_page' => $per_page,
            'search_query' => $search
        ];

        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/tahun_kelulusan/index', $data);
        $this->load->view('templates/admin_footer');
    }

    public function create()
    {
        if ($this->input->post()) {
            $this->form_validation->set_rules('year', 'Tahun', 'required|integer|min_length[4]|max_length[4]');

            if ($this->form_validation->run() == TRUE) {
                $year = $this->input->post('year');
                
                // Validasi tahun (1900-2100)
                if ($year < 1900 || $year > 2100) {
                    $data['custom_error'] = 'Tahun harus antara 1900-2100.';
                } else if ($this->Graduation_year_model->exists_year($year)) {
                    $data['custom_error'] = 'Tahun ' . $year . ' sudah ada dalam database.';
                } else {
                    $inserted = $this->db->insert('graduation_years', [
                        'year' => $year,
                        'created_at' => date('Y-m-d H:i:s')
                    ]);
                    
                    if ($inserted) {
                        $this->session->set_flashdata('success', 'Tahun kelulusan ' . $year . ' berhasil ditambahkan.');
                        return redirect('admin/tahun-kelulusan');
                    } else {
                        $data['custom_error'] = 'Gagal menambahkan tahun. Silakan coba lagi.';
                    }
                }
            }
        }

        $data['title']       = 'Tambah Tahun Kelulusan';
        $data['active_menu'] = 'tahun';

        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/tahun_kelulusan/form', $data);
        $this->load->view('templates/admin_footer');
    }

    public function edit($id)
    {
        $yearRow = $this->Graduation_year_model->get_by_id($id);
        if (!$yearRow) {
            show_404();
        }

        $data['yearRow'] = $yearRow;
        $graduate_count = $this->Graduation_year_model->count_graduates_in_year($yearRow->year);
        $data['graduate_count'] = $graduate_count;

        if ($this->input->post()) {
            $this->form_validation->set_rules('year', 'Tahun', 'required|integer|min_length[4]|max_length[4]');

            if ($this->form_validation->run() == TRUE) {
                $year = $this->input->post('year');
                
                // Validasi tahun
                if ($year < 1900 || $year > 2100) {
                    $data['custom_error'] = 'Tahun harus antara 1900-2100.';
                } else {
                    // cek duplikat tahun untuk id lain
                    $exists = $this->db
                        ->where('year', $year)
                        ->where('id !=', $id)
                        ->get('graduation_years')
                        ->row();

                    if ($exists) {
                        $data['custom_error'] = 'Tahun ' . $year . ' sudah digunakan.';
                    } else {
                        $updated = $this->db->where('id', $id)
                                     ->update('graduation_years', [
                                         'year' => $year,
                                         'updated_at' => date('Y-m-d H:i:s')
                                     ]);
                        
                        if ($updated) {
                            $this->session->set_flashdata('success', 'Tahun kelulusan berhasil diperbarui menjadi ' . $year . '.');
                            return redirect('admin/tahun-kelulusan');
                        } else {
                            $data['custom_error'] = 'Gagal memperbarui tahun. Silakan coba lagi.';
                        }
                    }
                }
            }
        }

        $data['title']       = 'Edit Tahun Kelulusan';
        $data['active_menu'] = 'tahun';

        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/tahun_kelulusan/form', $data);
        $this->load->view('templates/admin_footer');
    }

    public function delete($id)
    {
        $yearRow = $this->Graduation_year_model->get_by_id($id);
        if (!$yearRow) {
            show_404();
        }
        
        // Cek apakah tahun ini sudah dipakai di graduates
        $count = $this->Graduation_year_model->count_graduates_in_year($yearRow->year);

        if ($count > 0) {
            $this->session->set_flashdata('error', 'Tahun ' . $yearRow->year . ' sudah dipakai oleh ' . $count . ' data lulusan. Tidak bisa dihapus.');
            return redirect('admin/tahun-kelulusan');
        }

        $deleted = $this->db->where('id', $id)->delete('graduation_years');
        
        if ($deleted) {
            $this->session->set_flashdata('success', 'Tahun kelulusan ' . $yearRow->year . ' berhasil dihapus.');
        } else {
            $this->session->set_flashdata('error', 'Gagal menghapus tahun kelulusan. Silakan coba lagi.');
        }
        
        redirect('admin/tahun-kelulusan');
    }
}
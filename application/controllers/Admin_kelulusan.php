<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_kelulusan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();

        // proteksi login
        if (!$this->session->userdata('user_id')) {
            redirect('admin/login');
        }

        $this->load->model('Graduation_year_model');
        $this->load->model('Graduates_model');

    }

    // List kelulusan dengan pagination
    public function index()
    {
        // Pagination configuration
        $per_page = 10;
        $page = $this->input->get('page') ? (int)$this->input->get('page') : 1;
        $offset = ($page - 1) * $per_page;
        
        // Search functionality
        $search = $this->input->get('search');
        $year = $this->input->get('year');
        
        // Get total records for pagination
        if ($search || $year) {
            $total_records = $this->Graduates_model->count_all_search($search, $year);
        } else {
            $total_records = $this->Graduates_model->count_all();
        }
        
        $total_pages = ceil($total_records / $per_page);
        
        // Get graduates for current page
        if ($search || $year) {
            $graduates = $this->Graduates_model->get_search_paginated($search, $year, $per_page, $offset);
        } else {
            $graduates = $this->Graduates_model->get_all_paginated([], $per_page, $offset);
        }
        
        // Get years for filter
        $years = $this->Graduates_model->get_distinct_years();
        
        $data = [
            'title' => 'Kelola Kelulusan',
            'active_menu' => 'kelulusan',
            'graduates' => $graduates,
            'years' => $years,
            'total_records' => $total_records,
            'total_pages' => $total_pages,
            'current_page' => $page,
            'per_page' => $per_page,
            'search_query' => $search,
            'selected_year' => $year
        ];

        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/kelulusan/index', $data);
        $this->load->view('templates/admin_footer');
    }

    // Tambah data
    public function create()
{
    if ($this->input->post()) {
        $this->form_validation->set_rules('graduation_year', 'Tahun Kelulusan', 'required|integer');
        $this->form_validation->set_rules('student_name', 'Nama Siswa', 'required');
        $this->form_validation->set_rules('nisn', 'NISN', 'required');

        if ($this->form_validation->run() == TRUE) {

            // LOAD LIBRARY SEKALI SAJA
            $this->load->library('upload');

            // ==== Upload Foto (opsional) ====
            $photo_path = null;
            if (!empty($_FILES['photo']['name'])) {
                $configPhoto = array(
                    'upload_path'      => './uploads/graduates/photos/',
                    'allowed_types'    => 'jpg|jpeg|png',
                    'max_size'         => 2048,
                    'encrypt_name'     => TRUE,
                    'file_ext_tolower' => TRUE,
                );

                $this->upload->initialize($configPhoto);

                if ($this->upload->do_upload('photo')) {
                    $upload_data = $this->upload->data();
                    // $photo_path  = 'uploads/graduates/photos/' . $upload_data['file_name'];
                    $photo_path  = $upload_data['file_name'];
                } else {
                    $data['years'] = $this->Graduation_year_model->get_all();
                    $data['title']       = 'Tambah Kelulusan - Admin';
                    $data['active_menu'] = 'kelulusan';
                    $data['upload_error'] = $this->upload->display_errors();

                    $this->load->view('templates/admin_header', $data);
                    $this->load->view('admin/kelulusan/form', $data);
                    $this->load->view('templates/admin_footer');
                    
                    return;
                }
            }

            // ==== Upload CV (opsional) ====
            $cv_path = null;
            if (!empty($_FILES['cv_file']['name'])) {
                $configCv = array(
                    'upload_path'      => './uploads/graduates/cv/',
                    'allowed_types'    => 'pdf|doc|docx',
                    'max_size'         => 4096,
                    'encrypt_name'     => TRUE,
                    'file_ext_tolower' => TRUE,
                );

                $this->upload->initialize($configCv);

                if ($this->upload->do_upload('cv_file')) {
                    $upload_data = $this->upload->data();
                    // $cv_path     = 'uploads/graduates/cv/' . $upload_data['file_name'];
                    $cv_path     = $upload_data['file_name'];
                } else {
                    $data['years'] = $this->Graduation_year_model->get_all();
                    $data['title']       = 'Tambah Kelulusan - Admin';
                    $data['active_menu'] = 'kelulusan';
                    $data['upload_error'] = $this->upload->display_errors();

                    $this->load->view('templates/admin_header', $data);
                    $this->load->view('admin/kelulusan/form', $data);
                    $this->load->view('templates/admin_footer');
                    
                    return;
                }
            }

            $insert = array(
                'graduation_year' => $this->input->post('graduation_year'),
                'student_name'    => $this->input->post('student_name', TRUE),
                'nisn'            => $this->input->post('nisn', TRUE),
                'photo_path'      => $photo_path,
                'cv_link'         => $cv_path, // path file cv (opsional)
            );

            $this->db->insert('graduates', $insert);
            $this->session->set_flashdata('success', 'Kelulusan berhasil ditambahkan.');
            return redirect('admin/kelulusan');
        }
    }

    $data['years'] = $this->Graduation_year_model->get_all();
    $data['title']       = 'Tambah Kelulusan - Admin';
    $data['active_menu'] = 'kelulusan';

    $this->load->view('templates/admin_header', $data);
    $this->load->view('admin/kelulusan/form', $data);
    $this->load->view('templates/admin_footer');
    
}


    // Edit data
    public function edit($id)
{
    $graduate = $this->Graduates_model->get_by_id($id);
    if (!$graduate) {
        show_404();
    }

    $data['graduate'] = $graduate;
    $data['years'] = $this->Graduation_year_model->get_all();

    if ($this->input->post()) {
        $this->form_validation->set_rules('graduation_year', 'Tahun Kelulusan', 'required|integer');
        $this->form_validation->set_rules('student_name', 'Nama Siswa', 'required');
        $this->form_validation->set_rules('nisn', 'NISN', 'required');

        if ($this->form_validation->run() == TRUE) {

            // LOAD LIBRARY SEKALI SAJA
            $this->load->library('upload');

            $photo_path = $graduate->photo_path;
            $cv_path    = $graduate->cv_link;

            // ==== Upload foto baru (opsional) ====
            if (!empty($_FILES['photo']['name'])) {
                $configPhoto = array(
                    'upload_path'      => './uploads/graduates/photos/',
                    'allowed_types'    => 'jpg|jpeg|png',
                    'max_size'         => 2048,
                    'encrypt_name'     => TRUE,
                    'file_ext_tolower' => TRUE,
                );

                $this->upload->initialize($configPhoto);

                if ($this->upload->do_upload('photo')) {
                    // if ($photo_path && file_exists(FCPATH . $photo_path)) {
                    //     @unlink(FCPATH . $photo_path);
                    // }
                    $old_file = FCPATH . '/uploads/graduates/photos/' . $photo_path;
                        if ($photo_path && file_exists($old_file)) {
                            unlink($old_file);
                    }
                    $upload_data = $this->upload->data();
                    // $photo_path  = 'uploads/graduates/photos/' . $upload_data['file_name'];
                    $photo_path  = $upload_data['file_name'];
                } else {
                    $data['title']       = 'Edit Kelulusan - Admin';
                    $data['active_menu'] = 'kelulusan';
                    $data['upload_error'] = $this->upload->display_errors();

                    $this->load->view('templates/admin_header', $data);
                    $this->load->view('admin/kelulusan/form', $data);
                    $this->load->view('templates/admin_footer');
                    
                    return;
                }
            }

            // ==== Upload CV baru (opsional) ====
            if (!empty($_FILES['cv_file']['name'])) {
                $configCv = array(
                    'upload_path'      => './uploads/graduates/cv/',
                    'allowed_types'    => 'pdf|doc|docx',
                    'max_size'         => 4096,
                    'encrypt_name'     => TRUE,
                    'file_ext_tolower' => TRUE,
                );

                $this->upload->initialize($configCv);

                if ($this->upload->do_upload('cv_file')) {
                    // if ($cv_path && file_exists(FCPATH . $cv_path)) {
                    //     @unlink(FCPATH . $cv_path);
                    // }
                    $old_file = FCPATH . '/uploads/graduates/cv/' . $cv_path;
                        if ($cv_path && file_exists($old_file)) {
                            unlink($old_file);
                    }
                    $upload_data = $this->upload->data();
                    // $cv_path     = 'uploads/graduates/cv/' . $upload_data['file_name'];
                    $cv_path     = $upload_data['file_name'];
                } else {
                    $data['title']       = 'Edit Kelulusan - Admin';
                    $data['active_menu'] = 'kelulusan';
                    $data['upload_error'] = $this->upload->display_errors();

                    $this->load->view('templates/admin_header', $data);
                    $this->load->view('admin/kelulusan/form', $data);
                    $this->load->view('templates/admin_footer');
                    
                    return;
                }
            }

            $update = array(
                'graduation_year' => $this->input->post('graduation_year'),
                'student_name'    => $this->input->post('student_name', TRUE),
                'nisn'            => $this->input->post('nisn', TRUE),
                'photo_path'      => $photo_path,
                'cv_link'         => $cv_path,
            );

            $this->db->where('id', $id)->update('graduates', $update);
            $this->session->set_flashdata('success', 'Kelulusan berhasil diperbarui.');
            return redirect('admin/kelulusan');
        }
    }

    $data['title']       = 'Edit Kelulusan - Admin';
    $data['active_menu'] = 'kelulusan';

    $this->load->view('templates/admin_header', $data);
    $this->load->view('admin/kelulusan/form', $data);
    $this->load->view('templates/admin_footer');

}


    // Hapus data
    public function delete($id)
    {
        $graduate = $this->Graduates_model->get_by_id($id);
        if ($graduate) {
            $file1 = FCPATH . '/uploads/graduates/photos/' . $graduate->photo_path;
            if ($graduate->photo_path && file_exists($file1)) {
                unlink($file1);
            }
            $file2 = FCPATH . '/uploads/graduates/cv/' . $graduate->cv_link;
            if ($graduate->cv_link && file_exists($file2)) {
                unlink($file2);
            }
            // if ($graduate->photo_path && file_exists(FCPATH . $graduate->photo_path)) {
            //     @unlink(FCPATH . $graduate->photo_path);
            // }
            // if ($graduate->cv_link && file_exists(FCPATH . $graduate->cv_link)) {
            //     @unlink(FCPATH . $graduate->cv_link);
            // }
            $this->db->where('id', $id)->delete('graduates');
        }

        $this->session->set_flashdata('success', 'Kelulusan berhasil dihapus.');
        redirect('admin/kelulusan');
    }
}

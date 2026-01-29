<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();

        // NO CACHE untuk semua halaman admin
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');
    }

    // Redirect default ke dashboard
    public function index()
    {
        return $this->dashboard();
    }

    // Halaman login
    public function login()
{
    // Kalau sudah login, langsung ke dashboard
    if ($this->session->userdata('user_id')) {
        return redirect('admin', 'refresh');
    }

    // Jangan cache halaman login
    $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
    $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
    $this->output->set_header('Pragma: no-cache');
    

    if ($this->input->post()) {
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == TRUE) {
            $email    = $this->input->post('email', TRUE);
            $password = $this->input->post('password', TRUE);

            $user = $this->db
                ->where('email', $email)
                ->get('users')
                ->row();

            $isValid = FALSE;

            if ($user) {
                $stored = $user->password;

                // Jika password di DB masih pendek (legacy plain text)
                if (strlen($stored) < 60) {
                    // legacy: bandingkan langsung
                    if ($stored === $password) {
                        $isValid = TRUE;

                        // upgrade ke hash baru
                        $newHash = password_hash($password, PASSWORD_DEFAULT);
                        $this->db->where('id', $user->id)
                                 ->update('users', array('password' => $newHash));
                    }
                } else {
                    // password sudah hash -> pakai password_verify
                    if (password_verify($password, $stored)) {
                        $isValid = TRUE;
                    }
                }
            }

            if ($isValid) {
                // set session
                $this->session->set_userdata(array(
                    'user_id'   => $user->id,
                    'user_name' => $user->name,
                    'user_role' => $user->role,
                    'logged_in' => TRUE
                ));

                return redirect('admin');
            } else {
                $data['error'] = 'Email atau password salah.';
            }
        }
    }

    $this->load->view('admin/login', isset($data) ? $data : NULL);
}


    // Logout
    public function logout()
    {
        $this->session->sess_destroy();
        redirect('admin/login');
    }

    // Dashboard
    public function dashboard()
    {
        // proteksi: harus login
        if (!$this->session->userdata('user_id')) {
            return redirect('admin/login');
        }

        // hitung total data
        $data['total_announcements'] = $this->db->count_all('announcements');
        $data['total_news']          = $this->db->count_all('news');
        $data['total_graduates']     = $this->db->count_all('graduates');
        $data['title']       = 'Dashboard - Admin';
        $data['active_menu'] = 'dashboard';
    
        // $this->load->view('admin/dashboard', $data);
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/dashboard', $data);
        $this->load->view('templates/admin_footer');
    }
}

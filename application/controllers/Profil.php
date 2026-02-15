<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profil extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        // proteksi login
        if (!$this->session->userdata('user_id')) {
            redirect('admin/login');
        }
        $this->load->model('User_model');
        date_default_timezone_set('Asia/Jakarta');
    }

    public function password()
    {
        $data['title'] = 'Ubah Password';
        $data['active_menu'] = 'password';

        // Ambil info terakhir perubahan password (optional)
        $user_id = $this->session->userdata('user_id');
        $user = $this->User_model->get_by_id($user_id);
        $data['last_password_change'] = $user->updated_at ?? null;
        
        $this->load->view('templates/admin_header', $data);
        $this->load->view('admin/password', $data);
        $this->load->view('templates/admin_footer');
    }

    public function password_update()
    {
        $user_id = $this->session->userdata('user_id');

        $password_lama = $this->input->post('password_lama', TRUE);
        $password_baru = $this->input->post('password_baru', TRUE);
        $password_konf = $this->input->post('password_konfirmasi', TRUE);

        if (strlen($password_baru) < 6) {
            $this->session->set_flashdata('error', 'Password baru minimal 6 karakter.');
            return redirect('profil/password');
        }

        if ($password_baru !== $password_konf) {
            $this->session->set_flashdata('error', 'Konfirmasi password baru tidak sama.');
            return redirect('profil/password');
        }

        $user = $this->User_model->get_by_id($user_id);
        if (!$user) {
            $this->session->set_flashdata('error', 'User tidak ditemukan.');
            return redirect('profil/password');
        }

        // cek password lama
        if (!password_verify($password_lama, $user->password)) {
            $this->session->set_flashdata('error', 'Password lama tidak cocok.');
            return redirect('profil/password');
        }

        $hash_baru = password_hash($password_baru, PASSWORD_DEFAULT);
        $this->User_model->update_password($user_id, $hash_baru);

        $this->session->set_flashdata('success', 'Password berhasil diubah.');
        redirect('profil/password');
    }
}

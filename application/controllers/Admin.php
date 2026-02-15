<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->model('User_model');
        date_default_timezone_set('Asia/Jakarta'); // sesuaikan kalau perlu

        // NO CACHE untuk semua halaman admin
        $this->output->set_header('Cache-Control: no-store, no-cache, must-revalidate, max-age=0');
        $this->output->set_header('Cache-Control: post-check=0, pre-check=0', false);
        $this->output->set_header('Pragma: no-cache');
    }

    private function normalize_wa($no_wa)
    {
        $p = preg_replace('/[^0-9]/', '', $no_wa);

        // ubah 08xx -> 628xx
        if (substr($p, 0, 1) === '0') {
            $p = '62' . substr($p, 1);
        }
        return $p;
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
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required');

        if ($this->form_validation->run() == TRUE) {
            $username    = $this->input->post('username', TRUE);
            $password = $this->input->post('password', TRUE);

            $user = $this->db
                ->where('username', $username)
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
                $data['error'] = 'Username atau password salah.';
            }
        }
    }

    $this->load->view('admin/login', isset($data) ? $data : NULL);
}

public function forgot_password()
    {
        $data['title'] = 'Lupa Password';
        
        $this->load->view('templates/auth_header', $data);
        $this->load->view('admin/forgot_password', $data);
        $this->load->view('templates/auth_footer');
    }

public function forgot_password_process()
{
    date_default_timezone_set('Asia/Jakarta');
    $this->load->model('Otp_model');
    $this->load->library('Fonnte_lib');

    $identifier = trim($this->input->post('identifier', TRUE));
    if ($identifier === '') {
        $this->session->set_flashdata('error', 'Silakan isi username atau nomor WhatsApp.');
        return redirect('admin/forgot_password');
    }

    // cari user by username ATAU no_wa
    $user = $this->db->get_where('users', ['username' => $identifier])->row();

    if (!$user) {
        $wa = $this->normalize_wa($identifier);
        $user = $this->db->get_where('users', ['no_wa' => $wa])->row();
    }

    if (!$user) {
        $this->session->set_flashdata('error', 'Akun tidak ditemukan. Cek username atau nomor WhatsApp.');
        return redirect('admin/forgot_password');
    }

    // if ($user->status !== 'aktif') {
    //     $this->session->set_flashdata('error', 'Akun tidak aktif. Hubungi admin.');
    //     return redirect('admin/forgot_password');
    // }

    if (empty($user->no_wa)) {
        $this->session->set_flashdata('error', 'Nomor WA untuk akun ini belum diisi. Silakan hubungi admin.');
        return redirect('admin/forgot_password');
    }

    $no_wa = $this->normalize_wa($user->no_wa);

    // THROTTLE: jika OTP terakhir masih aktif (belum expired), jangan kirim lagi
    $latest = $this->Otp_model->get_latest_active($user->id);
    if ($latest && time() < strtotime($latest->expired_at)) {
        // simpan ke session supaya halaman OTP tidak hilang saat refresh
        $this->session->set_userdata([
            'fp_user_id' => $user->id,
            'fp_username' => $user->username,
            'fp_no_wa' => $no_wa,
            'fp_expired_at' => $latest->expired_at,
        ]);
        $this->session->set_flashdata('success', 'OTP sudah dikirim. Silakan cek WhatsApp Anda.');
        return redirect('admin/forgot_password/otp');
    }

    // generate OTP 6 digit
    $kode_otp = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);

    // OTP berlaku 1 menit
    // $expired  = date('Y-m-d H:i:s', time() + 60);

    // $this->Otp_model->create_otp($user->id, $kode_otp, $expired);

    $result = $this->Otp_model->create_otp($user->id, $kode_otp);

$this->session->set_userdata([
    'fp_expired_at' => $result['expired_at'],
    'fp_resend_at'  => $result['resend_at']
]);

    // Kirim OTP via WhatsApp
    $sent = $this->fonnte_lib->kirim_otp(
        $no_wa, 
        $kode_otp, 
        $user->username
    );

    if (!$sent) {
        $this->session->set_flashdata('error', 'Gagal mengirim OTP. Coba lagi.');
        return redirect('admin/forgot_password');
    }

    // simpan ke session (anti hilang saat refresh)
    $this->session->set_userdata([
        'fp_user_id' => $user->id,
        'fp_username' => $user->username,
        'fp_no_wa' => $no_wa,
        'fp_expired_at' => $result['expired_at'],
    ]);

    $this->session->set_flashdata('success', 'Kode OTP telah dikirim ke WhatsApp Anda.');
    redirect('admin/forgot_password/otp');
}

public function forgot_password_otp()
{
    if (!$this->session->userdata('fp_user_id')) {
        return redirect('admin/forgot_password');
    }

    $data['title'] = 'Verifikasi OTP';
    $data['username'] = $this->session->userdata('fp_username');
    $data['no_wa'] = $this->session->userdata('fp_no_wa');
    $data['expired_at'] = $this->session->userdata('fp_expired_at');

    $this->load->view('templates/auth_header', $data);
    $this->load->view('admin/forgot_password_otp', $data);
    $this->load->view('templates/auth_footer');
}

public function forgot_password_verify()
{
    $this->load->model('Otp_model');

    $user_id = $this->session->userdata('fp_user_id');
    if (!$user_id) return redirect('admin/forgot_password');

    $kode_otp = trim($this->input->post('kode_otp', TRUE));
    if ($kode_otp === '') {
        $this->session->set_flashdata('error', 'Silakan isi OTP.');
        return redirect('admin/forgot_password/otp');
    }

    $otp = $this->Otp_model->get_valid_otp($user_id, $kode_otp);
    if (!$otp) {
        $this->session->set_flashdata('error', 'Kode OTP tidak valid atau sudah kadaluarsa.');
        return redirect('admin/forgot_password/otp');
    }

    // tandai OTP dipakai
    $this->Otp_model->mark_used($otp->id);

    // set flag verified
    $this->session->set_userdata('fp_verified', 1);

    redirect('admin/forgot_password/new_password');
}

public function forgot_password_resend()
{
    $this->load->model('Otp_model');
    $this->load->library('Fonnte_lib');

    $user_id = $this->session->userdata('fp_user_id');
    if (!$user_id) return redirect('admin/forgot_password');

    // cek boleh resend atau belum (1 menit)
    if (!$this->Otp_model->can_resend($user_id)) {
        $this->session->set_flashdata('error', 'Tunggu 1 menit sebelum kirim ulang OTP.');
        return redirect('admin/forgot_password/otp');
    }

    $username = $this->session->userdata('fp_username');
    $no_wa    = $this->session->userdata('fp_no_wa');

    $kode_otp = str_pad((string)random_int(0, 999999), 6, '0', STR_PAD_LEFT);

    // CREATE OTP BARU
    $result = $this->Otp_model->create_otp($user_id, $kode_otp);

    // Kirim OTP via WhatsApp
    $sent = $this->fonnte_lib->kirim_otp(
        $no_wa, 
        $kode_otp, 
        $username
    );
    if (!$sent) {
        $this->session->set_flashdata('error', 'Gagal mengirim OTP. Coba lagi.');
        return redirect('admin/forgot_password/otp');
    }

    // 🔥 INI YANG PENTING (RESET TIMER)
    $this->session->set_userdata([
        'fp_expired_at' => $result['expired_at'],
        'fp_resend_at'  => $result['resend_at']
    ]);

    $this->session->set_flashdata('success', 'OTP baru telah dikirim.');
    redirect('admin/forgot_password/otp');
}


public function forgot_password_new_password()
{
    if (!$this->session->userdata('fp_verified')) {
        return redirect('admin/forgot_password');
    }

    $data['title'] = 'Buat Password Baru';

    $this->load->view('templates/auth_header', $data);
    $this->load->view('admin/new_password', $data);
    $this->load->view('templates/auth_footer');
}

public function forgot_password_new_password_process()
{
    if (!$this->session->userdata('fp_verified')) {
        return redirect('admin/forgot_password');
    }

    $user_id   = $this->session->userdata('fp_user_id');
    $password   = $this->input->post('password_baru', TRUE);
    $konfirmasi = $this->input->post('password_konfirmasi', TRUE);

    if ($password !== $konfirmasi) {
        $this->session->set_flashdata('error', 'Konfirmasi password tidak sama.');
        return redirect('admin/forgot_password/new_password');
    }

    if (strlen($password) < 6) {
        $this->session->set_flashdata('error', 'Password minimal 6 karakter.');
        return redirect('admin/forgot_password/new_password');
    }

    $hash = password_hash($password, PASSWORD_DEFAULT);
    $this->User_model->update_password($user_id, $hash);

    // bersihkan session lupa password
    $this->session->unset_userdata([
        'fp_user_id','fp_username','fp_no_wa','fp_expired_at','fp_verified'
    ]);

    $this->session->set_flashdata('success', 'Password berhasil direset. Silakan login.');
    redirect('admin/login');
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

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fonnte_lib {

    // ganti dengan token Fonnte kamu
    private $token = 'aipuWq4B17osEqg21d1A';

    private $api_url = 'https://api.fonnte.com/send';

    // Nama pengirim (akan muncul di WhatsApp)
    private $sender_name = 'SMA Negeri Contoh';

    public function kirim_otp($no_wa, $kode_otp, $nama_user = 'User')
    {
        // pastikan nomor dalam format internasional tanpa +
        // contoh: 6281234567890
        $target = preg_replace('/[^0-9]/', '', $no_wa);
        
        // Template pesan yang lebih keren
        $message = $this->get_otp_template($kode_otp, $nama_user);

        $data = [
            'target'  => $target,
            'message' => $message,
        ];

        $ch = curl_init();
        curl_setopt_array($ch, [
            CURLOPT_URL            => $this->api_url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($data),
            CURLOPT_HTTPHEADER     => [
                "Authorization: ".$this->token
            ],
        ]);

        $result = curl_exec($ch);
        $err    = curl_error($ch);
        curl_close($ch);

        if ($err) {
            log_message('error', 'Fonnte error: '.$err);
            return false;
        }

        // Decode response untuk logging
        $response = json_decode($result, true);
        if (isset($response['status']) && $response['status'] == 'success') {
            log_message('info', 'OTP berhasil dikirim ke ' . $target);
            return true;
        } else {
            log_message('error', 'Fonnte API error: ' . $result);
            return false;
        }
    }
    
    /**
     * Template OTP yang lebih keren dengan format rapi
     */
    private function get_otp_template($kode_otp, $nama_user = 'User')
    {
        $template = "━━━━━━━━━━━━━━━━━━━━\n";
        $template .= "🔐 *KODE VERIFIKASI OTP*\n";
        $template .= "━━━━━━━━━━━━━━━━━━━━\n\n";
        
        $template .= "Halo *{$nama_user}*,\n\n";
        
        $template .= "Berikut adalah kode OTP Anda untuk mereset password akun admin:\n\n";
        
        // Kotak kode OTP yang mencolok
        $template .= "┌────────┐\n";
        $template .= "│    *{$kode_otp}*   │\n";
        $template .= "└────────┘\n\n";
        
        $template .= "⏰ *Berlaku hingga:* " . date('H:i', strtotime('+5 minutes')) . " WIB\n";
        $template .= "⏳ *Masa berlaku:* 5 menit\n\n";
        
        $template .= "⚠️ *PENTING:*\n";
        $template .= "• Jangan berikan kode ini kepada SIAPAPUN\n";
        $template .= "• Abaikan jika Anda tidak merasa meminta reset password\n\n";
        
        $template .= "━━━━━━━━━━━━━━━━━━━━\n";
        $template .= "🏫 *SMA Negeri Contoh*\n";
        $template .= "📧 info@smacontoh.sch.id\n";
        $template .= "🌐 smacontoh.sch.id\n";
        $template .= "━━━━━━━━━━━━━━━━━━━━\n\n";
        
        $template .= "_Pesan ini dikirim otomatis, mohon tidak membalas._";
        
        return $template;
    }
}

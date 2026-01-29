<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announcement extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Announcement_model');
    }

    // /pengumuman - dengan pagination dan search
    public function index()
{
    // Get search parameters
    $search = $this->input->get('search', TRUE);
    $year = $this->input->get('year', TRUE);
    $page = $this->input->get('page', TRUE) ? (int)$this->input->get('page', TRUE) : 1;
    
    // Pagination configuration
    $per_page = 9;
    $offset = ($page - 1) * $per_page;
    
    // Get total records
    $total_records = $this->Announcement_model->count_all($search, $year);
    $total_pages = ceil($total_records / $per_page);
    
    // Get announcements for current page
    $announcements = $this->Announcement_model->get_paginated($per_page, $offset, $search, $year);
    
    // Generate excerpt untuk setiap pengumuman
    foreach ($announcements as &$announcement) {
        $announcement->excerpt = $this->Announcement_model->generate_excerpt($announcement->body);
        $announcement->is_important = $this->Announcement_model->is_important($announcement);
    }
    
    // Get available years for filter dropdown
    $available_years = $this->Announcement_model->get_available_years();
    
    // Build query string for pagination (kecuali page parameter)
    $query_params = [];
    if (!empty($search)) $query_params['search'] = $search;
    if (!empty($year)) $query_params['year'] = $year;
    
    $base_url = site_url('pengumuman');
    if (!empty($query_params)) {
        $base_url .= '?' . http_build_query($query_params);
    }
    
    // Jika sudah ada query string, tambahkan & sebelum page
    $pagination_base_url = $base_url . (strpos($base_url, '?') !== false ? '&' : '?') . 'page=';
    
    // Prepare data for view
    $data = [
        'announcements' => $announcements,
        'total_announcements' => $total_records,
        'search_query' => $search,
        'year_filter' => $year,
        'available_years' => $available_years,
        'pagination' => [
            'total' => $total_records,
            'per_page' => $per_page,
            'current_page' => $page,
            'total_pages' => $total_pages,
            'base_url' => $pagination_base_url,
            'start' => $offset + 1,
            'end' => min($offset + $per_page, $total_records)
        ]
    ];
    
    // Load views dengan header dan footer
    $this->load->view('templates/front_header', [
        'title' => 'Daftar Pengumuman - SMA Negeri Contoh',
        'meta_description' => 'Daftar lengkap pengumuman resmi dari SMA Negeri Contoh. Informasi terkini untuk siswa, orang tua, dan masyarakat.'
    ]);
    $this->load->view('announcement/index', $data);
    $this->load->view('templates/front_footer');
}

    // /pengumuman/{id} - detail page
    public function detail($id)
    {
        $announcement = $this->Announcement_model->get_by_id($id);
        
        if (!$announcement) {
            show_404();
        }
        
        // Generate excerpt dan cek important status
        $announcement->excerpt = $this->Announcement_model->generate_excerpt($announcement->body);
        $announcement->is_important = $this->Announcement_model->is_important($announcement);
        
        // Get related announcements
        $related_announcements = $this->Announcement_model->get_related($id, 3);
        
        // Generate excerpt untuk related announcements
        foreach ($related_announcements as &$related) {
            $related->excerpt = $this->Announcement_model->generate_excerpt($related->body, 80);
            $related->is_important = $this->Announcement_model->is_important($related);
        }
        
        $data = [
            'announcement' => $announcement,
            'related_announcements' => $related_announcements
        ];
        
        // Prepare meta tags
        $meta_description = $announcement->excerpt;
        
        // Load views dengan header dan footer
        $this->load->view('templates/front_header', [
            'title' => htmlspecialchars($announcement->title) . ' - Pengumuman SMA Negeri Contoh',
            'meta_description' => $meta_description
        ]);
        $this->load->view('announcement/detail', $data);
        $this->load->view('templates/front_footer');
    }

    // /pengumuman/terbaru - untuk mendapatkan pengumuman terbaru (JSON API)
    public function latest_json($limit = 5)
    {
        $announcements = $this->Announcement_model->get_latest($limit);
        
        // Generate excerpt untuk setiap pengumuman
        foreach ($announcements as &$announcement) {
            $announcement->excerpt = $this->Announcement_model->generate_excerpt($announcement->body, 100);
            $announcement->is_important = $this->Announcement_model->is_important($announcement);
            $announcement->formatted_date = date('d M Y', strtotime($announcement->published_at));
        }
        
        header('Content-Type: application/json');
        echo json_encode([
            'success' => true,
            'data' => $announcements,
            'count' => count($announcements)
        ]);
    }

    // /pengumuman/penting - halaman khusus pengumuman penting
    public function important()
    {
        $important_announcements = $this->Announcement_model->get_important();
        
        // Generate excerpt untuk setiap pengumuman
        foreach ($important_announcements as &$announcement) {
            $announcement->excerpt = $this->Announcement_model->generate_excerpt($announcement->body);
        }
        
        $data = [
            'announcements' => $important_announcements,
            'total_announcements' => count($important_announcements)
        ];
        
        $this->load->view('templates/front_header', [
            'title' => 'Pengumuman Penting - SMA Negeri Contoh',
            'meta_description' => 'Kumpulan pengumuman penting dari SMA Negeri Contoh'
        ]);
        $this->load->view('announcement/important', $data);
        $this->load->view('templates/front_footer');
    }
}
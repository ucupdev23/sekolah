<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kelulusan extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('Graduates_model');
        $this->load->model('Graduation_year_model');
    }

    // /kelulusan - dengan pagination dan design card
    public function index()
    {
        // Get filter parameters
        $keyword = $this->input->get('q', TRUE);
        $year = $this->input->get('year', TRUE);
        $page = $this->input->get('halaman', TRUE) ? (int)$this->input->get('halaman', TRUE) : 1;
        
        // Pagination configuration - 12 cards per page (3x4 grid)
        $per_page = 12;
        $offset = ($page - 1) * $per_page;
        
        // Get total records
        $total_records = $this->Graduates_model->count_all_search($keyword, $year);
        $total_pages = ceil($total_records / $per_page);
        
        // Get graduates for current page
        $graduates = $this->Graduates_model->get_search_paginated($keyword, $year, $per_page, $offset);
        
        // Get years for filter dropdown
        $years_data = $this->Graduation_year_model->get_all();
        $years = [];
        foreach ($years_data as $y) {
            $years[] = $y->year;
        }
        
        // Get distinct years for filter
        $distinct_years = $this->Graduates_model->get_distinct_years();
        
        // Build query string for pagination
        $query_params = [];
        if (!empty($keyword)) $query_params['q'] = $keyword;
        if (!empty($year)) $query_params['year'] = $year;
        
        $base_url = site_url('kelulusan');
        if (!empty($query_params)) {
            $base_url .= '?' . http_build_query($query_params);
        }
        
        $pagination_base_url = $base_url . (strpos($base_url, '?') !== false ? '&' : '?') . 'halaman=';
        
        // Prepare data for view
        $data = [
            'graduates' => $graduates,
            'keyword' => $keyword,
            'selected_year' => $year,
            'years' => $years,
            'distinct_years' => $distinct_years,
            'total_graduates' => $total_records,
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
        
        // Load views with header and footer
        $this->load->view('templates/front_header', [
            'title' => 'Data Kelulusan Siswa - SMA Negeri Contoh',
            'meta_description' => 'Cari data kelulusan siswa berdasarkan nama, NISN, atau tahun kelulusan. Akses CV dan informasi alumni.'
        ]);
        $this->load->view('kelulusan/index', $data);
        $this->load->view('templates/front_footer');
    }

    // Get statistics for dashboard
    private function get_statistics() {
        $stats = [
            'total_alumni' => $this->Graduates_model->count_all([]),
            'total_years' => count($this->Graduates_model->get_distinct_years()),
            'latest_year' => $this->get_latest_year(),
            'this_year_count' => $this->Graduates_model->count_all(['graduation_year' => date('Y')])
        ];
        
        return $stats;
    }
    
    private function get_latest_year() {
        $years = $this->Graduation_year_model->get_all();
        if (!empty($years)) {
            return $years[0]->year;
        }
        return date('Y');
    }
}
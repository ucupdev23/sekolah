<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->model('News_model');
        $this->load->model('Category_model');
    }

    // /berita (dengan pagination, search, dan filter kategori)
    public function index()
    {
        // Get filter parameters
        $search = $this->input->get('search', TRUE);
        $category_slug = $this->input->get('kategori', TRUE);
        $year = $this->input->get('tahun', TRUE);
        $page = $this->input->get('halaman', TRUE) ? (int)$this->input->get('halaman', TRUE) : 1;
        
        // Pagination configuration
        $per_page = 9;
        $offset = ($page - 1) * $per_page;
        
        // Get category_id if category_slug is provided
        $category_id = null;
        if ($category_slug) {
            $category = $this->Category_model->get_by_slug($category_slug);
            if ($category) {
                $category_id = $category->id;
            }
        }
        
        // Get total records
        $total_records = $this->News_model->count_all_search($search, $category_id);
        $total_pages = ceil($total_records / $per_page);
        
        // Get news for current page
        $news_list = $this->News_model->get_search_paginated($search, $category_id, $per_page, $offset);
        
        // Generate excerpt for each news
        foreach ($news_list as &$news) {
            $news->excerpt = $this->generate_excerpt($news->content);
        }
        
        // Get all categories for filter
        $categories = $this->Category_model->get_all();
        
        // Get available years for filter dropdown
        $available_years = $this->get_available_years();
        
        // Build query string for pagination
        $query_params = [];
        if (!empty($search)) $query_params['search'] = $search;
        if (!empty($category_slug)) $query_params['kategori'] = $category_slug;
        if (!empty($year)) $query_params['tahun'] = $year;
        
        $base_url = site_url('berita');
        if (!empty($query_params)) {
            $base_url .= '?' . http_build_query($query_params);
        }
        
        $pagination_base_url = $base_url . (strpos($base_url, '?') !== false ? '&' : '?') . 'halaman=';
        
        // Prepare data for view
        $data = [
            'news_list' => $news_list,
            'categories' => $categories,
            'selected_category' => $category_slug,
            'total_news' => $total_records,
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
        
        // Load views with header and footer
        $this->load->view('templates/front_header', [
            'title' => 'Berita Sekolah - SMA Negeri Contoh',
            'meta_description' => 'Informasi kegiatan, prestasi, dan berita terbaru dari SMA Negeri Contoh'
        ]);
        $this->load->view('news/index', $data);
        $this->load->view('templates/front_footer');
    }

    // /berita/detail/{slug}
    public function detail($slug)
    {
        $news = $this->News_model->get_by_slug($slug);
        if (!$news) {
            show_404();
        }
        
        // Generate excerpt
        $news->excerpt = $this->generate_excerpt($news->content);
        
        // Get related news (same category)
        $related_news = $this->get_related_news($news->id, $news->category_id);
        
        // Get recent news for sidebar
        $recent_news = $this->News_model->get_latest(5);
        foreach ($recent_news as &$item) {
            $item->excerpt = $this->generate_excerpt($item->content, 80);
        }

         // ✅ TAMBAHAN WAJIB
        $categories = $this->Category_model->get_dol();
        $total_news = $this->db->count_all('news');

        $data = [
            'news' => $news,
            'related_news' => $related_news,
            'recent_news' => $recent_news,
            'categories' => $categories,   // ✅ FIX
            'total_news' => $total_news    // ✅ FIX
        ];
        
        // Load views with header and footer
        $this->load->view('templates/front_header', [
            'title' => htmlspecialchars($news->title) . ' - Berita SMA Negeri Contoh',
            'meta_description' => $news->excerpt
        ]);
        $this->load->view('news/detail', $data);
        $this->load->view('templates/front_footer');
    }

    // Helper function to generate excerpt
    private function generate_excerpt($content, $length = 160)
    {
        $clean_content = strip_tags($content);
        if (strlen($clean_content) <= $length) {
            return $clean_content;
        }
        
        $excerpt = substr($clean_content, 0, $length);
        $last_space = strrpos($excerpt, ' ');
        
        if ($last_space !== false) {
            $excerpt = substr($excerpt, 0, $last_space);
        }
        
        return $excerpt . '...';
    }

    // Helper function to get related news
    private function get_related_news($current_id, $category_id, $limit = 3)
    {
        $this->db->select('news.*, categories.name as category_name, categories.slug as category_slug')
                 ->from('news')
                 ->join('categories', 'categories.id = news.category_id', 'left')
                 ->where('news.id !=', $current_id);
        
        if ($category_id) {
            $this->db->where('news.category_id', $category_id);
        }
        
        return $this->db->order_by('news.published_at', 'DESC')
                        ->limit($limit)
                        ->get()
                        ->result();
    }

    // Helper function to get available years from news
    private function get_available_years()
    {
        $result = $this->db->select('YEAR(published_at) as year')
                          ->distinct()
                          ->order_by('year', 'DESC')
                          ->get('news')
                          ->result_array();
        
        $years = [];
        foreach ($result as $row) {
            if (!empty($row['year'])) {
                $years[] = $row['year'];
            }
        }
        return $years;
    }
}
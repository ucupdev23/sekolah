<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Announcement_model extends CI_Model {

    protected $table = 'announcements';

    // Get latest for homepage (3 terbaru)
    public function get_latest($limit = 3)
    {
        return $this->db
            ->order_by('published_at', 'DESC')
            ->limit($limit)
            ->get($this->table)
            ->result();
    }

    // Get all announcements
    public function get_all()
    {
        return $this->db
            ->order_by('published_at', 'DESC')
            ->get($this->table)
            ->result();
    }

    public function get_by_id($id)
    {
        return $this->db
            ->where('id', $id)
            ->get($this->table)
            ->row();
    }

    // Count all announcements with optional search
    public function count_all($search = '', $year = '') {
        $this->db->from($this->table);
        
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('title', $search);
            $this->db->or_like('body', $search);
            $this->db->group_end();
        }
        
        if (!empty($year)) {
            $this->db->like('published_at', $year, 'after'); // Mencari tahun di tanggal
        }
        
        return $this->db->count_all_results();
    }

    public function count_all_search($search) {
        $this->db->from($this->table);
        $this->db->group_start();
        $this->db->like('title', $search);
        $this->db->or_like('body', $search);
        $this->db->group_end();
        return $this->db->count_all_results();
    }

     public function get_all_paginated($limit = 10, $offset = 0) {
        return $this->db->order_by('published_at', 'DESC')
                        ->limit($limit, $offset)
                        ->get($this->table)
                        ->result();
    }

    public function get_search_paginated($search, $limit = 10, $offset = 0) {
        $this->db->from($this->table);
        $this->db->group_start();
        $this->db->like('title', $search);
        $this->db->or_like('body', $search);
        $this->db->group_end();
        return $this->db->order_by('published_at', 'DESC')
                        ->limit($limit, $offset)
                        ->get()
                        ->result();
    }

    // Get paginated announcements with search and year filter
    public function get_paginated($limit = 9, $offset = 0, $search = '', $year = '') {
        if (!empty($search)) {
            $this->db->group_start();
            $this->db->like('title', $search);
            $this->db->or_like('body', $search);
            $this->db->group_end();
        }
        
        if (!empty($year)) {
            $this->db->like('published_at', $year, 'after'); // Contoh: '2024%'
        }
        
        return $this->db->order_by('published_at', 'DESC')
                        ->limit($limit, $offset)
                        ->get($this->table)
                        ->result();
    }

    // Get related announcements (ambil 3 terbaru selain yang sedang dilihat)
    public function get_related($current_id, $limit = 3) {
        return $this->db
            ->where('id !=', $current_id)
            ->order_by('published_at', 'DESC')
            ->limit($limit)
            ->get($this->table)
            ->result();
    }

    // Get years that have announcements (untuk filter dropdown)
    public function get_available_years() {
        $result = $this->db->select('YEAR(published_at) as year')
                        ->distinct()
                        ->order_by('year', 'DESC')
                        ->get($this->table)
                        ->result_array();
        
        $years = [];
        foreach ($result as $row) {
            if (!empty($row['year'])) {
                $years[] = $row['year'];
            }
        }
        return $years;
    }

    // Get important announcements (kita asumsikan berdasarkan judul yang mengandung kata penting)
    public function get_important($limit = 5) {
        return $this->db
            ->group_start()
            ->like('title', 'penting', 'both')
            ->or_like('title', 'important', 'both')
            ->or_like('body', 'penting', 'both')
            ->or_like('body', 'important', 'both')
            ->group_end()
            ->order_by('published_at', 'DESC')
            ->limit($limit)
            ->get($this->table)
            ->result();
    }

    // Check if announcement is important (berdasarkan keyword dalam judul/isi)
    public function is_important($announcement) {
        $keywords = ['penting', 'important', 'urgent', 'segera', 'darurat'];
        $content = strtolower($announcement->title . ' ' . $announcement->body);
        
        foreach ($keywords as $keyword) {
            if (strpos($content, $keyword) !== false) {
                return true;
            }
        }
        return false;
    }

    // Generate excerpt from body
    public function generate_excerpt($body, $length = 160) {
        $clean_body = strip_tags($body);
        if (strlen($clean_body) <= $length) {
            return $clean_body;
        }
        
        $excerpt = substr($clean_body, 0, $length);
        $last_space = strrpos($excerpt, ' ');
        
        if ($last_space !== false) {
            $excerpt = substr($excerpt, 0, $last_space);
        }
        
        return $excerpt . '...';
    }

    // Untuk statistik (opsional)
    public function get_stats() {
        return [
            'total' => $this->count_all(),
            'this_year' => $this->count_all('', date('Y')),
            'this_month' => $this->count_all('', date('Y-m')),
            'today' => $this->count_all('', date('Y-m-d'))
        ];
    }
}
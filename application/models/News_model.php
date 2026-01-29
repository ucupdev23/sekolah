<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class News_model extends CI_Model {

    protected $table = 'news';

    // 3 terbaru untuk landing page
    public function get_latest($limit = 3)
    {
        return $this->db
            ->order_by('published_at', 'DESC')
            ->limit($limit)
            ->get($this->table)
            ->result();
    }

    // List berita untuk frontend (bisa filter kategori)
    public function get_all($category_slug = null)
    {
        $this->db->select('news.*, categories.name as category_name, categories.slug as category_slug');
        $this->db->from('news');
        $this->db->join('categories', 'categories.id = news.category_id', 'left');
        if ($category_slug) {
            $this->db->where('categories.slug', $category_slug);
        }
        $this->db->order_by('news.published_at', 'DESC');

        return $this->db->get()->result();
    }

    // Detail berita by slug (frontend)
    public function get_by_slug($slug)
    {
        return $this->db
            ->select('news.*, categories.name as category_name, categories.slug as category_slug')
            ->from('news')
            ->join('categories', 'categories.id = news.category_id', 'left')
            ->where('news.slug', $slug)
            ->get()
            ->row();
    }

    // Admin: list semua berita (tanpa filter kategori)
    public function get_all_admin()
    {
        return $this->get_all(null);
    }

    // Admin: ambil by id
    public function get_by_id($id)
    {
        return $this->db
            ->select('news.*, categories.name as category_name, categories.slug as category_slug')
            ->from('news')
            ->join('categories', 'categories.id = news.category_id', 'left')
            ->where('news.id', $id)
            ->get()
            ->row();
    }

    // Pagination methods - BARU
    public function count_all($where = []) {
        $this->db->from($this->table);
        
        if (!empty($where)) {
            if (isset($where['title LIKE']) && isset($where['content LIKE'])) {
                $this->db->group_start();
                $this->db->like('news.title', $where['title LIKE'], 'both');
                $this->db->or_like('news.content', $where['content LIKE'], 'both');
                $this->db->group_end();
            }
            if (isset($where['category_id'])) {
                $this->db->where('news.category_id', $where['category_id']);
            }
        }
        
        return $this->db->count_all_results();
    }

    public function get_all_paginated($where = [], $limit = 10, $offset = 0) {
        $this->db->select('news.*, categories.name as category_name, categories.slug as category_slug');
        $this->db->from($this->table);
        $this->db->join('categories', 'categories.id = news.category_id', 'left');
        
        if (!empty($where)) {
            if (isset($where['title LIKE']) && isset($where['content LIKE'])) {
                $this->db->group_start();
                $this->db->like('news.title', str_replace('%', '', $where['title LIKE']), 'both');
                $this->db->or_like('news.content', str_replace('%', '', $where['content LIKE']), 'both');
                $this->db->group_end();
            }
            if (isset($where['category_id'])) {
                $this->db->where('news.category_id', $where['category_id']);
            }
        }
        
        return $this->db->order_by('news.published_at', 'DESC')
                        ->limit($limit, $offset)
                        ->get()
                        ->result();
    }

    // Search with category filter - BARU
    public function get_search_paginated($search, $category_id = null, $limit = 10, $offset = 0) {
        $this->db->select('news.*, categories.name as category_name, categories.slug as category_slug');
        $this->db->from($this->table);
        $this->db->join('categories', 'categories.id = news.category_id', 'left');
        
        if ($search) {
            $this->db->group_start();
            $this->db->like('news.title', $search);
            $this->db->or_like('news.content', $search);
            $this->db->group_end();
        }
        
        if ($category_id) {
            $this->db->where('news.category_id', $category_id);
        }
        
        return $this->db->order_by('news.published_at', 'DESC')
                        ->limit($limit, $offset)
                        ->get()
                        ->result();
    }

    public function count_all_search($search, $category_id = null) {
        $this->db->from($this->table);
        $this->db->join('categories', 'categories.id = news.category_id', 'left');
        
        if ($search) {
            $this->db->group_start();
            $this->db->like('news.title', $search);
            $this->db->or_like('news.content', $search);
            $this->db->group_end();
        }
        
        if ($category_id) {
            $this->db->where('news.category_id', $category_id);
        }
        
        return $this->db->count_all_results();
    }
}

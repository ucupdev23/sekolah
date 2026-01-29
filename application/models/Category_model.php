<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Category_model extends CI_Model {

    protected $table = 'categories';

    public function get_all()
    {
        return $this->db
            ->order_by('name', 'ASC')
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

    public function get_by_slug($slug)
    {
        return $this->db
            ->where('slug', $slug)
            ->get($this->table)
            ->row();
    }

    private function make_slug_unique($slug, $exclude_id = null)
    {
        $base = $slug;
        $i = 1;

        while (true) {
            $this->db->where('slug', $slug);
            if ($exclude_id) {
                $this->db->where('id !=', $exclude_id);
            }
            $exists = $this->db->get($this->table)->row();
            if (!$exists) break;

            $slug = $base . '-' . $i;
            $i++;
        }

        return $slug;
    }

    public function create($name)
    {
        $this->load->helper('url');
        $slug = url_title($name, '-', TRUE);
        $slug = $this->make_slug_unique($slug);

        $data = array(
            'name'       => $name,
            'slug'       => $slug,
        );

        $this->db->insert($this->table, $data);
        return $this->db->insert_id();
    }

    public function update($id, $name)
    {
        date_default_timezone_set('Asia/Jakarta');
        $this->load->helper('url');
        $slug = url_title($name, '-', TRUE);
        $slug = $this->make_slug_unique($slug, $id);

        $data = array(
            'name'       => $name,
            'slug'       => $slug,
            'updated_at' => date('Y-m-d H:i:s'),
        );

        $this->db->where('id', $id)->update($this->table, $data);
        return $this->db->affected_rows();
    }

    // PAGINATION METHODS - BARU
    public function count_all($where = []) {
        $this->db->from($this->table);
        
        if (!empty($where)) {
            if (isset($where['name LIKE'])) {
                $this->db->like('name', $where['name LIKE'], 'both');
            }
        }
        
        return $this->db->count_all_results();
    }

    public function get_all_paginated($where = [], $limit = 10, $offset = 0) {
        if (!empty($where)) {
            if (isset($where['name LIKE'])) {
                $this->db->like('name', str_replace('%', '', $where['name LIKE']), 'both');
            }
        }
        
        return $this->db->order_by('name', 'ASC')
                        ->limit($limit, $offset)
                        ->get($this->table)
                        ->result();
    }

    public function get_search_paginated($search, $limit = 10, $offset = 0) {
        $this->db->from($this->table);
        
        if ($search) {
            $this->db->like('name', $search);
        }
        
        return $this->db->order_by('name', 'ASC')
                        ->limit($limit, $offset)
                        ->get()
                        ->result();
    }

    public function count_all_search($search) {
        $this->db->from($this->table);
        
        if ($search) {
            $this->db->like('name', $search);
        }
        
        return $this->db->count_all_results();
    }

    // Count news in category
    public function count_news_in_category($category_id) {
        return $this->db->where('category_id', $category_id)
                        ->from('news')
                        ->count_all_results();
    }

    public function get_dol()
{
    return $this->db
        ->select('
            categories.id,
            categories.name,
            categories.slug,
            COUNT(news.id) as count
        ')
        ->from('categories')
        ->join('news', 'news.category_id = categories.id', 'left')
        ->group_by('categories.id')
        ->order_by('categories.name', 'ASC')
        ->get()
        ->result();
}

}
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Graduation_year_model extends CI_Model {

    protected $table = 'graduation_years';

    public function get_all()
    {
        return $this->db
            ->order_by('year', 'DESC')
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

    public function exists_year($year)
    {
        return $this->db
            ->where('year', $year)
            ->count_all_results($this->table) > 0;
    }

    // PAGINATION METHODS - BARU
    public function count_all($where = []) {
        $this->db->from($this->table);
        
        if (!empty($where)) {
            if (isset($where['year LIKE'])) {
                $this->db->like('year', $where['year LIKE'], 'both');
            }
        }
        
        return $this->db->count_all_results();
    }

    public function get_all_paginated($where = [], $limit = 10, $offset = 0) {
        if (!empty($where)) {
            if (isset($where['year LIKE'])) {
                $this->db->like('year', str_replace('%', '', $where['year LIKE']), 'both');
            }
        }
        
        return $this->db->order_by('year', 'DESC')
                        ->limit($limit, $offset)
                        ->get($this->table)
                        ->result();
    }

    public function get_search_paginated($search, $limit = 10, $offset = 0) {
        $this->db->from($this->table);
        
        if ($search) {
            $this->db->like('year', $search);
        }
        
        return $this->db->order_by('year', 'DESC')
                        ->limit($limit, $offset)
                        ->get()
                        ->result();
    }

    public function count_all_search($search) {
        $this->db->from($this->table);
        
        if ($search) {
            $this->db->like('year', $search);
        }
        
        return $this->db->count_all_results();
    }

    // Count graduates in year
    public function count_graduates_in_year($year) {
        return $this->db->where('graduation_year', $year)
                        ->from('graduates')
                        ->count_all_results();
    }

    // Get years with graduate counts
    public function get_years_with_counts() {
        $years = $this->get_all();
        $result = [];
        
        foreach ($years as $year) {
            $count = $this->count_graduates_in_year($year->year);
            $year->graduate_count = $count;
            $result[] = $year;
        }
        
        return $result;
    }
}
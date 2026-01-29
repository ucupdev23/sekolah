<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Graduates_model extends CI_Model {

    protected $table = 'graduates';

    // FRONTEND: ambil dengan filter
    public function get_filtered($keyword = null, $year = null)
    {
        if ($keyword) {
            $this->db->group_start();
            $this->db->like('student_name', $keyword);
            $this->db->or_like('nisn', $keyword);
            $this->db->group_end();
        }

        if ($year) {
            $this->db->where('graduation_year', $year);
        }

        $this->db->order_by('graduation_year', 'DESC');
        $this->db->order_by('student_name', 'ASC');

        return $this->db->get($this->table)->result();
    }

    // FRONTEND: daftar tahun unik
    public function get_years()
    {
        $this->db->select('DISTINCT(graduation_year) as year', false);
        $this->db->from($this->table);
        $this->db->order_by('graduation_year', 'DESC');
        $query = $this->db->get();

        $years = array();
        foreach ($query->result() as $row) {
            $years[] = $row->year;
        }
        return $years;
    }

    // ADMIN: list semua data
    public function get_all_admin()
    {
        return $this->db
            ->order_by('graduation_year', 'DESC')
            ->order_by('student_name', 'ASC')
            ->get($this->table)
            ->result();
    }

    // ADMIN: ambil satu by id
    public function get_by_id($id)
    {
        return $this->db
            ->where('id', $id)
            ->get($this->table)
            ->row();
    }

    // PAGINATION METHODS - BARU
    public function count_all($where = []) {
        $this->db->from($this->table);
        
        if (!empty($where)) {
            if (isset($where['student_name LIKE']) && isset($where['nisn LIKE'])) {
                $this->db->group_start();
                $this->db->like('student_name', $where['student_name LIKE'], 'both');
                $this->db->or_like('nisn', $where['nisn LIKE'], 'both');
                $this->db->group_end();
            }
            if (isset($where['graduation_year'])) {
                $this->db->where('graduation_year', $where['graduation_year']);
            }
        }
        
        return $this->db->count_all_results();
    }

    public function get_all_paginated($where = [], $limit = 10, $offset = 0) {
        if (!empty($where)) {
            if (isset($where['student_name LIKE']) && isset($where['nisn LIKE'])) {
                $this->db->group_start();
                $this->db->like('student_name', str_replace('%', '', $where['student_name LIKE']), 'both');
                $this->db->or_like('nisn', str_replace('%', '', $where['nisn LIKE']), 'both');
                $this->db->group_end();
            }
            if (isset($where['graduation_year'])) {
                $this->db->where('graduation_year', $where['graduation_year']);
            }
        }
        
        return $this->db->order_by('graduation_year', 'DESC')
                        ->order_by('student_name', 'ASC')
                        ->limit($limit, $offset)
                        ->get($this->table)
                        ->result();
    }

    // Search with year filter - BARU
    public function get_search_paginated($search, $year = null, $limit = 10, $offset = 0) {
        $this->db->from($this->table);
        
        if ($search) {
            $this->db->group_start();
            $this->db->like('student_name', $search);
            $this->db->or_like('nisn', $search);
            $this->db->group_end();
        }
        
        if ($year) {
            $this->db->where('graduation_year', $year);
        }
        
        return $this->db->order_by('graduation_year', 'DESC')
                        ->order_by('student_name', 'ASC')
                        ->limit($limit, $offset)
                        ->get()
                        ->result();
    }

    public function count_all_search($search, $year = null) {
        $this->db->from($this->table);
        
        if ($search) {
            $this->db->group_start();
            $this->db->like('student_name', $search);
            $this->db->or_like('nisn', $search);
            $this->db->group_end();
        }
        
        if ($year) {
            $this->db->where('graduation_year', $year);
        }
        
        return $this->db->count_all_results();
    }

    // Get distinct years for filter - BARU
    public function get_distinct_years() {
        $this->db->select('DISTINCT(graduation_year) as year');
        $this->db->from($this->table);
        $this->db->order_by('graduation_year', 'DESC');
        return $this->db->get()->result();
    }
}

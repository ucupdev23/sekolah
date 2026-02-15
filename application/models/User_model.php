<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User_model extends CI_Model {

    protected $table = 'users';

    public function get_all()
    {
        return $this->db
            ->order_by('role', 'ASC')
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

    public function get_by_username($username)
    {
        return $this->db
            ->where('username', $username)
            ->get($this->table)
            ->row();
    }

    // PAGINATION METHODS
    public function count_all($where = []) {
        $this->db->from($this->table);
        
        if (!empty($where)) {
            if (isset($where['search'])) {
                $search = $where['search'];
                $this->db->group_start();
                $this->db->like('name', $search);
                $this->db->or_like('username', $search);
                $this->db->or_like('role', $search);
                $this->db->group_end();
            }
        }
        
        return $this->db->count_all_results();
    }

    public function get_all_paginated($where = [], $limit = 10, $offset = 0) {
        if (!empty($where)) {
            if (isset($where['search'])) {
                $search = $where['search'];
                $this->db->group_start();
                $this->db->like('name', $search);
                $this->db->or_like('username', $search);
                $this->db->or_like('role', $search);
                $this->db->group_end();
            }
        }
        
        return $this->db->order_by('role', 'ASC')
                        ->order_by('name', 'ASC')
                        ->limit($limit, $offset)
                        ->get($this->table)
                        ->result();
    }

    public function count_by_role($role) {
        return $this->db->where('role', $role)
                        ->from($this->table)
                        ->count_all_results();
    }

    public function find_by_username($username)
    {
        return $this->db->where('username', $username)->get($this->table)->row();
    }

    public function find_by_no_wa($no_wa)
    {
        return $this->db->where('no_wa', $no_wa)->get($this->table)->row();
    }

    public function find_by_identifier($identifier)
    {
        // coba username dulu
        $u = $this->find_by_username($identifier);
        if ($u) return $u;

        // kalau tidak ketemu, coba no_wa
        return $this->find_by_no_wa($identifier);
    }

    public function update_password($user_id, $hash)
    {
        $this->db->where('id', $user_id)->update($this->table, [
            'password' => $hash,
            'updated_at' => date('Y-m-d H:i:s')
        ]);
        return $this->db->affected_rows() > 0;
    }
}
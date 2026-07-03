<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model {

    public function __construct()
    {
        parent::__construct();
    }

    public function login($post)
    {
        $sql = "SELECT * FROM users WHERE user_id = ? AND user_pw = ? LIMIT 1";
        $query = $this->db->query($sql, [
            $post['id'],
            $post['pw']
        ]);
        if ($query->num_rows() === 1) {
            return $query->row_array();   // 로그인 성공
        }

        return false;   
    }
}
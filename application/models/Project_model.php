<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Project_model extends CI_Model
{
    protected $CI;

    public function __construct()
    {
        parent::__construct();
        $this->CI = &get_instance();
    }

    // 프로젝트 목록 전체 가져오기
    public function get_all_projects()
    {
        // $query = $this->db->get('projects'); // 'SELECT * FROM projects'와 동일
        $sql = 'select * from projects'; // 쿼리 작성용
        $query = $this->db->query($sql);
        // $this->CI->logd($query->result_array());
        return $query->result_array();
    }
}

<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Contact_model extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 특정 카테고리의 데이터를 조회하는 함수
     * @param string $category
     * @return array
     */
    public function get_data_by_category($category)
    {
        $this->db->where('category', $category);
        $this->db->order_by('display_order', 'ASC');
        $query = $this->db->get('profile_info');

        return $query->result_array();
    }
}

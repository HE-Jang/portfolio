<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Profile_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function get_profile_data($category)
    {
        $this->db->where('category', $category);
        $this->db->order_by('display_order', 'ASC');
        return $this->db->get('profile_info')->result_array();
    }
}

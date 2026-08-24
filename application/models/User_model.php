<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class User_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    // 실제 데이터 가져오기
    public function get_users($limit, $start, $search, $order_col, $order_dir)
    {
        $this->db->from('users');
        $this->_apply_search($search);

        // gender 컬럼 정렬 시 특별한 처리
        // log_message('debug', print_r('$order_col', true));
        if ($order_col == 'gender') {
            // 이제 gender는 정수 1, 2이므로, 
            // CASE 문 없이 바로 gender 컬럼으로 정렬하면 1(남) -> 2(여) 순서가 됩니다.
            $this->db->order_by('gender', $order_dir);
        } else {
            $this->db->order_by($order_col, $order_dir);
        }

        $this->db->limit($limit, $start);
        $return = $this->db->get()->result_array();
        return $return;
    }
    // 전체 데이터 개수 (페이징 총 개수 계산용)
    public function get_total_count($search = null)
    {
        return $this->db->count_all('users');
    }

    // 검색어가 있을 때 검색 조건 적용
    private function _apply_search($search = '')
    {
        if (!empty($search)) {
            // 검색어 안전하게 처리
            $escaped_search = $this->db->escape_like_str($search);

            // 1. 성별 검색을 위한 매핑 (사용자가 '남'/'여'로 검색할 것을 대비)
            $gender_search = "";
            if ($search == '남') {
                $gender_search = " OR gender = 1";
            } elseif ($search == '여') {
                $gender_search = " OR gender = 2";
            }

            // 2. 쿼리 구성: (이름 LIKE... OR 이메일 LIKE... OR 성별 = ...)
            // 성별은 숫자가 정확히 일치해야 하므로 LIKE 대신 = 을 사용합니다.
            $this->db->where("(user_name LIKE '%" . $escaped_search . "%' 
                           OR email LIKE '%" . $escaped_search . "%' 
                           $gender_search)");
        }
    }

    public function get_filtered_count($search)
    {
        $this->db->from('users');
        $this->_apply_search($search);
        return $this->db->count_all_results();
    }

    // 특정 유저 단건 조회
    public function get_user_by_id($id)
    {
        return $this->db->get_where('users', array('id' => $id))->row_array();
    }

    // 유저 등록 쿼리
    public function insert_user($data)
    {
        return $this->db->insert('users', $data);
    }

    // 유저 수정 쿼리
    public function update_user($id, $data)
    {
        $this->db->where('user_id', $id);
        return $this->db->update('users', $data);
    }

    // 유저 삭제 쿼리
    public function delete_user($id)
    {
        $this->db->where('id', $id);
        return $this->db->delete('users');
    }
}

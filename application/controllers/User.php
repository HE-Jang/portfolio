<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @property CI_Loader $load
 * @property CI_Session $session
 * @property user_model $user_model
 */

class User extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // 모델 로드
        $this->load->model('user_model');
    }

    public function index()
    {
        $this->load->view('user');
    }
    // 유저 데이터 가져오기
    // Ajax 요청 처리 함수
    public function get_data()
    {
        error_reporting(0);
        header('Content-Type: application/json');
        // 1. 기본 파라미터
        $draw = $this->input->post('draw');
        $start = $this->input->post('start');
        $length = $this->input->post('length');

        // 2. 검색 및 정렬 파라미터 추가
        $search = $this->input->post('search')['value']; // 검색어
        $order_col_idx = $this->input->post('order')[0]['column']; // 정렬할 컬럼 인덱스
        $order_dir = $this->input->post('order')[0]['dir']; // asc 또는 desc

        // 컬럼 인덱스를 실제 DB 필드명으로 매핑
        $columns = ['user_name', 'email', 'gender', 'created_at'];
        $order_col = $columns[$order_col_idx];

        // 모델로 데이터 가져오기
        $data = $this->user_model->get_users($length, $start, $search, $order_col, $order_dir);
        $total = $this->user_model->get_total_count($search); // 검색어 적용된 총 카운트
        $filtered = $this->user_model->get_filtered_count($search); // 검색 적용된 카운트

        $return = array(
            "draw" => intval($draw),
            "recordsTotal" => intval($total),
            "recordsFiltered" => intval($filtered), // 이 값이 검색어에 따라 변해야 함
            "data" => $data
        );

        echo json_encode($return);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
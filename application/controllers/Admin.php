<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @property CI_Loader $load
 * @property CI_Session $session
 * @property user_model $user_model
 */

class Admin extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // 로그인이 안 되어 있거나, 관리자 권한이 아니라면 메인으로 튕겨냄
        if (!$this->session->userdata('user_id') || $this->session->userdata('role') !== 'admin') {
            redirect('main'); // 또는 로그인 페이지
        }
        // 모델 로드
        $this->load->model('user_model');
    }

    public function index()
    {
        $this->load->view('admin');
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
    // 단건 조회 (수정 모달을 띄울 때 기존 데이터 채우기용)
    public function get_user_one()
    {
        error_reporting(0);
        header('Content-Type: application/json');

        $id = $this->input->post('id');
        $user = $this->user_model->get_user_by_id($id);

        echo json_encode($user);
    }

    // 유저 등록 (Insert)
    public function insert_user()
    {
        error_reporting(0);
        header('Content-Type: application/json');

        $password = $this->input->post('user_pw'); // 괄호 수정 완료

        $data = array(
            'user_id'   => $this->input->post('user_id'),
            'user_name' => $this->input->post('user_name'),
            'email'     => $this->input->post('email'),
            'gender'    => $this->input->post('gender')
        );

        // 비밀번호가 입력되었을 때만 해시 처리하여 배열에 추가
        if (!empty($password)) {
            $data['user_pw'] = password_hash($password, PASSWORD_DEFAULT);
        }

        $result = $this->user_model->insert_user($data);

        if ($result) {
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'fail', 'message' => '등록 중 오류가 발생했습니다.'));
        }
    }

    // 유저 수정 (Update)
    public function update_user()
    {
        error_reporting(0);
        header('Content-Type: application/json');

        $id = $this->input->post('user_id');
        $data = array(
            'user_name' => $this->input->post('user_name'),
            'email'     => $this->input->post('email'),
            'gender'    => $this->input->post('gender')
        );

        // 사용자가 비밀번호를 입력해서 보냈을 경우에만 (즉, 변경 체크박스를 켰을 때)
        $password = $this->input->post('user_pw');
        if (!empty($password)) {
            $data['user_pw'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $result = $this->user_model->update_user($id, $data);

        if ($result) {
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'fail', 'message' => '수정 중 오류가 발생했습니다.'));
        }
    }

    // 유저 삭제 (Delete)
    public function delete_user()
    {
        error_reporting(0);
        header('Content-Type: application/json');

        $id = $this->input->post('id');
        $result = $this->user_model->delete_user($id);

        if ($result) {
            echo json_encode(array('status' => 'success'));
        } else {
            echo json_encode(array('status' => 'fail', 'message' => '삭제 중 오류가 발생했습니다.'));
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
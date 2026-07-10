<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @property CI_Loader $load
 * @property CI_Session $session
 * @property Login_model $login_model
 */

class Login extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // 모델 로드
        $this->load->model('login_model');
    }

    public function index()
    {
        $this->load->view('login');
    }

    public function login_process()
    {
        $post = $_POST;

        $user = $this->login_model->login($post);

        if ($user) {
            $this->session->set_userdata([
                'login'     => true,
                'user_idx'  => $user['id'],
                'user_id'   => $user['user_id'],
                'user_name' => $user['user_name'],
            ]);

            // 성공 시 알림 후 이동
            echo "<script>alert('환영합니다, {$user['user_name']}님!'); location.href='/main';</script>";
        } else {
            // 실패 시 알림 후 이동
            echo "<script>alert('아이디와 비밀번호를 확인해주세요.'); location.href='/login';</script>";
        }
    }
    // 로그아웃
    public function logout()
    {
        // 세션 삭제후 메인 리다이렉트
        $this->session->sess_destroy();

        redirect('/main');
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
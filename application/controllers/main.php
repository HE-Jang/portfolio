<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Main extends CI_Controller {

	public function index()
	{
		$this->load->view('main');
	}
	public function login()
	{
        $post = $_POST;
        // 모델 로드
        $this->load->model('login_model');

        $user = $this->login_model->login($post);

        if($user){
            // ✅ 여기서 세션 세팅
            $this->session->set_userdata([
                'login'     => true,
                'user_idx'  => $user['id'],
                'user_id'   => $user['user_id'],
                'user_name' => $user['user_name'],
            ]);
            echo "로그인 성공";
            // redirect('/main');
        } else {
            echo '로그인 실패';
            return false;
        }
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
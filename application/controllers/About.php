<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * @property CI_Loader $load
 * @property CI_Session $session
 * @property Profile_model $profile_model
 */
class About extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('profile_model');
    }

    public function index()
    {

        $data['me'] = $this->profile_model->get_profile_data('me');
        $data['about'] = $this->profile_model->get_profile_data('about');
        $data['skills'] = $this->profile_model->get_profile_data('skill');
        $data['title'] = "자기소개 | 백엔드 개발자";

        $this->load->view('about', $data);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
<?php if (! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * @property CI_Loader $load
 * @property CI_Session $session
 * @property Contact_model $contact_model
 */

class Contact extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        // 모델 로드
        $this->load->model('contact_model');
    }

    public function index()
    {
        $data['contact'] = $this->contact_model->get_data_by_category('contact');

        $data['title'] = "연락처 | 장한음";
        $this->load->view('contact', $data);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
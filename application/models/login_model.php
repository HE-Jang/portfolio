<?php if (! defined('BASEPATH')) exit('No direct script access allowed');

class Login_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function login($post)
    {
        $sql = "SELECT * FROM users WHERE user_id = ? LIMIT 1";
        $query = $this->db->query($sql, [$post['id']]);

        if ($query->num_rows() === 1) {
            $user = $query->row_array();

            // 1. password_verify로 해시값 검증 (이미 해시된 경우)
            if (password_verify($post['pw'], $user['user_pw'])) {
                return $user;
            }

            // 2. 만약 위에서 실패했다면? 혹시 평문인가 확인 (기존 회원 처리)
            if ($post['pw'] === $user['user_pw']) {

                // 비밀번호를 새로 해시화
                $new_hash = password_hash($post['pw'], PASSWORD_DEFAULT);

                // DB에 새로운 해시값으로 업데이트
                $this->db->where('user_id', $user['user_id']);
                $this->db->update('users', ['user_pw' => $new_hash]);

                // 업데이트된 유저 정보 다시 로드하거나 그대로 리턴
                return $user;
            }
        }
        return false;
    }
}

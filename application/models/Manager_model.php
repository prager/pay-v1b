<?php
class Manager_model extends CI_Model {
	
    function __construct() {
		parent::__construct();
		$this->load->database();
	}

	public function check_student($email) {
        $retval = false;

        $this->db->select('*');
        $this->db->where('email', $email);
        $this->db->where('id_mem_types', 5);
        $this->db->from('tMembers');
        if($this->db->count_all_results() == 0) $retval = true;

        return $retval;
    }

    private function guid() {
        if (function_exists('com_create_guid') === true)
            return trim(com_create_guid(), '{}');
        
        $data = openssl_random_pseudo_bytes(16);
        $data[6] = chr(ord($data[6]) & 0x0f | 0x40);
        $data[8] = chr(ord($data[8]) & 0x3f | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
        }

}
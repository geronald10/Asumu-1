<?php
class User_model extends CI_Model {
    private $table = 'user';
    public function __construct()
    {
        $this->load->database('default');
    }

    public function login($username,$password)
    {
      $this->db->where('username',$username);
      $this->db->where('password',$password);
      return $this->db->get($this->table)->result();
    }
}

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


    public function updatePenghasilan($username, $penghasilan) {
      $args = array('username'=>$username, 'penghasilan'=>$penghasilan);
      $this->db->where('username', $username);
      return $this->db->update($this->table, $args);
    }
}

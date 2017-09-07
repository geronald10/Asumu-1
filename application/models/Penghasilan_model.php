<?php
class Pengeluaran_model extends CI_Model {
    private $table = 'pengeluaran_default';
    public function __construct()
    {
        $this->load->database('default');
    }


    // public function login($username,$password)
    // {
    //   $this->db->where('username',$username);
    //   $this->db->where('password',$password);
    //   return $this->db->get($this->table)->result();
    // }
}

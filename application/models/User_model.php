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
      $args = array('penghasilan'=>$penghasilan);
      $this->db->where('username', $username);
      return $this->db->update($this->table, $args);
    }

    public function register($post)
    {
      $this->db->where('username',$post['username']);
      $result = $this->db->get($this->table);
      if($result->num_rows() > 0)
      {
        return FALSE;
      }
      else {
        return $this->db->insert($this->table,$post);
      }

    }

    public function detail_user($username)
    {
      $this->db->where('username',$username);
      return $this->db->get($this->table)->row();
    }


}

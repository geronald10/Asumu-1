<?php
class Pengeluaran_model extends CI_Model {
    private $table = 'pengeluaran_default';
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

    public function newPengeluaranDefault($username, $desc, $amount) {
      $args = array('username'=>$username, 'pengeluaran_desc'=>$desc, 'pengeluaran_amount'=>$amount);
      return $this->db->insert($this->table, $args);
    }

	public function updatePengeluaranDefault($username, $desc, $amount) {
		$args = array('pengeluaran_desc'=>$desc, 'pengeluaran_amount'=>$amount);
		$this->db->where('username',$username);
		$this->db->where('pengeluaran_desc',$desc);
		return $this->db->update($this->table, $args);
	}

	public function deletePengeluaranDefault($username, $desc) {
    	$this->db->where('username', $username);
    	$this->db->where('pengeluaran_desc', $desc);
		return $this->db->delete($this->table);
	}

	public function getPengeluaranDefault($username) {
    	$this->db->where('username', $username);
    	return $this->db->get($this->table)->result();
	}

}

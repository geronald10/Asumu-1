<?php
class HistoryTarget_model extends CI_Model {
    private $table = 'history_target';
    public function __construct()
    {
        $this->load->database('default');
    }

    public function insert_historyTarget($history)
    {
      return $this->db->insert($this->table,$history);
    }

    public function delete_history($id)
    {
      $this->db->where('id_target',$id);
      return $this->db->delete($this->table);
    }

    public function getHistoryTarget($username) {
    	$this->db->from("$this->table ht");
    	$this->db->join('target t', 'ht.id_target = t.id_target');
    	$this->db->join('user u', 'ht.username = u.username');
    	$this->db->where('ht.username', $username);
    	return $this->db->get()->result();
	}

}

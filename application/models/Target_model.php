<?php
class Target_model extends CI_Model {
    private $table = 'target';
    public function __construct()
    {
        $this->load->database('default');
    }

    public function insert_target($args)
    {
			$this->db->insert($this->table,$args);
			$insert_id = $this->db->insert_id();
			return $insert_id;
    }

    public function update_target($id,$args)
    {
      $this->db->where('id_target',$id);
      return $this->db->update($this->table,$args);
    }

    public function update_status_target($id,$args)
    {
      $this->db->where('id_target',$id);
      return $this->db->update($this->table,$args);
    }

    public function update_targetUser($username, $post)
    {
      $this->db->where('username',$username);
      return $this->db->update('user',$post);
    }

    public function delete_target($id)
    {
      $this->db->where('id_target',$id);
      return $this->db->delete($this->table);
    }

    public function detail_target($id)
    {
      $this->db->where('id_target',$id);
      return $this->db->get($this->table)->row();
    }

    public function update_offset_target($id,$offset)
    {
      $args = array(
        'offset' => $offset
      );
      $this->db->where('id_target',$id);
      $this->db->update($this->table, $args);
    }

}

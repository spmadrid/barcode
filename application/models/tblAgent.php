<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*validate users*/
class tblAgent extends CI_Model
{

	private $table = 'tblAgent';
	
	 function validate_account()
	{
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$data = array(
			'AgentCode'=>$username
		);
		$q = $this->db->get_where($this->table,$data);
		if($q->num_rows() > 0)
		{
			$data2 = array(
				'AgentCode'=>$username,
				'AgentPin'=>$password
			);
			
			$check  = $this->db->get_where($this->table, $data2);
			if($check->num_rows() > 0)
			{
				
				if(md5($q->row()->AgentPin) == md5($password)){
					return $q->row();
				}else
				{
					return FALSE;
				}
				
				//return $q->row();
			}
			return FALSE;
		}
		
		return FALSE;
	}
	
	function list_data($where)
	{
		$q  = $this->db->query("select * from ".$this->table." ".$where." ");
		return $q;
	}
	
	function user_sort_limit($where, $sort , $limit)
	{
		$q = $this->db->query("select * from ".$this->table." ".$where." ".$sort." ".$limit);
		return $q;
	}
	
	function updateStatus($array){
	
		foreach($array as $id){
			
			$look = $this->db->query("SELECT * FROM ".$this->table. " where ID = '".$id."'");		
			if($look->num_rows() > 0){
				
				$stat = $look->row();
				if($stat->AgentStatus == "ACTIVE"){
					$data = array(
						'AgentStatus'=>'INACTIVE'
					);
					$q = $this->db->where('id',$id)->update($this->table,$data);
				}else
				{
					$data = array(
						'AgentStatus'=>'ACTIVE'
					);
					$q = $this->db->where('id',$id)->update($this->table,$data);
				}
				
			}
		}
		
		return TRUE;
	}
	
	function validate_user($name,$id){
		
		$q = $this->db->query("select * from ".$this->table." where AgentName = '".$name."' OR ID = '".$id."'");
		return $q;
	}
	
	
	function insert($data)
	{
		$q = $this->db->insert($this->table,$data);
		return $q;
	}
	
	function view_info($id)
	{
		$q = $this->db->query("select * from ".$this->table." where ID = '".$id."' limit 1");
		return $q->row();
	}
	
	function update($data, $id)
	{
		$q = $this->db->where('ID',$id)->update($this->table,$data);
		return $q;
	}

	
}
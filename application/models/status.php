<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*display and update status and sub status*/
class status extends CI_Model
{
	private $status = "tblstatuslist";
	private $sub = "tblstatussub";
	
	function status_list()
	{
		$response  = array();
		$q= $this->db->query("select * from $this->status ");
		$response[] = "SELECT";
		if($q->num_rows()>0)
		{
				foreach($q->result() as $value)
				{
					$response[$value->id] = $value->status_name;

				}
				
				return $response;
		}
		return FALSE;
	}
	
	function back_list()
	{
		$response  = array();
		$q= $this->db->query("select * from tblbank");
		$response[] = "SELECT";
		if($q->num_rows()>0)
		{
				foreach($q->result() as $value)
				{
					$response[$value->id] = $value->bank_name;
				}
				return $response;
		}
		return FALSE;
	}
	
	function status_lists()
	{
		$response = array();
		$response[''] = "SELECT";
		$q= $this->db->query("SELECT * FROM tblstatuslist");
		if($q->num_rows() > 0)
		{
				foreach($q->result() as $res)
				{
					$response[$res->status_name] = $res->status_name;
				}
		}
		
		return $response;
		
	}
	
	function status_search($code)
	{
		$q = $this->db->query("SELECT * FROM tblStatus where ChCode = '".$code."'");
		if($q->num_rows()>0)
		{
			$q = $q->row();
			return $q->Status;
		}
		return '';
	}
	
}
	
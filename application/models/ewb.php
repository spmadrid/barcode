<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*access for ewb bank*/
class ewb extends CI_Model
{
	
	private $table = 'tblEWB';
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
}
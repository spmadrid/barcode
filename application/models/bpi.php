<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*access for bpi bank*/
class bpi extends CI_Model
{
	
	private $table = 'tblBPI';
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
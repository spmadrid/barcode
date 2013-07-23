<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*access tblBank*/
class bank extends CI_Model
{
		private $table = "tblbank";
		
		function bankLists()
		{
			$q = $this->db->from($this->table)->get();
			$response = array();
			$response[''] = "Select";
			foreach($q->result() as $list)
			{
					$response[$list->bank_name] = $list->bank_name;
			}
			return $response;
			
		}
		
		
}
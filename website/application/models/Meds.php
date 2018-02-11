<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Meds extends CI_Model {
	function __construct() {
		$this->userTbl = "meds";
	}

	function getRows($params = array()) {
		$this->db->select('*');
		$this->db->from($this->userTbl);

		if(array_key_exists("conditions",$params)) {
			foreach($params["conditions"] as $key=>$value) {
				$this->db->where($key,$value);
			}
		}
		if(array_key_exists("m_id",$params)) {
			$this->db->where("m_id",$params["m_id"]);
			$query = $this->db->get();
			$result = $query->row_array();
		} else {
			if(array_key_exists("start",$params) && array_key_exists("limit",$params)) {
				$this->db->limit($params["limit"],$params["start"]);
			} elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)) {
				$this->db->limit($params["limit"]);
			}
			$query = $this->db->get();

			if(array_key_exists("reutrnType",$params) && $params["returnType"] == "count") {
				$result = $query->num_rows();
			} elseif(array_key_exists("returnType",$params) && $params["returnType"] == "single") {
				$result = ($query->num_rows() > 0) ? $query->row_array():FALSE;
			} else {
				$result = ($query->num_rows() > 0) ? $query->result_array():FALSE;
			}
		}
		return $result;
	}


	public function insert($data = array()) {
		$insert = $this->db->insert($this->userTbl, $data);

		if($insert) {
			return $this->db->insert_id();
		} else {
			return false;
		}
	}
}

<?php
	defined('BASEPATH') or exit('No direct script access allowed');

	/**
	* 
	*/
	class Person_model extends CI_Model{
		
		function __construct(){
			parent::__construct();
			$this->load->database();
		}

		private function _get_datatables_query(){
			$this->db->from($this->table);
			$i=0;

			foreach ($this->column as $item) {
				if($_POST['search']['value']){
					if($i===0){
						$this->db->group_start();
						$this->db->like($item,$_POST['search']['value']);
					}else{
						$this->db->or_like($item,$_POST['search']['value']);
					}

					if(count($this->column)-1==$i)
						$this->db->group_end();
				}

				$column[$i] = $item;
				$i++;
			}

			if(isset($_POST['order'])){
				$this->db->order_by(key($order),$order[key($order)]);
			}
			elseif (isset($this->order)) {
				$order = $this->order;
				$this->db->order_by(key($order),$order[key($order)]);
			}
		}

		function get_datatables(){
			$this->_get_datatables_query();
			if($_POST['length']!=-1)
				$this->db->limit($_POST['length'],$_POST['start']);
			$query=$this->db->get();
			return $query->result();
		}


		function count_filtered()
		{
			$this->_get_datatables_query();
			$query = $this->db->get();
			return $query->num_rows();
		}


		public function get_by_id($id)
		{
			$this->db->from($this->table);
			$this->db->where('id', $id);
			$query = $this->db->get();

			return $query->row();

		}

		public function count_all(){
			$this->db->from($this->table);
			return $this->db->count_all_results();

		}

		public function save($data){
			$this->db->insert($this->table,$data);
			return $this->db->insert_id();
		}

		public function delete_by_id($id){
			$this->db->where('id',$id);
			$this->db->delete($this->table);
		}

		public function update($where,$data){

			$this->db->update($this->table,$data,$where);
			return $this->db->affected_rows();
		}


	}
?>
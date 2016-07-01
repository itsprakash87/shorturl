<?php 

	class database extends CI_Model{


		function __contruct(){

            parent::__construct();
		}

// ------------------------------**************************************************-----------------------------------------


		public function storeUrl($url,$preferred = null,$userid = "guest"){
			if($preferred != null){
				$query = $this->db->query('SELECT * FROM main WHERE shorturl = "'.$preferred.'" AND userid = "'.$userid.'"');
				if($query->num_rows() != 0){
					return null;
				}

				else{
					$query = $this->db->query('INSERT INTO main (url,shorturl,userid) VALUES ("'.$url.'","'.$preferred.'","'.$userid.'")');
				}
			}

			else{
				$query = $this->db->query('INSERT INTO main (url,userid) VALUES ("'.$url.'","'.$userid.'")');
				$query = $this->db->query('SELECT * FROM main WHERE url="'.$url.'"');

				$result = $query->result_array();
				$preferred = $result[0]['id'];
				$query = $this->db->query('UPDATE main SET shorturl = "'.$preferred.'" WHERE id = '.$preferred.'');
			}
			return $preferred;
		}

// ------------------------------**************************************************-----------------------------------------


		public function registerUser($userid,$password){
			$query = $this->db->query('SELECT * FROM users WHERE userid = "'.$userid.'"');

			if($query->num_rows() == 0){
				$query = $this->db->query('INSERT INTO users(userid,password) VALUES("'.$userid.'","'.$password.'")');
				return true;
			}
			else{
				return false;
			}			
		}

// ------------------------------**************************************************-----------------------------------------


		public function loginUser($userid,$password){
			$query = $this->db->query('SELECT * FROM users WHERE userid="'.$userid.'" AND password="'.$password.'"');

			return $query;
			$rows = $query->num_rows();

			if($rows == 1){
				$result = $query->num_rows();
				$query2 = $this->db->query('SELECT * FROM main WHERE userid = "'.$result[0]['userid'].'"');
				return $query2;
			}
			else{
				return $rows;
			}
		}

// ------------------------------**************************************************-----------------------------------------

		public function fetchAllUrl($userid){
			$query = $this->db->query('SELECT * FROM main WHERE userid = "'.$userid.'"');	
			return $query;
		}

// ------------------------------**************************************************-----------------------------------------


		public function get_url($url_tail_part){
			$query = $this->db->query('SELECT * FROM main WHERE shorturl="'.$url_tail_part.'"');

			if($query->num_rows() != 0){
				$result = $query->result_array();

				$url = $result[0]['url'];
				return $url;
			}
		}

// ------------------------------**************************************************-----------------------------------------


		public function get_url_profile($url_tail_part_1,$url_tail_part_2){
			$query = $this->db->query('SELECT * FROM main WHERE shorturl="'.$url_tail_part_2.'" AND userid = "'.$url_tail_part_1.'"');

			if($query->num_rows() != 0){
				$result = $query->result_array();

				$url = $result[0]['url'];
				return $url;
			}
			else{
				return null;
			}
		}

// ------------------------------**************************************************-----------------------------------------


		public function delete($shorturl,$userid){
			$query = $this->db->query('DELETE FROM main WHERE userid = "'.$userid.'" AND shorturl = "'.$shorturl.'"');
			return $query;
		}

// ------------------------------**************************************************-----------------------------------------


	}

?>
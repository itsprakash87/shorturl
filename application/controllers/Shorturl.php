<?php
session_start();
class Shorturl extends CI_Controller{

		
		function __construct(){
			parent::__construct();
			$this->load->helper('url');
			$this->load->database();
			$this->load->model('database');
			$this->load->library('form_validation');
		}

// ------------------------------**************************************************-----------------------------------------
		
		public function index(){
				redirect('shorturl/home');
		}

// ------------------------------**************************************************-----------------------------------------


		public function home($url_tail_1 = null,$url_tail_2 = null){
			if($url_tail_1 == null){
			// if session is set, load the profile.Else load home page.
				if(isset($_SESSION['userid'])){
					redirect('shorturl/profile/'.$_SESSION['userid']);
				}

				else{
					$error = null;
					$info = null;
					if(isset($_SESSION['url_exist'])){	$error = "This short URL already exist Exist. Please try something else."; }
					if(isset($_SESSION['new_url'])){	$info = "Your new url is : http://localhost/shorturl/index.php/shorturl/home/".$_SESSION['shortedurl'];}
					unset($_SESSION['url_exist']);
					unset($_SESSION['new_url']);
					unset($_SESSION['shortedurl']);
					$data = array("url_error"=>$error,"url_info"=>$info);
					$this->load->view('home',$data);
				}
			}
			// if there are arguments after web address,load the corresponding webpage.
			else if($url_tail_2 == null){
				$url = $this->database->get_url($url_tail_1);
				header('location:http://'.$url);
			}
			else{
				$url = $this->database->get_url_profile($url_tail_1,$url_tail_2);
				if($url != null){
					header('location:http://'.$url);
				}
				else{
					echo "404! Page Not Found";
				}
			}
			
		}

		
// ------------------------------**************************************************-----------------------------------------

		public function register(){
			// Register the user if userid is unique.
			if($this->input->post('userid') != null && $this->input->post('password') != null){
				$userid = $this->input->post('userid');
				$userid = filter_var($userid, FILTER_SANITIZE_STRING);
				$password = $this->input->post('password');
				$password = md5(filter_var($password, FILTER_SANITIZE_STRING));
				$regResult = $this->database->registerUser($userid,$password);

				if($regResult){
					$_SESSION['userid'] = $userid;
					redirect('shorturl/profile/'.$userid);
				}
				else{
					$data = array("reg_error" => "This Userid already exist.Try something else.");
					$this->load->view('home',$data);
				}
			}
		}

// ------------------------------**************************************************-----------------------------------------


		public function login(){
			// Login the user and load profile if userid and password are correct.
			if($this->input->post('userid') != null && $this->input->post('password') != null){
				$userid = $this->input->post('userid');
				$userid = filter_var($userid, FILTER_SANITIZE_STRING);
				$password = $this->input->post('password');
				$password = md5(filter_var($password, FILTER_SANITIZE_STRING));

				$result = $this->database->loginUser($userid,$password);
				if($result->num_rows() != 0){
					$_SESSION['userid'] = $userid;
					redirect('shorturl/profile/'.$userid);
				}
				else{
					$data = array('login_error' => 'UserId or Password Wrong');
					$this->load->view('home',$data);
				}
			}

			else{
				$data = array('login_error' => 'UserId and Password required.');
				$this->load->view('home',$data);
			}
		}

// ------------------------------**************************************************-----------------------------------------


		public function profile($userid=null){

			// Load profile.
			if(!isset($_SESSION['userid']) || $userid != $_SESSION['userid']){
					redirect('shorturl/home');
				}

			if($userid == null){	redirect('shorturl/home'); }
			$error = null;
			$info = null;
			if(isset($_SESSION['url_exist'])){	$error = "This short URL already exist Exist. Please try something else."; }
			if(isset($_SESSION['new_url'])){	$info = "Your new url is : http://localhost/shorturl/index.php/shorturl/home/".$userid."/".$_SESSION['shortedurl'];}
			unset($_SESSION['url_exist']);
			unset($_SESSION['new_url']);
			unset($_SESSION['shortedurl']);
			$result = $this->database->fetchAllUrl($userid);
			$rows = $result->num_rows();

			if($rows == 0){
				$data = array("not_found" => "Nothing Found", "userid" => $userid,"url_error"=>$error,"url_info"=>$info); 
				$this->load->view('profile',$data);
			}
			else{
				$result = $result->result_array();
				
				$data = array("result" => $result, "userid" => $userid,"url_error"=>$error,"url_info"=>$info);
				$this->load->view('profile',$data);
			}
			
		}

// ------------------------------**************************************************-----------------------------------------


		public function convert(){
			// Convert the url if user not logged in.
			if($this->input->post('urlToConvert') != null){
				$url = $this->input->post('urlToConvert');
				$url = filter_var($url, FILTER_SANITIZE_STRING);
				$url = preg_replace('#^https?://#', '', $url);
				$preferred = $this->input->post('preferred');
				$preferred = filter_var($preferred, FILTER_SANITIZE_STRING);
				$shortedurl = $this->database->storeUrl($url,$preferred);

				if($shortedurl == null){
					// $info = "This short URL already exist Exist. Please try something else.";
					// $data = array('url_error' => $info);
					$_SESSION['url_exist'] = true;
					// $this->load->view('home',$data);
					redirect('shorturl/home');
				}
				else{
					// $info = "Your new url is : http://localhost/shorturl/index.php/shorturl/home/".$shortedurl;
					// $data = array('url_info' => $info);
					// $this->load->view('home',$data);
					$_SESSION['new_url'] = true;
					$_SESSION['shortedurl'] = $shortedurl;
					redirect('shorturl/profile/'.$userid.'');
				}
			}

			else{
				redirect('shorturl/home');
			}
		}

// ------------------------------**************************************************-----------------------------------------


		public function profileConvert($userid){
			// Convert the url if user is logged in.
			if($this->input->post('urlToConvert') != null){
				$url = $this->input->post('urlToConvert');
				$url = filter_var($url, FILTER_SANITIZE_STRING);
				$url = preg_replace('#^https?://#', '', $url);
				$preferred = $this->input->post('preferred');
				$preferred = filter_var($preferred, FILTER_SANITIZE_STRING);
				$shortedurl = $this->database->storeUrl($url,$preferred,$userid);
				
				if($shortedurl == null){
					$_SESSION['url_exist'] = true;
					redirect('shorturl/profile/'.$userid.'');
				}
				else{
					$_SESSION['new_url'] = true;
					$_SESSION['shortedurl'] = $shortedurl;
					redirect('shorturl/profile/'.$userid.'');
				}
			}

			else{
				redirect('shorturl/profile/'.$userid);
			}
		}

// ------------------------------**************************************************-----------------------------------------


		public function delete($shorturl){
			// Delete the saved url.
			$this->database->delete($shorturl,$_SESSION['userid']);
			redirect('shorturl/profile/'.$_SESSION['userid']);
		}

// ------------------------------**************************************************-----------------------------------------


		public function logout(){
			// Logout.
			unset($_SESSION['userid']);
			redirect('shorturl/home');
		}

// ------------------------------**************************************************-----------------------------------------

}



?>
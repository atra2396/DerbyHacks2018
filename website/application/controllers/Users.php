<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Users extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library("form_validation");
		$this->load->model("user");
	}

	public function account() {
		$this->load->view("templates/header");
		$data = array();
		if($this->session->userdata("isUserLoggedIn")) {
			$data["user"] = $this->user->getRows(array("id"=>$this->session->userdata("userId")));
			//load view
			$this->load->view("users/account", $data);
		} else {
			redirect("users/login");
		}
		$this->load->view("templates/footer");
	}

	public function login() {
		$this->load->view("templates/header");
		$data = array();
		if($this->session->userdata("success_msg")) {
			$data["success_msg"] = $this->session->userdata("success_msg");
			$this->session->unset_userdata("success_message");
		}
		if($this->session->userdata("error_msg")) {
			$data["error_msg"] = $this->session->userdata("error_msg");
			$this->session->unset_userdata("error_msg");
		}
		if($this->input->post("loginSubmit")) {
			$this->form_validation->set_rules("email", "Email", "required|valid_email");
			$this->form_validation->set_rules("password", "password", "required");
			if($this->form_validation->run() == true) {
				$con["returnType"] = "single";
				$con["conditions"] = array(
					"email"=>$this->input->post("email"),
					"password"=>md5($this->input->post("password")),
					"status"=>"1"
				);
				$checkLogin = $this->user->getRows($con);
				if($checkLogin) {
					$this->session->set_userdata("isUserLoggedIn",TRUE);
					$this->session->set_userdata("userId",$checkLogin["id"]);
					redirect("users/account/");
				} else {
					$data["error_msg"] = "Wrong email or password, please try again.";
				}
			}
		}
		$this->load->view("users/login", $data);
		$this->load->view("templates/footer");
	}

	public function registration() {
		$data = array();
        	$userData = array();
		if($this->input->post("regisSubmit")) {
			$this->form_validation->set_rules("name","Name","required");
			$this->form_validation->set_rules("email","Email","required|valid_email|callback_email_check");
			$this->form_validation->set_rules("password","password","required");
			$this->form_validation->set_rules("conf_password","confirm password","required|matches[password]");
			$this->form_validation->set_rules("location","location","required");

			$userData=array(
				"name"=>strip_tags($this->input->post("name")),
				"email"=>strip_tags($this->input->post("email")),
				"password"=>md5($this->input->post("password")),
				"phone"=>strip_tags($this->input->post("phone")),
				"location"=>strip_tags($this->input->post("location"),
			);

			if($this->form_validation->run()==true){
				$insert = $this->user->insert($userData);
				if($insert) {
					$this->session->set_userdata("success_msg", "Resgistered Successfully. Please log in to continue.");
					redirect("users/login");
				} else {
					$data["error_msg"] = "Something went wrong, try again.";
				}
			}
		}
		$data['user'] = $userData;
		$this->load->view("templates/header");
		$this->load->view("users/registration",$data);
		$this->load->view("templates/footer");
	}

	public function logout() {
		$this->session->unset_userdata("isUserLoggedIn");
		$this->session->unset_userdata("userId");
		$this->session->sess_destroy();
		redirect("users/login/");
	}

	public function email_check($str) {
		$con["returnType"] = "count";
		$con["conditions"] = array("email"=>$str);
		$checkEmail = $this->user->getRows($con);
		if($checkEmail > 0) {
			$this->form_validation->set_message("email_check", "Email already in use.");
			return FALSE;
		} else {
			return TRUE;
		}
	}
}

<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Users extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library("form_validation");
		$this->load->model("user");
	}

	public function account() {
		if(!array_key_exists("isUserLoggedIn", $this->session->userdata) || !$this->session->userdata["isUserLoggedIn"]) {
                        $this->session->set_userdata("error_msg", "You must be logged in to access that page");
                        redirect("/users/login");
                }
		$data = array();
		$data["title"] = "Account";
		$this->load->view("templates/header", $data);
		if($this->session->userdata("isUserLoggedIn")) {
			$data["user"] = $this->user->getRows(array("n_id"=>$this->session->userdata("userId")));
			//load view
			$this->load->view("users/account", $data);
		} else {
			redirect("users/login");
		}
		$this->load->view("templates/footer", $data);
	}

	public function login() {
		$data = array();
		$data["title"] = "Login";

		if($this->input->post("loginSubmit")) {
			$this->form_validation->set_rules("email", "Email", "required|valid_email");
			$this->form_validation->set_rules("password", "password", "required");
			if($this->form_validation->run() == true) {
				$con["returnType"] = "single";
				$con["conditions"] = array(
					"n_email"=>$this->input->post("email"),
					"n_password"=>md5($this->input->post("password"))
				);
				$checkLogin = $this->user->getRows($con);
				if($checkLogin) {
					$this->session->set_userdata("isUserLoggedIn",TRUE);
					$this->session->set_userdata("userId",$checkLogin["n_id"]);
					redirect("users/account/");
				} else {
					$data["error_msg"] = "Wrong email or password, please try again.";
				}
			}
		}
		$this->load->view("templates/header", $data);
		$this->load->view("users/login", $data);
		$this->load->view("templates/footer", $data);
	}

	public function registration() {
		$data = array();
		$data["title"]="Register";
        	$userData = array();
		if($this->input->post("regisSubmit")) {
			$this->form_validation->set_rules("name","Name","required");
			$this->form_validation->set_rules("email","Email","required|valid_email|callback_email_check");
			$this->form_validation->set_rules("password","password","required");
			$this->form_validation->set_rules("conf_password","confirm password","required|matches[password]");
			$this->form_validation->set_rules("location","location","required");
			$this->form_validation->set_rules("phone","phone","required");

			$userData=array(
				"n_name"=>strip_tags($this->input->post("name")),
				"n_email"=>strip_tags($this->input->post("email")),
				"n_password"=>md5($this->input->post("password")),
				"n_phone"=>strip_tags($this->input->post("phone")),
				"n_location"=>strip_tags($this->input->post("location")),
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
		$this->load->view("templates/header", $data);
		$this->load->view("users/registration",$data);
		$this->load->view("templates/footer", $data);
	}

	public function logout() {
		$this->session->unset_userdata("isUserLoggedIn");
		$this->session->unset_userdata("userId");
		$this->session->sess_destroy();
		redirect("/");
	}

	public function email_check($str) {
		$con["returnType"] = "count";
		$con["conditions"] = array("n_email"=>$str);
		$checkEmail = $this->user->getRows($con);
		if($checkEmail > 0) {
			$this->form_validation->set_message("email_check", "Email already in use.");
			return FALSE;
		} else {
			return TRUE;
		}
	}
}

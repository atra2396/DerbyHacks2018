<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class View extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->model("user");
	}

	public function alerts() {
		$this->load->model("alert");
		if(!array_key_exists("isUserLoggedIn", $this->session->userdata) || !$this->session->userdata["isUserLoggedIn"]) {
                        $this->session->set_userdata("error_msg", "You must be logged in to access that page");
                        redirect("/users/login");
                }
		$data = array();
		$data["title"] = "Alerts";
		$this->load->view("templates/header", $data);
		$this->load->view("view/alerts", $data);
		$this->load->view("templates/footer", $data);
	}

	function conditions() {
		$this->load->model("condition");
		if(!array_key_exists("isUserLoggedIn", $this->session->userdata) || !$this->session->userdata["isUserLoggedIn"]) {
                        $this->session->set_userdata("error_msg", "You must be logged in to access that page");
                        redirect("/users/login");
                }
		$data = array();
		$data["title"] = "Conditions";
		$this->load->view("templates/header", $data);
		$this->load->view("view/conditions", $data);
		$this->load->view("templates/footer", $data);
	}

	function medicines() {
		$this->load->model("meds");
		if(!array_key_exists("isUserLoggedIn", $this->session->userdata) || !$this->session->userdata["isUserLoggedIn"]) {
                        $this->session->set_userdata("error_msg", "You must be logged in to access that page");
                        redirect("/users/login");
                }
		$data = array();
		$data["title"] = "Medicines";
		$this->load->view("templates/header", $data);
		$this->load->view("view/medicines", $data);
		$this->load->view("templates/footer", $data);
	}
	function patients() {
		$this->load->model("patient");
		if(!array_key_exists("isUserLoggedIn", $this->session->userdata) || !$this->session->userdata["isUserLoggedIn"]) {
                        $this->session->set_userdata("error_msg", "You must be logged in to access that page");
                        redirect("/users/login");
                }
		$data = array();
		$data["title"] = "Patients";
		$this->load->view("templates/header", $data);
		$this->load->view("view/patients", $data);
		$this->load->view("templates/footer", $data);
	}
	function questions() {
		$this->load->model("question");
		if(!array_key_exists("isUserLoggedIn", $this->session->userdata) || !$this->session->userdata["isUserLoggedIn"]) {
                        $this->session->set_userdata("error_msg", "You must be logged in to access that page");
                        redirect("/users/login");
                }
		$data = array();
		$data["title"] = "Questions";
		$this->load->view("templates/header", $data);
		$this->load->view("view/questions", $data);
		$this->load->view("templates/footer", $data);
	}
}

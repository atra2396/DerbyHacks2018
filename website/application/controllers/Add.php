<?php if ( ! defined("BASEPATH")) exit("No direct script access allowed");

class Add extends CI_Controller {

	function __construct() {
		parent::__construct();
		$this->load->library("form_validation");
	}

	public function medicine() {
		if(!array_key_exists("isUserLoggedIn", $this->session->userdata) || !$this->session->userdata["isUserLoggedIn"]) {
			$this->session->set_userdata("error_msg", "You must be logged in to access that page.");
			redirect("/users/login");
		}
		$data = array();
		$this->load->model("meds");

		$data["title"]="Add Medicine";
        	$medData = array();
		if($this->input->post("medSubmit")) {
			$this->form_validation->set_rules("name","Name","required");
			$this->form_validation->set_rules("directions","directions","required");
			$this->form_validation->set_rules("dosage","dosage","required");
			$this->form_validation->set_rules("priority","priority","required");

			$medData=array(
				"m_name"=>strip_tags($this->input->post("name")),
				"m_directions"=>strip_tags($this->input->post("directions")),
				"m_dosage"=>strip_tags($this->input->post("dosage")),
				"m_priority"=>strip_tags($this->input->post("priority"))
			);

			if($this->form_validation->run()==true){
				$insert = $this->meds->insert($medData);
				if($insert) {
					$this->session->set_userdata("success_msg", "Medicine Added Successfully.");
					redirect("/add/medicine");
				} else {
					$data["error_msg"] = "Something went wrong, try again.";
				}
			}
		}
		$data['meds'] = $medData;
		$this->load->view("templates/header", $data);
		$this->load->view("add/medicine",$data);
		$this->load->view("templates/footer", $data);
	}

	function question() {

		if(!array_key_exists("isUserLoggedIn", $this->session->userdata) || !$this->session->userdata["isUserLoggedIn"]) {
			$this->session->set_userdata("error_msg", "You must be logged in to access that page.");
			redirect("/users/login");
		}

		$data = array();

		$data["title"] = "Add a Question";

		$this->load->model("question");

		$qData = array();
		if($this->input->post("qSubmit")) {
			$this->form_validation->set_rules("question","question","required");
			$qData = array(
				"q_text"=>strip_tags($this->input->post("question")),
			);

			if($this->form_validation->run()==true){
				$insert = $this->question->insert($qData);
				if($insert) {
					$this->session->set_userdata("success_msg", "Question Added Successfully.");
					redirect("/add/question");
				} else {
					$data["error_msg"] = "Something went wrong, try again.";
				}
			}
		}
		$data['questions'] = $qData;
		$this->load->view("templates/header", $data);
		$this->load->view("add/questions",$data);
		$this->load->view("templates/footer", $data);

	}

	function patient() {

		if(!array_key_exists("isUserLoggedIn", $this->session->userdata) || !$this->session->userdata["isUserLoggedIn"]) {
			$this->session->set_userdata("error_msg", "You must be logged in to access that page.");
			redirect("/users/login");
		}

		$data = array();

		$data["title"] = "Add a Patient";

		$this->load->model("patient");

		$pData = array();

		if($this->input->post("pSubmit")) {
			$this->form_validation->set_rules("name","name","required");
			$this->form_validation->set_rules("email","Email","required|valid_email|callback_email_check");
                        $this->form_validation->set_rules("location","location","required");
			$this->form_validation->set_rules("phone","phone","required");

			$pData = array(
				"p_name"=>strip_tags($this->input->post("name")),
				"p_email"=>strip_tags($this->input->post("email")),
				"p_location"=>strip_tags($this->input->post("location")),
				"p_phone"=>strip_tags($this->input->post("phone")),
				"n_id"=>$this->session->userdata["userId"]
			);

			if($this->form_validation->run()==true){
				echo "test3";
				$insert = $this->patient->insert($pData);
				if($insert) {
					echo "test";
					$this->session->set_userdata("success_msg", "Patient Added Successfully.");
					redirect("/add/patient");
				} else {
					echo "test2";
					$data["error_msg"] = "Something went wrong, try again.";
				}
			}
		}
		$data['patient'] = $pData;
		$this->load->view("templates/header", $data);
		$this->load->view("add/patient",$data);
		$this->load->view("templates/footer", $data);

	}

	public function email_check($str) {
                $con["returnType"] = "count";
                $con["conditions"] = array("p_email"=>$str);
                $checkEmail = $this->patient->getRows($con);
                if($checkEmail > 0) {
                        $this->form_validation->set_message("email_check", "Email already in use.");
                        return FALSE;
                } else {
                        return TRUE;
                }
        }

}

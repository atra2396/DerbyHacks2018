<?php
class Main Extends CI_Controller {

	public function index() {
		$this->load->model("user");
		if(array_key_exists("isUserLoggedIn", $this->session->userdata) && $this->session->userdata["isUserLoggedIn"]) {
			redirect("/users/account");
		} else {
			$data['title'] = "Echo Care";
			$this->load->helper('url');
			$this->load->view('templates/header', $data);
			$this->load->view('home_page');
			$this->load->view('templates/footer', $data);
		}
	}
}
?>

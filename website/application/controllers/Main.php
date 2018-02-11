<?php
class Main Extends CI_Controller {

	public function index() {
		$data['title'] = "Echo Care";

		$this->load->helper('url');
		$this->load->view('templates/header', $data);
		$this->load->view('home_page');
		$this->load->view('templates/footer', $data);
	}
}
?>

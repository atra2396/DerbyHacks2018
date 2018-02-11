<html>
        <head>
                <title><?php echo $title; ?></title>
		<link rel="stylesheet" type="text/css" href="https://bootswatch.com/4/spacelab/bootstrap.css">
		<link rel="icon" href="<?=base_url()?>/favicon.ico" type="image/ico">
		<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
        </head>
        <body>
<nav class="navbar navbar-expand-lg navbar-dark bg-primary">
	<a class="navbar-brand" href="/">Echo Care</a>
	<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
		<span class="navbar-toggler-icon"></span>
	</button>

	<div class="collapse navbar-collapse" id="navbarSupportedContent">
		<ul class="navbar-nav">
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					View...
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="/users/account">My Account</a>
					<a class="dropdown-item" href="/view/alerts">Alerts</a>
					<a class="dropdown-item" href="/view/conditions">Conditions</a>
					<a class="dropdown-item" href="/view/medicines">Medicines</a>
					<a class="dropdown-item" href="/view/patients">Patients</a>
					<a class="dropdown-item" href="/view/questions">Questions</a>
				</div>
			</li>
			<li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
					Add...
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
					<a class="dropdown-item" href="/add/alert">Alert</a>
					<a class="dropdown-item" href="/add/condition">Condition</a>
					<a class="dropdown-item" href="/add/medicine">Medicine</a>
					<a class="dropdown-item" href="/add/patient">Patient</a>
					<a class="dropdown-item" href="/add/question">Question</a>
				</div>
			</li>
		</ul>
		<ul class="navbar-nav ml-auto">
			<li class="nav-item">
				<a class="nav-link" href='/users/
				<?php
				$this->load->model("user");
				if($this->session->userdata["isUserLoggedIn"]) {
					echo "logout'>Logout</a>";
				} else {
					echo "login'>Login</a>";
				}
				?>
			</li>
		</ul>
	</div>
</nav>
</br>

<?php

if($this->session->userdata("success_msg")) {
	$success = $this->session->userdata("success_msg");
        $this->session->unset_userdata("success_msg");
?>

<div class="alert alert-dismissible alert-success">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Yay!</strong> <?php echo $success; ?> 
</div>

<?php

}
if($this->session->userdata("error_msg")) {
        $error = $this->session->userdata("error_msg");
        $this->session->unset_userdata("error_msg");
?>

<div class="alert alert-dismissible alert-danger">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	<strong>Oh, no!</strong> <?php echo $error; ?>
</div>

<?php
}

?>

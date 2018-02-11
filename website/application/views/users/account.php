<div class="container-fluid">
<div class="jumbotron">
    <h2>User Account</h2>
    <h3>Welcome <?php echo $user['n_name']; ?>!</h3>
    <div class="account-info">
        <p><b>Name: </b><?php echo $user['n_name']; ?></p>
        <p><b>Email: </b><?php echo $user['n_email']; ?></p>
        <p><b>Phone: </b><?php echo $user['n_phone']; ?></p>
        <p><b>Location: </b><?php echo $user['n_location']; ?></p>
    </div>
</div>
</div>

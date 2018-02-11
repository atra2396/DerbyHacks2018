<div class="container-fluid">
<div class="jumbotron">
    <h2>Add a Patient</h2>
    <form action="" method="post">
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Name" required="" value="<?php echo !empty($user['name'])?$user['name']:''; ?>">
          <?php echo form_error('name','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
            <input type="email" class="form-control" name="email" placeholder="Email" required="" value="<?php echo !empty($user['email'])?$user['email']:''; ?>">
          <?php echo form_error('email','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="phone" placeholder="Phone" value="<?php echo !empty($user['phone'])?$user['phone']:''; ?>">
        </div>
	<div class="form-group">
	  <input type="text" class="form-control" name="location" placeholder="Location" required="">
	  <?php echo form_error('location','<span class="help-block">','</span>'); ?>
        </div>
        <button type="submit" name="pSubmit" class="btn btn-primary" value="Submit">Submit</button>
    </form>
    </div>
</div>


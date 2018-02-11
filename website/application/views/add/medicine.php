<div class="container-fluid">
<div class="jumbotron">

    <h2>Add a Medicine</h2>

    <form action="" method="post">
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Name" required="" value="<?php echo !empty($meds['name'])?$meds['name']:''; ?>">
          <?php echo form_error('name','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
            <textarea class="form-control" name="directions" placeholder="Directions" required="" value="<?php echo !empty($meds['directions'])?$meds['directions']:''; ?>" rows="3" maxlength="280"></textarea>
          <?php echo form_error('directions','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
            <input type="text" class="form-control" name="dosage" placeholder="Dosage" value="<?php echo !empty($meds['dosage'])?$meds['dosage']:''; ?>">
        </div>
	<div class="form-group">
	  <select class="form-control" name="priority" placeholder="Priority" required="">
		<option disabled selected value> -- Priority -- </option>
		<option>Low</option>
		<option>Medium</option>
		<option>High</option>
	  </select>
	  <?php echo form_error('priority','<span class="help-block">','</span>'); ?>
        </div>
        <button type="submit" name="medSubmit" class="btn btn-primary" value="Submit">Submit</button>
    </form>
    </div>
</div>

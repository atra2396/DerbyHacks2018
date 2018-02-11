<div class="container-fluid">
<div class="jumbotron">
    <h2>Add a Condition</h2>
    <form action="" method="post">
        <div class="form-group">
            <input type="text" class="form-control" name="name" placeholder="Name" required="" value="<?php echo !empty($user['name'])?$user['name']:''; ?>">
          <?php echo form_error('name','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
	  <select class="form-control" id="patient" name="patient" required="">
		<option disabled selected value> -- Patient -- </option>
		<?php
			$this->db->select('*');
			$this->db->from('patients');
			$query = $this->db->get();
			foreach($query->result() as $row) {
			echo "<option value='".$row->p_id."'>".$row->p_id.": ".$row->p_name."</option>";
			}
		?>
	  </select>
          <?php echo form_error('patient','<span class="help-block">','</span>'); ?>
        </div>
        <div class="form-group">
	  <select class="form-control" id="medicine" name="medicine" required="">
		<option disabled selected value> -- Medicine -- </option>
		<?php
			$this->db->select('*');
			$this->db->from('meds');
			$query = $this->db->get();
			foreach($query->result() as $row) {
			echo "<option value='".$row->m_id."'>".$row->m_id.": ".$row->m_name."</option>";
			}
		?>
	  </select>
          <?php echo form_error('medicine','<span class="help-block">','</span>'); ?>
        </div>
        <button type="submit" name="cSubmit" class="btn btn-primary" value="Submit">Submit</button>
    </form>
    </div>
</div>


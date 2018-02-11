<div class="container-fluid">
<div class="jumbotron">
    <h2>Add an Alert</h2>
    <form action="" method="post">
        <div class="form-group row">
	    <label for="start" class="col-2 col-form-label">Start Date: </label>
	<div class="col-10">
            <input type="date" id="start" class="form-control" name="start" required="">
          <?php echo form_error('start','<span class="help-block">','</span>'); ?>
        </div></div>
	<div class="form-group">
		<input class="form-control" type="text" id="freq" name="freq" placeholder="Frequency">
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
	  <select class="form-control" id="medicine" name="medicine">
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
        </div>
        <div class="form-group">
	  <select class="form-control" id="question" name="question">
		<option disabled selected value> -- Question -- </option>
		<?php
			$this->db->select('*');
			$this->db->from('questions');
			$query = $this->db->get();
			foreach($query->result() as $row) {
			echo "<option value='".$row->q_id."'>".$row->q_id.": ".$row->q_text."</option>";
			}
		?>
	  </select>
	</div>
        <button type="submit" name="aSubmit" class="btn btn-primary" value="Submit">Submit</button>
    </form>
    </div>
</div>


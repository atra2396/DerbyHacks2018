<div class="container-fluid">
<div class="jumbotron">
    <h2>Scheduled Alerts</h2>
    <table class="table table-striped table-row">
	<thead class="thead-dark">
	<tr>
	<th scope="col">#</th>
	<th scope="col">Start Date</th>
	<th scope="col">Frequency</th>
	<th scope="col">Patient</th>
	<th scope="col">Medicine</th>
	<th scope="col">Question</th>
	</tr>
	</thead>
	<tbody>
    <?php
	$this->load->model("alert");
	$this->load->model("patient");

	$query = $this->alert->getRows(array());
	foreach($query as $row) {

	$p_query = $this->db->query("SELECT * FROM patients WHERE p_id=".$row['p_id'].";")->row();
	$m_query = $this->db->query("SELECT * FROM meds WHERE m_id=".$row['m_id'].";")->row();
	$q_query = $this->db->query("SELECT * FROM questions WHERE q_id=".$row['q_id'].";")->row();

	echo "<tr>";
		echo "<td>".$row["a_id"]."</td>";
		echo "<td>".$row["a_start_date"]."</td>";
		echo "<td>".$row["a_frequency"]."</td>";
		echo "<td>".$p_query->p_name."</td>";
		if($row["m_id"] == '0') {
			echo "<td>-</td>";
		} else {
			echo "<td>".$m_query->m_name."</td>";
		}
		if($row["q_id"] == '0') {
			echo "<td>-</td>";
		} else {
			echo "<td>".$q_query->q_text."</td>";
		}
	echo "</tr>";
	}
    ?>
	</tbody>
	</table>
</div>
</div>


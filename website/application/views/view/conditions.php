<div class="container-fluid">
<div class="jumbotron">
    <h2>Recorded Conditions</h2>
    <table class="table table-striped table-row">
	<thead class="thead-dark">
	<tr>
	<th scope="col">#</th>
	<th scope="col">Name</th>
	<th scope="col">Patient</th>
	<th scope="col">Medicine</th>
	</tr>
	</thead>
	<tbody>
    <?php
	$this->load->model("condition");
	$this->load->model("patient");

	$query = $this->condition->getRows(array());
	foreach($query as $row) {

	$p_query = $this->db->query("SELECT * FROM patients WHERE p_id=".$row['p_id'].";")->row();
	$m_query = $this->db->query("SELECT * FROM meds WHERE m_id=".$row['m_id'].";")->row();

	echo "<tr>";
		echo "<td>".$row["c_id"]."</td>";
		echo "<td>".$row["c_name"]."</td>";
		echo "<td>".$p_query->p_name."</td>";
		echo "<td>".$m_query->m_name."</td>";
	echo "</tr>";
	}
    ?>
	</tbody>
	</table>
</div>
</div>


<div class="container-fluid">
<div class="jumbotron">
    <h2>Available Medicines</h2>
    <table class="table table-striped table-row">
	<thead class="thead-dark">
	<tr>
	<th scope="col">#</th>
	<th scope="col">Name</th>
	<th scope="col">Phone</th>
	<th scope="col">Email</th>
	<th scope="col">Location</th>
	<th scope="col">Attending Nurse</th>
	</tr>
	</thead>
	<tbody>
    <?php
	$query = $this->patient->getRows(array());
	foreach($query as $row) {
	$n_query=$this->db->query("SELECT * FROM nurses WHERE n_id=".$row['n_id'].";")->row();

	echo "<tr>";
		echo "<td>".$row["p_id"]."</td>";
		echo "<td>".$row["p_name"]."</td>";
		echo "<td>".$row["p_phone"]."</td>";
		echo "<td>".$row["p_email"]."</td>";
		echo "<td>".$row["p_location"]."</td>";
		echo "<td>".$n_query->n_name."</td>";
	echo "</tr>";
	}
    ?>
	</tbody>
	</table>
</div>
</div>


<div class="container-fluid">
<div class="jumbotron">
    <h2>Available Medicines</h2>
    <table class="table table-striped table-row">
	<thead class="thead-dark">
	<tr>
	<th scope="col">#</th>
	<th scope="col">Name</th>
	<th scope="col">Directions</th>
	<th scope="col">Dosage</th>
	<th scope="col">Priority</th>
	</tr>
	</thead>
	<tbody>
    <?php
	$this->load->model("alert");
	$this->load->model("patient");

	$query = $this->meds->getRows(array());
	foreach($query as $row) {

	echo "<tr>";
		echo "<td>".$row["m_id"]."</td>";
		echo "<td>".$row["m_name"]."</td>";
		echo "<td>".$row["m_directions"]."</td>";
		echo "<td>".$row["m_dosage"]."</td>";
		echo "<td>".$row["m_priority"]."</td>";
	echo "</tr>";
	}
    ?>
	</tbody>
	</table>
</div>
</div>


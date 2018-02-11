<div class="container-fluid">
<div class="jumbotron">
    <h2>Available Medicines</h2>
    <table class="table table-striped table-row">
	<thead class="thead-dark">
	<tr>
	<th scope="col">#</th>
	<th scope="col">Text</th>
	</tr>
	</thead>
	<tbody>
    <?php
	$query = $this->question->getRows(array());
	foreach($query as $row) {

	echo "<tr>";
		echo "<td>".$row["q_id"]."</td>";
		echo "<td>".$row["q_text"]."</td>";
	echo "</tr>";
	}
    ?>
	</tbody>
	</table>
</div>
</div>


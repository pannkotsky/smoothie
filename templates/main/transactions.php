<h1>Transactions</h1>

<div class="btn-group" style="padding:30px">
	<a href="new_transaction.php" type="button" class="btn btn-warning">Spend money</a>
	<a href="new_transaction.php" type="button" class="btn btn-success">Get money</a>
	<a href="new_transaction.php" type="button" class="btn btn-info">No money involved</a>
</div>

<table class="table">
	<thead>
		<tr>
			<th>ID</th>
			<th>Date</th>
			<th>Sum</th>
			<th>Currency</th>
			<th>Debit</th>
			<th>Credit</th>
			<th>Income (loss)</th>
			<th>Fact/plan</th>
		</tr>

<?php	
	
	// query transactions data
	$rows = query("SELECT * FROM transactions ORDER BY date");
	
	
	// display data
	foreach ($rows as $row):
		$debit = query("SELECT name FROM balanceItems WHERE id=?", $row["debit"])[0]["name"];
		$credit = query("SELECT name FROM balanceItems WHERE id=?", $row["credit"])[0]["name"];
		if ($row["income"]) {
			$income = query("SELECT name FROM incomeItems WHERE id=?", $row["income"])[0]["name"];
		}
		else {
			$income = "";
		}		
?>
		<tr>
			<td><?= $row["id"] ?></td>
			<td><?= $row["date"] ?></td>
			<td><?= number_format((float)$row["sum"] / 100, 2, '.', '') ?></td>
			<td><?= $row["currency"] ?></td>
			<td><?= $debit ?></td>
			<td><?= $credit ?></td>
			<td><?= $income ?></td>
			<td><?= $row["type"] ?></td>
		</tr>		
<?php		
	endforeach;	
?>

</table>

<h1>Profit & Loss</h1>

<table class="table">
	<thead>
		<tr>
			<th>Item</th>
			<th>Value</th>
		</tr>

<?php	
	// define aliases for multiple html spaces
	$SPACE8 = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
	$SPACE16 = $SPACE8 . $SPACE8;
	
	// query income data
	$sections = query("SELECT * FROM incomeSections ORDER BY id");
	$lines = query("SELECT * FROM incomeLines ORDER BY section_id, id");
	$items = query("SELECT * FROM incomeItems WHERE user_id = ? ORDER BY id", $_SESSION["id"]);
	
	// count sums and find subitems	
	foreach ($lines as &$line) {
		$line["value"] = 0;
		$line["categories"] = [];
		foreach ($items as $item) {
			if ($item["line_id"] == $line["id"] && $item["value"] != 0) {
				$line["items"][] = $item;
				$line["value"] += $item["value"];
			}		
		}	
	}
	unset($line);
	
	foreach ($sections as &$section) {
		$section["value"] = 0;
		$section["lines"] = [];
		foreach ($lines as $line) {
			if ($line["section_id"] == $section["id"] && $line["value"] != 0) {
				$section["lines"][] = $line;
				$section["value"] += $line["value"];
			}		
		}
		if ($section["id"] == 1) {
			$revenue = $section["value"];
		}	
		else {
			$expense = $section["value"];
		}
	}
	unset($section);
	
	// display data
	foreach ($sections as $section):
		if ($section["id"] == 1) {
			$color = "green";
		}
		else {
			$color = "red";
		}
		
?>
		<tr>
			<td style="font-weight:bold;color:<?= $color ?>"><?= $section["name"] ?></b></td>
			<td style="font-weight:bold;color:<?= $color ?>"><?= number_format((float)$section["value"] / 100, 2, '.', '') ?></b></td>
		</tr>		
<?php
		foreach ($section["lines"] as $line):			
?>
			<tr>
				<td style="color:<?= $color ?>"><?= $SPACE8 . $line["name"] ?></td>
				<td style="color:<?= $color ?>"><?= number_format((float)$line["value"] / 100, 2, '.', '') ?></td>
			</tr>
<?php
			
			foreach ($line["items"] as $item):
?>
				<tr>
					<td><?= $SPACE16 . $SPACE8 . $item["name"] ?></td>
					<td><?= number_format((float)$item["value"] / 100, 2, '.', '') ?></td>
				</tr>
<?php
			endforeach;					
		endforeach;
	endforeach;	
?>
	<tfoot>
		<tr>
			<td>NET INCOME</td>
			<td><?= number_format((float)($revenue - $expense) / 100, 2, '.', '') ?></td>		
		</tr>	
	</tfoot>

</table>

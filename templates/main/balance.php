<h1>Balance</h1>

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
	
	// query balance data
	$sections = query("SELECT * FROM balanceSections ORDER BY id");
	$lines = query("SELECT * FROM balanceLines ORDER BY id");
	$categories = query("SELECT * FROM balanceCategories ORDER BY id");
	$items = query("SELECT * FROM balanceItems WHERE user_id = ? ORDER BY id", $_SESSION["id"]);
	
	// count sums and find subitems
	foreach ($categories as &$category) {
		$category["value"] = 0;
		$category["items"] = [];
		foreach ($items as $item) {
			if ($item["category_id"] == $category["id"] && $item["value"] != 0) {
				$category["items"][] = $item;
				$category["value"] += $item["value"];
			}		
		}	
	}
	unset($category);
	
	foreach ($lines as &$line) {
		$line["value"] = 0;
		$line["categories"] = [];
		foreach ($categories as $category) {
			if ($category["line_id"] == $line["id"] && $category["value"] != 0) {
				$line["categories"][] = $category;
				$line["value"] += $category["value"];
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
	}
	unset($section);
	
	// display data
	foreach ($sections as $section):
		if ($section["id"] < 3) {
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
			foreach ($line["categories"] as $category):
				if ($category["name"] != $line["name"]):
?>
					<tr>
						<td style="font-style:italic"><?= $SPACE16 . $category["name"] ?></td>
						<td style="font-style:italic"><?= number_format((float)$category["value"] / 100, 2, '.', '') ?></td>
					</tr>
<?php
				endif;
				foreach ($category["items"] as $item):
?>
					<tr>
						<td><?= $SPACE16 . $SPACE8 . $item["name"] ?></td>
						<td><?= number_format((float)$item["value"] / 100, 2, '.', '') ?></td>
					</tr>
<?php
				endforeach;
			endforeach;			
		endforeach;
	endforeach;	
?>

</table>

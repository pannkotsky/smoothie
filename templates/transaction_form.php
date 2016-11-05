<form action="new_transaction.php" method="post" class="form-horizontal" role="form">

	<div class="form-group no-empty">
		<label class="control-label col-sm-5">Sum</label>
		<div class="col-sm-7">
			<input class="form-control" name="sum" value="0.00" type="number" step="0.01"/>
		</div>
	</div>
	
	<div class="form-group">
		<label for="debit" class="control-label col-sm-5">Debit account</label>
		<div class="col-sm-7">
			<select class="form-control" id="debit" name="debit">
				<?php
					foreach ($balanceitems as $item) {
						print('<option value="' . $item["id"] . '"');
						if ($item["name"] == "My cash") {
							print('selected');
						}
						print('>' . $item["name"] . '</option>');
					}
				?>
			</select>
		</div>
		<!-- TODO: button to add account-->
	</div>
	
	<div class="form-group">
		<label for="credit" class="control-label col-sm-5">Credit account</label>
		<div class="col-sm-7">
			<select class="form-control" id="credit" name="credit">
				<?php
					foreach ($balanceitems as $item) {
						print('<option value="' . $item["id"] . '"');
						if ($item["name"] == "My cash") {
							print('selected');
						}
						print('>' . $item["name"] . '</option>');
					}
				?>
			</select>
		</div>
		<!-- TODO: button to add account-->
	</div>
	
	<div class="form-group">
		<label for="income" class="control-label col-sm-5">Income account</label>
		<div class="col-sm-7">
			<select class="form-control" id="income" name="income">
				<?php
					foreach ($incomeitems as $item) {
						print('<option value="' . $item["id"] . '"');
						print('>' . $item["name"] . '</option>');
					}
				?>
				<option value="NULL" selected>--</option>
			</select>
		</div>
		<!-- TODO: button to add account-->
	</div>
	
	<div class="form-group">
		<label for="type" class="control-label col-sm-5">Type</label>
		<div class="col-sm-7">
			<select class="form-control" id="type" name="type">
				<option value="fact" selected>Fact</option>
				<option value="plan">Plan</option>
			</select>
		</div>
	</div>
	
	<!-- TODO: add date -->
	

    <div class="form-group" id="buttons">
        <button type="submit" class="btn btn-success">Add transaction</button>
        <a href="index.php?view=transactions" class="btn btn-default">Cancel changes</a>
    </div>

</form>

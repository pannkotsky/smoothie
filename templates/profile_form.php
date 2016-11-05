<form action="profile.php" method="post" class="form-horizontal" role="form">

	<div class="form-group no-empty">
		<label class="control-label col-sm-5">Username</label>
		<div class="col-sm-7">
			<?php print('<input class="form-control" name="username" value="' . $user["username"] . '" type="text"/>') ?>
		</div>
	</div>
	
	<div class="form-group no-empty">
		<label class="control-label col-sm-5">Email</label>
		<div class="col-sm-7">
			<?php print('<input class="form-control" name="email" value="' . $user["email"] . '" type="email"/>') ?>
			<p id="notvalid">Email is not valid</p>
		</div>
	</div>	
	
	<div class="form-group">
		<label for="countries" class="control-label col-sm-5">Residency</label>
		<div class="col-sm-7">
			<select class="form-control" id="countries" name="countries">
				<?php
					foreach ($countries as $country) {
						print('<option value="' . $country["code"] . '"');
						if ($country["code"] == $user["residency"]) {
							print('selected');
						}
						print('>' . $country["name"] . '</option>');
					}
				?>
			</select>
		</div>
	</div>
	
	<div class="form-group">
		<label for="currencies" class="control-label col-sm-5">Default currency</label>
		<div class="col-sm-7">
			<select class="form-control" id="currencies" name="currencies">
				<?php
					foreach ($currencies as $currency) {
						print('<option value="' . $currency["code"] . '"');
						if ($currency["code"] == $user["default_currency"]) {
							print('selected');
						}
						print('>' . $currency["name"] . '</option>');
					}
				?>
			</select>
		</div>
	</div>
	
	<div class="form-group"> 
    	<div class="col-sm-12">
      		<div class="checkbox toggler">
        		<label><input name="change_password" value="yes" type="checkbox"/> Change password</label>
      		</div>
    	</div>
  	</div>

	<div class="form-group tohide">
		<label class="control-label col-sm-5">New password</label>
		<div class="col-sm-7">
			<input id="new_password" class="form-control" name="new_password" type="password"/>
		</div>
	</div>

	<div class="form-group tohide">
		<label class="control-label col-sm-5">Repeat new password</label>
		<div class="col-sm-7">
			<input id="confirmation" class="form-control" name="confirmation" type="password"/>
			<p id="dontmatch">Passwords don't match!</p>
		</div>
	</div>


	<div class="form-group no-empty">
		<label class="control-label col-sm-5">Current password</label>
		<div class="col-sm-7">
			<input id="password" class="form-control" name="password" type="password"/>
		</div>
	</div>

    <div class="form-group" id="buttons">
        <button type="submit" class="btn btn-success">Save changes</button>
        <a href="/" class="btn btn-default">Cancel changes</a>
    </div>

</form>

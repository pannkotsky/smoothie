<h1>Welcome to Smoothee!</h1>
<p>Here you'll be able to manage your finance so smart like never before!</p>

<form action="login.php" method="post" class="form-horizontal" role="form">

	<div class="form-group no-empty">
		<label class="control-label col-sm-5">Username</label>
		<div class="col-sm-7">
			<input autofocus id="username" class="form-control" name="username" type="text"/>
		</div>
	</div>
	
	<div class="form-group no-empty">
		<label class="control-label col-sm-5">Password</label>
		<div class="col-sm-7">
			<input class="form-control" name="password" type="password"/>
		</div>
	</div>

    <div class="form-group" id="buttons">
        <button id="demo" type="submit" class="btn btn-success">Log in</button>
    </div>

</form>

<div>
    or <a href="register.php">register</a> for an account
</div>

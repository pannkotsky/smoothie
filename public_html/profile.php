<?php

    // configuration
    require("../includes/config.php");

    $id = $_SESSION["id"];
    $users = query("SELECT * FROM users WHERE id = ?", $id);
    $user = $users[0];
    $username = $user["username"];
    $email = $user["email"];

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        $countries = query("SELECT code, name FROM countries");        
        $currencies = query("SELECT code, name FROM currencies");
        render("profile_form.php", ["title" => "Profile", "user" => $user, "countries" => $countries, "currencies" => $currencies, "username" => $username]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {	
		// check current password
		if (crypt($_POST["password"], $user["hash"]) != $user["hash"])
		{
			apologize("Wrong current password");
		}

		// user wants to change password
		if (isset($_POST["change_password"]) && $_POST["change_password"] == "yes")
		{
			// validate new password
			if (empty($_POST["new_password"]))
			{
				apologize("You must provide your new password.");
			}
			else if ($_POST["new_password"] != $_POST["confirmation"])
			{
				apologize("Your new passwords don't match.");
			}

			// update information in database
			$updatepassword = query("UPDATE users SET hash = ? WHERE id = ?", crypt($_POST["new_password"]), $id);
			if ($updatepassword === false)
			{
				apologize("Password change failed.");
			}
		}

		// username has changed
		if ($_POST["username"] != $username)
		{
		    	// validate submission of username
			if (empty($_POST["username"]))
			{
				apologize("Username can't be blank.");
			}		

			// update information in database
			$updateusername = query("UPDATE users SET username = ? WHERE id = ?", $_POST["username"], $id);
			if ($updateusername === false)
			{
				apologize("Username already exists.");
			}
		}

		// email has changed
		if ($_POST["email"] != $email)
		{
		    	// validate submission of username
			if (empty($_POST["email"]))
			{
				apologize("Email can't be blank.");
			}
	
			else if (strpos($_POST["email"], '@') === false || strpos($_POST["email"], '.') === false)
			{
				apologize("Email is not valid.");
			}

			// update information in database
			$updateemail = query("UPDATE users SET email = ? WHERE id = ?", $_POST["email"], $id);
			if ($updateemail === false)
			{
				apologize("Email already exists.");
			}
		}
		
		// update residency and default currency
		$updateresidency = query("UPDATE users SET residency = ? WHERE id = ?", $_POST["countries"], $id);
		$updatecurrency = query("UPDATE users SET default_currency = ? WHERE id = ?", $_POST["currencies"], $id);

		// redirect to main
		redirect("/");
    }

?>

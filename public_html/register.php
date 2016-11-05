<?php

    // configuration
    require("../includes/config.php");

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // render form
        $countries = query("SELECT code, name FROM countries");        
        $currencies = query("SELECT code, name FROM currencies");        
        render("register_form.php", ["title" => "Register", "countries" => $countries, "currencies" => $currencies]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {
        // validate submission
        if (empty($_POST["username"]))
        {
            apologize("You must provide your username.");
        }
        else if (empty($_POST["email"]))
        {
            apologize("You must provide your email.");
        }
        else if (strpos($_POST["email"], "@") === false || strpos($_POST["email"], ".") === false)
        {
            apologize("Email is not valid.");
        }
        else if (empty($_POST["password"]))
        {
            apologize("You must provide your password.");
        }
		else if ($_POST["password"] != $_POST["confirmation"])
		{
			apologize("Your passwords don't match.");
		}
		
		// insert user to database
		$insert = query("INSERT INTO users (username, hash, email, residency, default_currency) VALUES (?, ?, ?, ?, ?)", $_POST["username"], crypt($_POST["password"]), $_POST["email"], $_POST["countries"], $_POST["currencies"]);
		if ($insert === false)
		{
			apologize("Username or email already exists");
		}
		else
		{
			// log in registered user
			$rows = query("SELECT LAST_INSERT_ID() AS id");
			$_SESSION["id"] = $rows[0]["id"];
			
			// query suggestions for balance items			
			$rows = query("SELECT * FROM defaultBalanceItems");
			// insert items to respective table
			foreach ($rows as $row) {
				query("INSERT INTO balanceItems (user_id, name, category_id, currency) VALUES (?, ?, ?, ?)", $_SESSION["id"], $row["name"], $row["category_id"], $_POST["currencies"]);			
			}
			
			// query suggestions for counterparties
			$rows = query("SELECT * FROM defaultCounterparties");
			// insert items to respective table
			foreach ($rows as $row) {
				query("INSERT INTO counterparties (user_id, name, relation, country) VALUES (?, ?, ?, ?)", $_SESSION["id"], $row["name"], $row["relation"], $_POST["countries"]);			
			}			
						
			// query accounts
			$rows = query("SELECT * FROM balanceItems WHERE category_id IN (69, 70, 71, 73, 75)");
			// insert accounts to user's accounts
			foreach ($rows as $row) {
				query("INSERT INTO accounts (item_id) VALUES (?)", $row["id"]);		
			}
			
			// query income items
			$rows = query("SELECT * FROM defaultIncomeItems");
			// insert items to respective table
			foreach ($rows as $row) {
				query("INSERT INTO incomeItems (user_id, name, line_id, currency) VALUES (?, ?, ?, ?)", $_SESSION["id"], $row["name"], $row["line_id"], $_POST["currencies"]);
			}
			
			// send email to confirm registration
			$rows = query("SELECT * FROM users WHERE id = ?", $_SESSION["id"]);
            $to = $rows[0]["email"];
			$subject = "Registration on smoothee.xyz";
			$txt = "Thank you for joining smoothee.xyz!";
			$headers = FROM;

			$mail_success = mail($to, $subject, $txt, $headers);
			
		   redirect("/");
		}
    }

?>

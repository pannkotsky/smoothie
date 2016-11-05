<?php

    // configuration
    require("../includes/config.php");

    $id = $_SESSION["id"];
    $users = query("SELECT * FROM users WHERE id = ?", $id);
    $user = $users[0];
    $username = $user["username"];

    // if user reached page via GET (as by clicking a link or via redirect)
    if ($_SERVER["REQUEST_METHOD"] == "GET")
    {
        // else render form
        $balanceitems = query("SELECT * FROM balanceItems WHERE user_id = ?", $id);        
        $incomeitems = query("SELECT * FROM incomeItems WHERE user_id = ?", $id);
        $currencies = query("SELECT code, name FROM currencies");
        render("transaction_form.php", ["title" => "New transaction", "user" => $user, "balanceitems" => $balanceitems, "incomeitems" => $incomeitems, "currencies" => $currencies, "username" => $username]);
    }

    // else if user reached page via POST (as by submitting a form via POST)
    else if ($_SERVER["REQUEST_METHOD"] == "POST")
    {	
		// add transaction
		$sum = intval(floatval($_POST["sum"]) * 100);
		if ($_POST["income"] != "NULL") {
			$success = query("INSERT INTO transactions (user_id, sum, debit, credit, income, type) VALUES (?, ?, ?, ?, ?, ?)",
										$id, $sum, $_POST["debit"], $_POST["credit"], $_POST["income"], $_POST["type"]); // TODO: add date
		}
		else {
			$success = query("INSERT INTO transactions (user_id, sum, debit, credit, type) VALUES (?, ?, ?, ?, ?)",
										$id, $sum, $_POST["debit"], $_POST["credit"], $_POST["type"]); // TODO: add date
		}		
		
										
		if ($success === false)
		{
			apologize("Something went wrong. Transaction wasn't added.");
		}

		// update values in balance
		$debit = query("SELECT * FROM balanceItems WHERE id=?", $_POST["debit"])[0];		
		if ($debit["category_id"] < 76) {
			$success = query("UPDATE balanceItems SET value=value+? WHERE id=?", $sum, $_POST["debit"]);
		}
		else {
			$success = query("UPDATE balanceItems SET value=value-? WHERE id=?", $sum, $_POST["debit"]);
		}
		
		if ($success === false)
		{
			apologize("Something went wrong. Debit account wasn't updated.");
		}
		
		$credit = query("SELECT * FROM balanceItems WHERE id=?", $_POST["credit"])[0];
		if ($credit["category_id"] < 76) {
			$success = query("UPDATE balanceItems SET value=value-? WHERE id=?", $sum, $_POST["credit"]);
		}
		else {
			$success = query("UPDATE balanceItems SET value=value+? WHERE id=?", $sum, $_POST["credit"]);
		}		
		
		if ($success === false)
		{
			apologize("Something went wrong. Credit account wasn't updated.");
		}
		
		// update values in income
		if ($_POST["income"] != "NULL") {
			$success = query("UPDATE incomeItems SET value=value+? WHERE id=?", $sum, $_POST["income"]);
		}
		
		
		// redirect to list of transactions
		redirect("index.php?view=transactions");
    }

?>

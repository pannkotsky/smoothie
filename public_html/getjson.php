<?php

    // configuration
    require("../includes/config.php"); 

    $rows = query("SELECT * FROM balanceItems WHERE user_id = ?", $_SESSION["id"]);    
    
	// output accounts as JSON (pretty-printed for debugging convenience)
    header("Content-type: application/json");
    print(json_encode($rows, JSON_PRETTY_PRINT));
?>

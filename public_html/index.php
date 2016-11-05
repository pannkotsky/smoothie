<?php

    // configuration
    require("../includes/config.php"); 

    // prepare data for rendering
    $id = $_SESSION["id"];
    $users = query("SELECT * FROM users WHERE id = ?", $id);
    $username = $users[0]["username"];
    if (isset($_GET["view"]))
    {
    	$view = $_GET["view"];
    }
    else
    {
    	$view = "notifications";
    }
    
    // render main
    render("main.php", ["title" => "Main page", "username" => $username, "view" => $view]);

?>

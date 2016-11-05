<?php

    // configuration
    require("../includes/config.php"); 

    // prepare data for rendering
    $id = $_SESSION["id"];
    $users = query("SELECT * FROM users WHERE id = ?", $id);
    $username = $users[0]["username"];
    
    // render main
    render("forum.php", ["title" => "Forum", "username" => $username]);

?>

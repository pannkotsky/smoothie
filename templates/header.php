<!DOCTYPE html>

<html>

    <head>

        <link rel="icon" type="image/png" href="/img/icon.png">
        <link href="/css/bootstrap.min.css" rel="stylesheet"/>
        <link href="/css/bootstrap-theme.min.css" rel="stylesheet"/>
        <link href="/css/styles.css" rel="stylesheet"/>

        <?php if (isset($title)): ?>
            <title>Sm8thee: <?= htmlspecialchars($title) ?></title>
        <?php else: ?>
            <title>Sm8thee:</title>
        <?php endif ?>

        <script src="/js/jquery-1.11.1.min.js"></script>
        <script src="/js/bootstrap.min.js"></script>
        <script src="/js/scripts.js"></script>
        <script src="/js/Chart.js"></script>

    </head>

    <body>

        <div class="container">

            <header id="top">
                <a href="index.php"><img alt="SMOOTHEE" src="/img/logo.gif"/></a>
                
				<nav class="navbar navbar-default">
				  	<div class="container-fluid">
						<div>
							<ul class="nav navbar-nav">
								<li <?php if (isset($title) and $title == "Main page") {print('class="active"');} ?>><a href="index.php">HOME</a></li>
								<li <?php if (isset($title) and $title == "Forum") {print('class="active"');} ?>><a href="forum.php">FORUM</a></li>
								<li><a href="#">MY BLOG</a></li> 
								<li><a href="#">EDITOR'S BLOG</a></li>
								<li><a href="#">HOW TO USE</a></li>
							</ul>
							<ul class="nav navbar-nav navbar-right profile">
								<?php if (isset($username)): ?>
									<li><a href="profile.php"><span class="glyphicon glyphicon-user"></span><?= ' '.htmlspecialchars($username) ?></a></li>
									<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> Log Out</a></li>
								<?php else: ?>
									<li><a href="register.php"><span class="glyphicon glyphicon-plus-sign"></span> New Smoother</a></li>
									<li><a href="login.php"><span class="glyphicon glyphicon-log-in"></span> Log In</a></li>
								<?php endif ?>
							</ul>
						</div>
				  	</div>
				</nav>                
            </header>

            <div id="middle" class="row">

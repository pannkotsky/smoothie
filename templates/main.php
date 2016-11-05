<aside class="col-md-2">

	<ul class="nav nav-pills nav-stacked">
		<?php 
			$list = ["notifications" => "Notifications",
					"transactions" => "Transactions",
					"profitloss" => "Profit&Loss",
					"cashflow" => "Cashflow",
					"balance" => "Balance",
					"charts" => "Charts"];
			
			foreach ($list as $key => $value)
			{
				if ($view == $key) {
					$active = 'class="active"';	
				} else {
					$active = '';
				}
				print('<li ' . $active . '><a href="index.php?view=' . $key . '">' . $value . '</a></li>');
			}
		?>
	</ul>
	
</aside>

<main class="col-md-10">
	
	<?php require("../templates/main/" . $view . ".php"); ?>

</main> 


/**
 * scripts.js
 *
 * Global JavaScript.
 */


// proceed when document is fully loaded
$(document).ready(function() {
	validate_inputs();
	toggle_with_checkbox();
	$("#dontmatch").hide();
	
	$("form .form-control").keyup(function() {
		validate_inputs();
	});
	
	$(".checkbox.toggler").click(function() {
		toggle_with_checkbox();
		validate_inputs();
	});	
	
	hide_chart();
	$("#toggleChart").val("Display chart");
	$("#toggleChart").click(function() {
		toggle_chart();
	});
	
	$(".nav.navbar-nav li").click(function() {
		$(".nav.navbar-nav li.active").removeClass("active");
		$(this).addClass("active");
	});
})


// check inputs to be valid
function validate_inputs() {	
	check_empty_fields();
	compare_passwords();
	validate_email();
}

// check fields that must be filled necessarily
function check_empty_fields() {
	var empty_exists = false;
	
	$("form .no-empty .form-control").each(function() {
		if ($(this).val() == '') {
			empty_exists = true;
		}	
	});	
	
	if (empty_exists) {
		$(".btn-success").addClass("disabled");
	}
	else {
		$(".btn-success").removeClass("disabled");
	}
}

// compare password and it's confirmation on registration or password change
function compare_passwords() {		
	if ($("#new_password").length && $("#confirmation").length && $(".checkbox.toggler input").prop("checked")) {
		if ($("#new_password").val() != $("#confirmation").val()) {
			$(".btn-success").addClass("disabled");
			$("#dontmatch").show();	
		}
		else {
			$("#dontmatch").hide();
		}
	}
}

// check email fields to contain '@' and '.'
function validate_email() {
	if ($("input[type='email']").length) {		
		if ($("input[type='email']").val().indexOf('@') == -1 || $("input[type='email']").val().indexOf('.') == -1) {
			$(".btn-success").addClass("disabled");
			$("#notvalid").show();
		}
		else {
			$("#notvalid").hide();
		}
	}
}


// show or hide some block depending on checkbox state
function toggle_with_checkbox() {
	if ($(".checkbox.toggler input").prop("checked")) {
		$(".tohide").show().addClass("no-empty");
	}
	else {
		$(".tohide").hide().removeClass("no-empty");
	}
}


// draw bar chart with Chart.js library
function draw_chart(data) {
	$("#myChart").removeClass("hidden");
	$("#myChart").show();	
	var ctx = $("#myChart").get(0).getContext("2d");	
	var myLineChart = new Chart(ctx).Bar(data, {});
}

// hide chart
function hide_chart() {
	$("#myChart").addClass("hidden");
	$("#myChart").hide();
}

// toggle chart
function toggle_chart() {		
	if ($("#myChart").hasClass("hidden")) {
		getAccounts(draw_chart);
		$("#toggleChart").text("Hide chart");
	}
	else {
		hide_chart();
		$("#toggleChart").text("Display sample chart");
	}
}


// get information from database using AJAX technique
function getAccounts(cb) {
    $.getJSON("getjson.php", {})
    .done(function(data, textStatus, jqXHR) {
        // call callback function with formatted data from getjson.php
        cb(json_to_chartdata(data));        
    })
    .fail(function(jqXHR, textStatus, errorThrown) {
        // log error to browser's console
        console.log(errorThrown.toString());
    });
}


// take json array and return object formatted for chart layout
function json_to_chartdata(json) {
	/*
	json example:
	[
		{
			id: 1,
			user_id: 1,
			name: "My cash",
			balance: 15600,
			currency: "UAH",
			bank: NULL,
			line_id: 1
		},
		{
			id: 2,
			user_id: 1,
			name: "Moneybox",
			balance: 18800,
			currency: "UAH",
			bank: NULL,
			line_id: 1
		}
	]
	
	result example:
	{
		labels: ["January", "February", "March", "April", "May", "June", "July"],
		datasets: [
			{
				label: "My First dataset",
				fillColor: "rgba(220,220,220,0.2)",
				strokeColor: "rgba(220,220,220,1)",
				pointColor: "rgba(220,220,220,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(220,220,220,1)",
				data: [65, 59, 80, 81, 56, 55, 40]
			},
			{
				label: "My Second dataset",
				fillColor: "rgba(151,187,205,0.2)",
				strokeColor: "rgba(151,187,205,1)",
				pointColor: "rgba(151,187,205,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(151,187,205,1)",
				data: [28, 48, 40, 19, 86, 27, 90]
			}
		]
	}
	*/
	
	var result = {
		labels: [],
		datasets: [
			{
				label: "Current balance",
				fillColor: "rgba(220,220,220,0.2)",
				strokeColor: "rgba(220,220,220,1)",
				pointColor: "rgba(220,220,220,1)",
				pointStrokeColor: "#fff",
				pointHighlightFill: "#fff",
				pointHighlightStroke: "rgba(220,220,220,1)",
				data: []	
			}
		]	
	};
	
	for (var i = 0, len = json.length; i < len; i++) {
		if (json[i]["value"] != 0) {
			result["labels"].push(json[i]["name"]);
			result["datasets"][0]["data"].push((json[i]["value"] / 100).toFixed(2));
		}				
	}

	return result;
}

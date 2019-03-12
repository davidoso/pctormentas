var display;
var last_mode_id = -1;

function flipTo(digit, n) {
	var current = digit.attr('data-num');
	digit.attr('data-num', n);
	digit.find('.front').attr('data-content', current);
	digit.find('.back, .under').attr('data-content', n);
	digit.find('.flap').css('display', 'block');
	setTimeout(function() {
		digit.find('.base').text(n);
		digit.find('.flap').css('display', 'none');
	}, 350);
}

function jumpTo(digit, n) {
	digit.attr('data-num', n);
	digit.find('.base').text(n);
}

function updateGroup(group, n, flip) {
	var digit1 = $('.ten' + group);
	var digit2 = $('.' + group);
	n = String(n);
	if(n.length == 1) n = '0' + n;
	var num1 = n.substr(0, 1);
	var num2 = n.substr(1, 1);
	if(digit1.attr('data-num') != num1) {
		if(flip) flipTo(digit1, num1);
		else jumpTo(digit1, num1);
	}
	if(digit2.attr('data-num') != num2) {
		if(flip) flipTo(digit2, num2);
		else jumpTo(digit2, num2);
	}
}

function setTime(flip) {
	// var t = new Date();
	t.setSeconds(t.getSeconds() + 1);
	updateGroup('hour', t.getHours(), flip);
	updateGroup('min', t.getMinutes(), flip);
	updateGroup('sec', t.getSeconds(), flip);
}

function updateAlerta() {
	$('body').css('cursor', 'wait');
	$.ajax({
		type: "post",
		dataType: "json",
		url: "index.php/Strikeview/updateAlerta",
		success: function(data) {
			// console.log("Datatype: " + typeof(data)); // Data returned is an object
			// CHANGE SETTING: Comment these
			console.log("Last update (browser's time): " + new Date());
			console.log(data);
			console.log("------------------------------");

			// If the record is the same keep the stopwatch running in the client's browser (Update is not done to avoid a sudden change, e.g. from 01:20:30 to 01:20:50)
			// The whole page (including the stopwatch time) is only updated when a new alert (i.e. record) is retrieved
			if(last_mode_id != data.mode_id) {
				// e.g. t = new Date(2000, 1, 1, 10, 20, 0);
				t = new Date(data.stopwatch[0], data.stopwatch[1], data.stopwatch[2], data.stopwatch[3], data.stopwatch[4], data.stopwatch[5]);
				$('#lbl-alert').html(data.alert);
				$('#lbl-description').html(data.description);
				$('#lbl-start').html(data.start);
				$('#img-alarm').attr("src", data.imagepath);
				$('#img-alarm').attr("alt", data.alert);
				$('#img-alarm').attr("title", data.alert);
				$('#my-footer').css("background-color", data.color);
			}

			last_mode_id = data.mode_id;
			display = data.alert_exists ? "block" : "none";
			$('#my-footer').css("display", display);
			$('body').css('cursor', 'auto');
		},		// AJAX success
		error: function() {
			console.log("¡Error! No se pudo consultar la base de datos");
			$('body').css('cursor', 'auto');
		}		// AJAX error
	});			// AJAX
}

$(document).ready(function() {
	// onload event attribute in <body> is used instead because it seems to be faster to call the webservice and update the page elements
	// updateAlerta();

	setInterval(function() {
		updateAlerta();
	}, 60000);			// Call webservice every minute

	setTime(false);

	setInterval(function() {
		setTime(true);
	}, 1000);			// Update flipclock every second
});
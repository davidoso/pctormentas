var t;

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

$(document).ready(function() {
	t = new Date(2018, 11, 24, 23, 59, 50);

	setInterval(function() {
		$('body').css('cursor', 'wait');
		console.log(Math.random());

		$.ajax({
			type: "get",
			dataType: "json",
			url: "index.php/Strikeview/updateAlerta",
			success: function(data) {
				console.log(typeof(data));
				$('#lbl-alert').html(data.alert);
				$('#lbl-description').html(data.description);
				$('#lbl-start').html(data.start);
				$('#img-alarm').attr("src", data.imagepath);
				$('#img-alarm').attr("alt", data.alert);
				$('#img-alarm').attr("title", data.alert);
				$('#my-footer').css("background-color", data.color);
				console.log(data);
				$('body').css('cursor', 'auto');

			},
			error: function() {
				console.log("Error! switchSelectCapa() failed. Search columns could not be retrieved");
				$('body').css('cursor', 'auto');
			}
		}); // AJAX
		// AJAX CON WEBSERVICE O LLAMADA A MODELO
	}, 5000);		// Call webservice every minute


	setTime(false);
	setInterval(function() {
		setTime(true);
	}, 1000);		// Update flipclock every second
	setInterval(function() {
		console.log(Math.random());
		// AJAX CON WEBSERVICE O LLAMADA A MODELO
	}, 60000);		// Call webservice every minute
});
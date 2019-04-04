/* Almacena "block" o "none" cuando la llamada AJAX retorne sin errores cada minuto para mostrar u ocultar my-footer div
Esto controla los casos cuando en un minuto determinado no haya alerta y al siguiente aparezca o viceversa */
var display;
/* Valor default para comparar registro obtenido al cargar la página con el anterior y cada minuto mediante la llamada AJAX
Si es diferente actualiza los elementos. Los valores -2 y -1 corresponden cuando no hay alerta o no esté en el rango [1-3] */
var last_mode_id = 0;

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
		data: {"origin": origin},		// Variable set in <head> while PHP loads the page
		url: "index.php/Strikeview/updateAlerta",
		success: function(data) {
			// console.log("Datatype: " + typeof(data)); // Data returned is an object
			// CHANGE SETTING: Comment these
			console.log("Last update (browser's time): " + new Date());
			console.log(data);
			// console.log("------------------------------");

			// If the database record is the same as last call's one, keep the stopwatch running in the client's browser
			// HTML DOM elements are not updated to avoid a sudden change in the stopwatch time, e.g. from 01:20:33 to 01:20:55
			// The whole page (including the stopwatch time) is only updated when a new alert (i.e. a record with a different mode_ide) is retrieved every minute
			if(last_mode_id != data.mode_id) {
				// e.g. t = new Date(year, month, day, hour, minute, second);
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
		},		// AJAX success function
		error: function() {
			console.log("¡Error! No se pudo consultar la base de datos");
			last_mode_id = 0;
			t = new Date();
			$('#lbl-alert').html("No se pudo consultar la base de datos");
			$('#lbl-description').html("Intente de nuevo más tarde. Si el error persiste, contacte a TI");
			$('#lbl-start').html("");
			$('#img-alarm').attr("src", "images/alarm-no.png");
			$('#img-alarm').attr("alt", "No se pudo consultar la base de datos");
			$('#img-alarm').attr("title", "No se pudo consultar la base de datos");
			$('#my-footer').css("background-color", "#929395");
			$('#my-footer').css("display", "none");
			$('body').css('cursor', 'auto');
		}		// AJAX error function
	});			// AJAX
}

$(document).ready(function() {
	updateAlerta();		// Call webservice and update the HTML DOM as soon as the page loads (onload event attribute in <body> could be used too)

	setInterval(function() {
		updateAlerta();
	}, 60000);			// Call webservice every minute

	setTime(false);

	setInterval(function() {
		setTime(true);
	}, 1000);			// Update flipclock every second
});
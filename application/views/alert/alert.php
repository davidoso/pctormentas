<!DOCTYPE html>
<html lang="es-MX">
<head>
    <?php $this->load->view('alert/head'); ?>
</head>
<body>
    <div class="container">
	    <div class="col-sm-12 p-top align-center">
			<h1 class="title-main text-black" id="lbl-alert">Alerta roja</h1>
		</div>
		<div class="col-sm-12 align-center">
	        <h2 class="title-sec text-black" id="lbl-description">Peligro: actividad eléctrica dentro del rango de los 0 a 8km</h2>
		</div>
		<div class="col-sm-12 align-center">
	        <h2 class="title-sec text-black" id="lbl-start">Hora de inicio: 14:00:54</h2>
		</div>
		<div class="col-sm-12 p-top align-center">
			<img id="img-alarm" class="img-warning" src="images/alarm-1-red.png" alt="Alerta roja" title="Alerta roja">
		</div>
	    <div class="my-footer">
		    <div class="row">
			    <div class="my-row col-sm-12">
				    <h1 id="lbl-length">Duración de la alerta:</h1>
				    <div class="flipclock">
                        <div class="digit tenhour">
                            <span class="base"></span>
                            <div class="flap over front"></div>
                            <div class="flap over back"></div>
                            <div class="flap under"></div>
                        </div>

                        <div class="digit hour">
                            <span class="base"></span>
                            <div class="flap over front"></div>
                            <div class="flap over back"></div>
                            <div class="flap under"></div>
                        </div>

                        <div class="digit tenmin">
                            <span class="base"></span>
                            <div class="flap over front"></div>
                            <div class="flap over back"></div>
                            <div class="flap under"></div>
                        </div>

                        <div class="digit min">
                            <span class="base"></span>
                            <div class="flap over front"></div>
                            <div class="flap over back"></div>
                            <div class="flap under"></div>
                        </div>

                        <div class="digit tensec">
                            <span class="base"></span>
                            <div class="flap over front"></div>
                            <div class="flap over back"></div>
                            <div class="flap under"></div>
                        </div>

                        <div class="digit sec">
                            <span class="base"></span>
                            <div class="flap over front"></div>
                            <div class="flap over back"></div>
                            <div class="flap under"></div>
                        </div>
				    </div>
		        </div>
	        </div>
        </div>
    </div>
</body>
</html>
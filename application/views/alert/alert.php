<!DOCTYPE html>
<html lang="es-MX">
<head>
    <?php $this->load->view('alert/head'); ?>
</head>
<body>
    <div class="container">
	    <div class="col-sm-12 p-top align-center">
			<h1 class="title-main text-black" id="lbl-alert"><?php echo $alert; ?></h1>
		</div>
		<div class="col-sm-12 align-center">
	        <h2 class="title-sec text-black" id="lbl-description"><?php echo $description; ?></h2>
		</div>
		<div class="col-sm-12 align-center">
	        <h2 class="title-sec text-black" id="lbl-start"><?php echo $start; ?></h2>
		</div>
		<div class="col-sm-12 p-top align-center">
			<img id="img-alarm" class="img-warning" src="<?php echo $imagepath; ?>" alt="<?php echo $alert; ?>" title="<?php echo $alert; ?>">
        </div>

        <?php if($alert_exists) $this->load->view('alert/flipclock', $color); ?>
    </div>
</body>
</html>
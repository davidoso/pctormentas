<!DOCTYPE html>
<html lang="es-MX">
<head>
    <?php
        // Concatenate each element of the datetime array to a string, e.g. t = new Date(2000, 1, 1, 10, 20, 0);
        $start_stopwatch = $stopwatch[0] . ', ' . $stopwatch[1] . ', ' . $stopwatch[2] . ', ' . $stopwatch[3] . ', ' . $stopwatch[4] . ', ' . $stopwatch[5];
        $data = array('start_stopwatch' => $start_stopwatch);
        $this->load->view('alert/head', $data);
    ?>
</head>
<body onload="updateAlerta()">
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
        <?php
            // Show or hide my-footer div that displays stopwatch
            $display = ($alert_exists ? 'block' : 'none');
            $data = array('display' => $display, 'color' => $color);
            $this->load->view('alert/flipclock', $data);
        ?>
    </div>
</body>
</html>
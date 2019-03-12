<!DOCTYPE html>
<html lang="es-MX">
<head>
    <?php $this->load->view('home/head'); ?>
</head>
<body class="bg">
    <div class="container1">
        <div class="row justify-content-center">
            <p class="app-img"><img class="img-responsive" src="images/logo_peco.png"></p>
            <div class="vl"></div>
            <p class="app-title">ALERTA DE TORMENTAS</p>
        </div>
    </div>
    <div class="container2">
        <div class="row" style="margin: 0px;">
            <div class="col-lg-4 col-md-4 col-sm-4">
                <a class="thumbnail darken" href="index.php/Strikeview/mina/" onmouseover="over('mina')" onmouseout="out('mina')">
                    <img class="img-responsive op" src="images/op-mina.jpg" width="100%;" alt="Mina">
                    <div id="mina" class="text-centered">Mina</div>
                </a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <a class="thumbnail darken" href="index.php/Strikeview/pelet/" onmouseover="over('peletizadora')" onmouseout="out('peletizadora')">
                    <img class="img-responsive op" src="images/op-pelet.jpg" width="100%;" alt="Peletizadora">
                    <div id="peletizadora" class="text-centered">Peletizadora</div>
                </a>
            </div>
            <div class="col-lg-4 col-md-4 col-sm-4">
                <a class="thumbnail darken" href="index.php/Strikeview/presas/" onmouseover="over('presas')" onmouseout="out('presas')">
                    <img class="img-responsive op" src="images/op-presas.jpg" width="100%;" alt="Presas">
                    <div id="presas" class="text-centered">Presas</div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
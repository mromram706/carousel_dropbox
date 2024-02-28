<?php
require_once __DIR__ . '/vendor/autoload.php';
use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;

$token = $_GET['token'];

$app = new DropboxApp("xxxx", "xxxx", $token);
$dropbox = new Dropbox($app);
$listFolderContents = $dropbox->listFolder("/images");
$items = $listFolderContents->getItems();

$all = $items->all();

$imgs = [];
foreach ($all as $key => $value) {
    $imgs[] = $value->getDataProperty('path_lower');
}
sort($imgs);
$count = count($imgs);
$links = [];
$alts = [];

foreach ($imgs as $img) {
    $temporaryLink = $dropbox->getTemporaryLink($img);
    $links[] = $temporaryLink->getLink();

    $alts[] = substr(rtrim($img, ".png"), strpos($img, "_") + 1);
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Bootstrap 5 Carousel</title>

    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.dark.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.1.0/mdb.min.js"></script>


    <style>

        #myCarousel {
            width: 100vw;
            height: 100vh;
        }

        .container {
            max-width: 100vw;
            overflow-x: hidden;
        }

        .carousel {
            max-height: 100vh;
            overflow: hidden;
        }

        .carousel-item img {
            width: 100%;
            height: auto;
            object-fit: cover;
        }


    </style>
</head>
<body>
<div class="container">
    <div>
        <div id="myCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel">

            <div class="carousel-indicators">
                <?php
                for ($i = 0; $i < $count; $i++) {
                    $isActive = ($i == 0) ? 'active' : '';
                    echo "<button type='button' data-bs-target='#myCarousel' data-bs-slide-to='$i' class='$isActive' aria-label='Slide " . ($i + 1) . "'></button>\n";
                }
                ?>
            </div>

            <div class="carousel-inner">
                <?php
                for ($i = 0; $i < $count; $i++) {
                    $activeClass = ($i == 0) ? 'active' : ''; // Establecer la clase 'active' para el primer elemento
                    echo "<div class='carousel-item $activeClass'>\n";
                    echo "<div style='height: 100vh; display: flex; align-items: center; justify-content: center;'>\n";
                    echo "<img src='$links[$i]' alt='$alts[$i]' class='d-block img-fluid' style='max-height: 100vh; object-fit: scale-down;'>\n";
                    echo "</div>\n";
                    echo "</div>\n";
                }
                ?>
            </div>

            <a class="carousel-control-prev" href="#myCarousel" role="button" data-bs-slide="prev">
                <i class="material-icons">keyboard_arrow_left</i>
            </a>

            <a class="carousel-control-next" href="#myCarousel" role="button" data-bs-slide="next">
                <i class="material-icons">keyboard_arrow_right</i>
            </a>

        </div>
    </div>

</div>
</body>
</html>

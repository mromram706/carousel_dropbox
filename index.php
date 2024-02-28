<?php
require_once __DIR__ . '/vendor/autoload.php';
use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;

$app = new DropboxApp("xxxx", "xxx");
$dropbox = new Dropbox($app);

$authHelper = $dropbox->getAuthHelper();

$callbackUrl = "https://daw.free.nf/carousel_dropbox/dropbox_auth.php";

if (isset($_GET['code'])) {
    $code = $_GET['code'];
    try {
        $accessToken = $authHelper->getAccessToken($code, null, $callbackUrl)->getToken();

        header('Location: https://daw.free.nf/carousel_dropbox/carousel.php?token=' . urlencode($accessToken));
        exit;
    } catch (Exception $e) {
        die("Error obteniendo el token de acceso: " . $e->getMessage());
    }
} else {
    $authUrl = $authHelper->getAuthUrl($callbackUrl);
    ?>

    <!DOCTYPE html>
    <html lang="es">
    <head>
        <meta charset="UTF-8">
        <title>Iniciar sesión con Dropbox</title>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <style>
        </style>
    </head>
    <body>
<h1>
    Caruosel en dropbox inicia sesión
</h1>
    <a class="btn btn-primary" href="<?php echo htmlspecialchars($authUrl); ?>">Iniciar sesión con Dropbox</a>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.2/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    </body>
    </html>
    <?php
    exit;
}
?>

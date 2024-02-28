<?php
require_once __DIR__ . '/vendor/autoload.php';
use Kunnu\Dropbox\Dropbox;
use Kunnu\Dropbox\DropboxApp;

$app = new DropboxApp("xxx", "xxx");
$dropbox = new Dropbox($app);
$authHelper = $dropbox->getAuthHelper();

$callbackUrl = "https://daw.free.nf/carousel_dropbox/dropbox_auth.php";

if (isset($_GET['code'])) {
    $code = $_GET['code'];
    try {
        $accessToken = $authHelper->getAccessToken($code, null, $callbackUrl)->getToken();
        if ($accessToken) {
            header('Location: https://daw.free.nf/carousel_dropbox/carousel.php?token=' . $accessToken);
            exit;
        } else {

            throw new Exception("No se pudo obtener el token de acceso.");
        }
    } catch (Exception $e) {

        echo "Error obteniendo el token de acceso: " . $e->getMessage();
        exit;
    }
} else {
    $authUrl = $authHelper->getAuthUrl($callbackUrl);
    header('Location: ' . $authUrl);
    exit;
}
?>

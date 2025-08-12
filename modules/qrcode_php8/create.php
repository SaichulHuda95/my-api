<?php

require_once "vendor/autoload.php";

use chillerlan\QRCode\QRCode;
use chillerlan\QRCode\QROptions;

Flight::route('POST /qrcode/create', function () {

    $url = $_POST['url'] ?? '';

    if (empty($url)) {
        Flight::json([
            'code' => 400,
            'message' => 'Field url tidak boleh kosong'
        ], 400);
        return;
    }


    $options = new QROptions([
        'version'    => 15,
        'outputType' => QRCode::OUTPUT_IMAGE_PNG,
        'eccLevel'   => QRCode::ECC_L,
        'scale'      => 5,
    ]);

    $qr = new QRCode($options);
    $result = $qr->render($url);

    Flight::json([
        'code' => 200,
        'message' => 'Success',
        'image' => $result
    ]);
});

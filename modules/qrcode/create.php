<?php
//route untuk ambil data dari body request json
Flight::route('POST /qrcode/create', function () {
    require_once "phpqrcode/qrlib.php";

    $data = Flight::request()->data;

    if (empty($data->url)) {
        Flight::json([
            'code' => 400,
            'message' => 'Field url tidak boleh kosong'
        ], 400);
        return;
    }

    $url = $data->url;
    $logo = $data->logo;

    $barcode = $url;
    ob_start();
    QRcode::png($barcode, null, QR_ECLEVEL_H, 10);
    $imageData = ob_get_clean();
    $base64Image = 'data:image/png;base64,' . base64_encode($imageData);

    $response = [
        'code' => 200,
        'message' => 'QR Code berhasil dibuat.',
        'image' => $base64Image
    ];

    Flight::json($response);
});

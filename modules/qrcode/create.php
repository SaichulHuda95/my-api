<?php
Flight::route('POST /qrcode_php7/create', function () {
    require_once "phpqrcode/qrlib.php";

    $url = $_POST['url'] ?? '';

    if (empty($url)) {
        Flight::json([
            'code' => 400,
            'message' => 'Field url tidak boleh kosong'
        ], 400);
        return;
    }

    // Generate QR langsung ke memori
    ob_start();
    QRcode::png($url, null, QR_ECLEVEL_H, 10);
    $qrData = ob_get_clean();

    $QR = imagecreatefromstring($qrData);

    // Cek logo
    if (!empty($_FILES['logo']) && $_FILES['logo']['error'] === UPLOAD_ERR_OK) {
        $logoTmpPath = $_FILES['logo']['tmp_name'];
        $logoImg = @imagecreatefromstring(file_get_contents($logoTmpPath));

        if ($logoImg) {
            $QR_width = imagesx($QR);
            $QR_height = imagesy($QR);

            $logo_width = imagesx($logoImg);
            $logo_height = imagesy($logoImg);

            $logo_qr_width = $QR_width / 5;
            $scale = $logo_width / $logo_qr_width;
            $logo_qr_height = $logo_height / $scale;

            $from_width = ($QR_width - $logo_qr_width) / 2;

            imagecopyresampled(
                $QR,
                $logoImg,
                (int) $from_width,
                (int) $from_width,
                0,
                0,
                (int) $logo_qr_width,
                (int) $logo_qr_height,
                (int) $logo_width,
                (int) $logo_height
            );
        }
    }

    // Encode gambar ke base64
    ob_start();
    imagepng($QR);
    $imageData = ob_get_clean();

    $base64Image = 'data:image/png;base64,' . base64_encode($imageData);

    Flight::json([
        'code' => 200,
        'message' => 'Success',
        'image' => $base64Image
    ]);
});

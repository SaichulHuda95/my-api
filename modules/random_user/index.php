<?php
Flight::route('GET /random-user/get-user', function () {
    $names = ["Budi", "Andi", "Siti", "Dewi", "Rizky", "Agus", "Rina", "Tina", "Joko", "Lina", "Eka", "Fajar", "Hana", "Indra", "Jihan"];
    $domains = ["gmail.com", "yahoo.com", "outlook.com"];

    $name = $names[array_rand($names)];
    $email = strtolower($name) . rand(100, 999) . "@" . $domains[array_rand($domains)];

    $data = [
        "name" => $name,
        "email" => $email,
        "phone" => "+62" . rand(8000000000, 8999999999)
    ];

    Flight::json([
        "code" => 200,
        "message" => "OK",
        "data" => $data
    ]);
});

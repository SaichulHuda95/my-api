<?php
require_once 'flight/Flight.php';

Flight::route('GET /', function () {
    Flight::json([
        'response_code' => '00',
        'response_message' => 'API ready'
    ]);
});

// Load semua routes dari modules/*
foreach (glob("modules/*/*.php") as $file) {
    require_once $file;
}

Flight::start();

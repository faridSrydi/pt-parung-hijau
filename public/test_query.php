<?php
require realpath(__DIR__ . '/../vendor/autoload.php');
$bootstrap = require realpath(__DIR__ . '/../system/bootstrap.php');
$app = config('Config\App');
$app->baseURL = 'http://localhost/';
require realpath(__DIR__ . '/../app/Config/Paths.php');

$db = \Config\Database::connect();
$alamatModel = new \App\Models\AlamatPengirimanModel();
print_r($alamatModel->where('user_id', 5)->findAll());

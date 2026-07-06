<?php
require realpath(__DIR__ . '/../vendor/autoload.php');
$bootstrap = require realpath(__DIR__ . '/../system/bootstrap.php');

$app = config('Config\App');
$app->baseURL = 'http://localhost/';
require realpath(__DIR__ . '/../app/Config/Paths.php');

$db = \Config\Database::connect();
$alamatModel = new \App\Models\AlamatPengirimanModel();
$data = [
    'user_id' => 3, // assume 3 is user ID
    'recipient_name' => 'Test',
    'phone' => '123456',
    'address_line' => 'Alamat test',
    'is_default' => 1
];

if ($alamatModel->insert($data) === false) {
    print_r($alamatModel->errors());
} else {
    echo "Success insert. DB entries:\n";
    print_r($alamatModel->findAll());
}

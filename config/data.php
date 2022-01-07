<?php

// Getting admin data from json file
$file = file_get_contents('config/adminData.json');

$data = json_decode($file, true);

// Admin data
return [
    'name' => $data['name'],
    'email' => $data['email'],
    'password' => $data['password'],
    'bio' => $data['bio'],
    'ava' => $data['ava'],
    'background' => $data['background']
];
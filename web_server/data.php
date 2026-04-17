<?php
header('Content-Type: application/json');

$data = [
    'nama' => 'Darrel',
    'umur' => 20,
    'kelamin' => 'Laki-laki',
    'pekerjaan' => 'Web Developer',
    'lokasi' => 'Jakarta'
];

echo json_encode($data);
?>
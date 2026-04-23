<?php
return [
    '/' => function () {
        require __DIR__ . '/../views/home.php';
    },
    '/api/profile' => function () {
        header('Content-Type: application/json');

        echo json_encode([
            'nama' => env('PROFILE_NAME', 'Budi'),
            'pekerjaan' => env('PROFILE_JOB', 'Web Developer'),
            'lokasi' => env('PROFILE_LOCATION', 'Jakarta'),
        ]);
    },
];

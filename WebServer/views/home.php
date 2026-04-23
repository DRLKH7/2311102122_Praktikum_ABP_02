<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars(env('APP_NAME', 'AjaxProfil')) ?></title>
    <link rel="stylesheet" href="/style.css">
</head>
<body>
    <div class="card">
        <h1><?= htmlspecialchars(env('APP_NAME', 'AjaxProfil')) ?></h1>
        <p>Server PHP ini memiliki route JSON, public asset, env, dan routing sederhana.</p>

        <button id="tampilkanBtn">Tampilkan Profil</button>
        <div id="hasil-profil">Klik tombol untuk melihat data.</div>
        <div class="note">Data diambil dari <code>/api/profile</code> tanpa reload halaman.</div>
    </div>

    <script src="/app.js" defer></script>
</body>
</html>

<?php
session_start();
include 'function.php';

// Data mahasiswa default
$mahasiswa = [
    ["nama" => "Ahmad Fauzi Rahman", "nim" => "2311102122", "tugas" => 85, "uts" => 80, "uas" => 88],
    ["nama" => "Siti Nurhaliza Putri", "nim" => "2311102123", "tugas" => 90, "uts" => 85, "uas" => 92],
    ["nama" => "Budi Santoso Wijaya", "nim" => "2311102124", "tugas" => 75, "uts" => 70, "uas" => 78],
    ["nama" => "Maya Sari Dewi", "nim" => "2311102125", "tugas" => 95, "uts" => 88, "uas" => 91],
    ["nama" => "Rizki Pratama", "nim" => "2311102126", "tugas" => 60, "uts" => 65, "uas" => 70]
];

// Tambah data dari session jika ada
if (isset($_SESSION['mahasiswa_baru'])) {
    $mahasiswa = array_merge($mahasiswa, $_SESSION['mahasiswa_baru']);
}

// Urutkan data mahasiswa berdasarkan NIM
usort($mahasiswa, function($a, $b) {
    return strcmp($a['nim'], $b['nim']);
});

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tambah'])) {
    $nama = trim($_POST['nama']);
    $nim = trim($_POST['nim']);
    $tugas = (int)$_POST['tugas'];
    $uts = (int)$_POST['uts'];
    $uas = (int)$_POST['uas'];

    // Validasi input
    $errors = [];

    if (empty($nama) || strlen($nama) < 3) {
        $errors[] = "Nama harus diisi minimal 3 karakter";
    }

    if (empty($nim) || !preg_match('/^[0-9]{9,12}$/', $nim)) {
        $errors[] = "NIM harus berupa angka 9-12 digit";
    }

    // Cek NIM duplikat
    foreach ($mahasiswa as $mhs) {
        if ($mhs['nim'] == $nim) {
            $errors[] = "NIM sudah terdaftar";
            break;
        }
    }

    if ($tugas < 0 || $tugas > 100 || $uts < 0 || $uts > 100 || $uas < 0 || $uas > 100) {
        $errors[] = "Nilai harus antara 0-100";
    }

    if (empty($errors)) {
        $mahasiswa_baru = ["nama" => $nama, "nim" => $nim, "tugas" => $tugas, "uts" => $uts, "uas" => $uas];

        // Simpan ke session
        if (!isset($_SESSION['mahasiswa_baru'])) {
            $_SESSION['mahasiswa_baru'] = [];
        }
        $_SESSION['mahasiswa_baru'][] = $mahasiswa_baru;
        $mahasiswa[] = $mahasiswa_baru;

        $_SESSION['success_message'] = "Data mahasiswa <strong>$nama</strong> berhasil ditambahkan!";
        $_SESSION['form_reset'] = true;
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    } else {
        $_SESSION['error_message'] = implode("<br>", $errors);
        header('Location: ' . $_SERVER['PHP_SELF']);
        exit;
    }
}

// Hitung statistik
$total = 0;
$max = 0;
$lulus = 0;
$tidak_lulus = 0;
$jumlah = count($mahasiswa);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Penilaian Mahasiswa</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css">

    <header class="header bg-primary text-white py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10 text-center">
                    <h1 class="display-4 fw-bold mb-3">Sistem Penilaian Mahasiswa</h1>
                    <p class="lead mb-0">Sistem terintegrasi untuk mengelola dan menampilkan hasil penilaian akademik mahasiswa</p>
                </div>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="card shadow-lg border-secondary bg-dark text-light border-1">
            <div class="card-header bg-dark text-light border-secondary">
                <h3 class="card-title mb-0">
                    <i class="bi bi-person-plus-fill me-2"></i>
                    Tambah Data Mahasiswa
                </h3>
            </div>
            <div class="card-body bg-dark text-light">
                <?php
                if (isset($_SESSION['success_message'])) {
                    // Tampilkan sekali, lalu hapus agar tidak muncul setelah refresh
                    echo '<div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>' . $_SESSION['success_message'] . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>';
                    unset($_SESSION['success_message']);
                    unset($_SESSION['form_reset']);
                }
                if (isset($_SESSION['error_message'])) {
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>' . $_SESSION['error_message'] . '
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>';
                    unset($_SESSION['error_message']);
                }
                ?>

                <form method="POST" class="row g-3" id="mahasiswaForm">
            <div class="col-md-6">
                <label for="nama" class="form-label fw-bold">Nama Lengkap:</label>
                <input type="text" id="nama" name="nama" class="form-control" required placeholder="Masukkan nama lengkap" minlength="3" value="<?= isset($_POST['nama']) && !$form_reset ? htmlspecialchars($_POST['nama']) : '' ?>">
            </div>

            <div class="col-md-6">
                <label for="nim" class="form-label fw-bold">NIM:</label>
                <input type="text" id="nim" name="nim" class="form-control" required placeholder="Masukkan NIM (9-12 digit)" pattern="[0-9]{9,12}" value="<?= isset($_POST['nim']) && !$form_reset ? htmlspecialchars($_POST['nim']) : '' ?>">
                <div class="form-text">Format: 9-12 digit angka</div>
            </div>

            <div class="col-md-4">
                <label for="tugas" class="form-label fw-bold">Nilai Tugas:</label>
                <input type="number" id="tugas" name="tugas" class="form-control" min="0" max="100" required placeholder="0-100" value="<?= isset($_POST['tugas']) && !$form_reset ? $_POST['tugas'] : '' ?>" oninput="calculatePreview()">
            </div>

            <div class="col-md-4">
                <label for="uts" class="form-label fw-bold">Nilai UTS:</label>
                <input type="number" id="uts" name="uts" class="form-control" min="0" max="100" required placeholder="0-100" value="<?= isset($_POST['uts']) && !$form_reset ? $_POST['uts'] : '' ?>" oninput="calculatePreview()">
            </div>

            <div class="col-md-4">
                <label for="uas" class="form-label fw-bold">Nilai UAS:</label>
                <input type="number" id="uas" name="uas" class="form-control" min="0" max="100" required placeholder="0-100" value="<?= isset($_POST['uas']) && !$form_reset ? $_POST['uas'] : '' ?>" oninput="calculatePreview()">
            </div>

            <div class="col-12">
                <div class="preview-section alert alert-info">
                    <h5 class="alert-heading">Preview Nilai Akhir</h5>
                    <p class="mb-1">Nilai: <strong><span id="previewNilai">-</span></strong></p>
                    <p class="mb-1">Grade: <strong><span id="previewGrade">-</span></strong></p>
                    <p class="mb-0">Status: <strong><span id="previewStatus">-</span></strong></p>
                </div>
            </div>

            <div class="col-12">
                <div class="form-actions d-flex gap-2">
                    <button type="submit" name="tambah" class="btn btn-primary flex-fill">Tambah Mahasiswa</button>
                    <button type="button" onclick="resetForm()" class="btn btn-secondary">Reset Form</button>
                </div>
                </div>
            </div>
        </div>

        <div class="card shadow-lg border-secondary bg-dark text-light border-1 mt-4">
            <div class="card-header bg-dark text-light border-secondary">
                <h3 class="card-title mb-0">
                    <i class="bi bi-table me-2"></i>
                    Data Mahasiswa (<?= $jumlah ?> mahasiswa)
                </h3>
            </div>
            <div class="card-body bg-dark text-light">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-dark">
                            <tr>
                                <th>Nama</th>
                                <th>NIM</th>
                                <th>Tugas</th>
                                <th>UTS</th>
                                <th>UAS</th>
                                <th>Nilai Akhir</th>
                                <th>Grade</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
            <?php foreach ($mahasiswa as $mhs): 
                $nilai = hitungNilaiAkhir($mhs['tugas'], $mhs['uts'], $mhs['uas']);
                $grade = grade($nilai);
                $status = status($nilai);
                $total += $nilai;
                if ($nilai > $max) $max = $nilai;
                if ($status == "Lulus") $lulus++;
                else $tidak_lulus++;
            ?>
            <tr>
                <td class="fw-semibold"><?= $mhs['nama'] ?></td>
                <td><code><?= $mhs['nim'] ?></code></td>
                <td><span class="badge bg-secondary"><?= $mhs['tugas'] ?></span></td>
                <td><span class="badge bg-secondary"><?= $mhs['uts'] ?></span></td>
                <td><span class="badge bg-secondary"><?= $mhs['uas'] ?></span></td>
                <td><strong class="text-primary"><?= round($nilai, 2) ?></strong></td>
                <td>
                    <?php
                    $gradeClass = match($grade) {
                        'A' => 'success',
                        'B' => 'primary',
                        'C' => 'warning',
                        'D' => 'secondary',
                        'E' => 'danger',
                        default => 'secondary'
                    };
                    ?>
                    <span class="badge bg-<?= $gradeClass ?> fs-6 px-3 py-2"><?= $grade ?></span>
                </td>
                <td>
                    <?php if ($status == "Lulus"): ?>
                        <span class="badge bg-success fs-6 px-3 py-2">✓ Lulus</span>
                    <?php else: ?>
                        <span class="badge bg-danger fs-6 px-3 py-2">✗ Tidak Lulus</span>
                    <?php endif; ?>
                </td>
            </tr>
            <?php endforeach; 
            // Hitung rata-rata setelah loop
            $rata = $jumlah > 0 ? $total / $jumlah : 0;
            ?>
                    </tbody>
                </table>
                </div>
            </div>
        </div>

        <div class="card shadow-lg border-secondary bg-dark text-light border-1 mt-4">
            <div class="card-header bg-dark text-light border-secondary">
                <h3 class="card-title mb-0">
                    <i class="bi bi-bar-chart-line me-2"></i>
                    Statistik Kelas
                </h3>
            </div>
            <div class="card-body bg-dark text-light">
                <div class="stats row g-3">
            <div class="col-md-3">
                <div class="stat-card card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Rata-rata Kelas</h5>
                        <p class="card-text display-6 text-primary fw-bold"><?= round($rata, 2) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Nilai Tertinggi</h5>
                        <p class="card-text display-6 text-success fw-bold"><?= round($max, 2) ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Lulus</h5>
                        <p class="card-text display-6 text-info fw-bold"><?= $lulus ?></p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="stat-card card text-center">
                    <div class="card-body">
                        <h5 class="card-title">Jumlah Tidak Lulus</h5>
                        <p class="card-text display-6 text-danger fw-bold"><?= $tidak_lulus ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer class="footer bg-dark text-light py-4 mt-5">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <p class="mb-0">&copy; 2026 Sistem Penilaian Mahasiswa.</p>
                </div>
                <br>
                <div class="col-md-6 text-md-end">
                    <p class="mb-0">Telkom Universitas Purwokerto | Fakultas Informatika</p>
                </div>
            </div>
        </div>
    </footer>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>

    <script>
        function calculatePreview() {
            const tugas = parseFloat(document.getElementById('tugas').value) || 0;
            const uts = parseFloat(document.getElementById('uts').value) || 0;
            const uas = parseFloat(document.getElementById('uas').value) || 0;

            // Hitung nilai akhir (30% tugas + 30% UTS + 40% UAS)
            const nilaiAkhir = (tugas * 0.3) + (uts * 0.3) + (uas * 0.4);

            // Tentukan grade
            let grade;
            if (nilaiAkhir >= 85) grade = 'A';
            else if (nilaiAkhir >= 75) grade = 'B';
            else if (nilaiAkhir >= 65) grade = 'C';
            else if (nilaiAkhir >= 50) grade = 'D';
            else grade = 'E';

            // Tentukan status
            const status = nilaiAkhir >= 60 ? 'Lulus' : 'Tidak Lulus';

            // Update preview
            document.getElementById('previewNilai').textContent = nilaiAkhir.toFixed(2);
            document.getElementById('previewGrade').textContent = grade;
            document.getElementById('previewStatus').textContent = status;
        }

        function resetForm() {
            document.getElementById('mahasiswaForm').reset();
            document.getElementById('previewNilai').textContent = '-';
            document.getElementById('previewGrade').textContent = '-';
            document.getElementById('previewStatus').textContent = '-';
        }

        // Hitung preview saat halaman dimuat jika ada nilai
        document.addEventListener('DOMContentLoaded', function() {
            calculatePreview();
        });
    </script>
</body>
</html>

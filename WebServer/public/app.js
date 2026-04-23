const button = document.getElementById('tampilkanBtn');
const hasilProfil = document.getElementById('hasil-profil');

button.addEventListener('click', async () => {
    hasilProfil.textContent = 'Memuat data...';

    try {
        const response = await fetch('/api/profile');
        if (!response.ok) {
            throw new Error(`Server error: ${response.status}`);
        }

        const data = await response.json();
        hasilProfil.textContent = `Nama: ${data.nama} | Pekerjaan: ${data.pekerjaan} | Lokasi: ${data.lokasi}`;
    } catch (error) {
        hasilProfil.textContent = 'Gagal memuat data: ' + error.message;
    }
});

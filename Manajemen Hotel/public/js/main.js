$(document).ready(function() {
    // --- 1. KONFIGURASI GLOBAL ---
    const KAPASITAS_MAKSIMAL = 30; // Total kamar hotel

    // --- 2. LOGIKA DASHBOARD (STATISTIK) ---
    if ($("#totalReservasi").length || $("#tersediaNumber").length) {
        $.get("/api/reservasi", function(res) {
            let totalReservasi = 0;

            // Menangani format { data: rows } dari controller
            if (res && res.data) {
                totalReservasi = res.data.length;
            } else if (Array.isArray(res)) {
                totalReservasi = res.length;
            }

            // Update Angka Total Reservasi
            $("#totalReservasi").hide().text(totalReservasi).fadeIn(600);

            // Hitung Kamar Tersedia
            let sisaKamar = KAPASITAS_MAKSIMAL - totalReservasi;
            if (sisaKamar < 0) sisaKamar = 0;

            // Update Angka Kamar Tersedia dengan efek warna
            $("#tersediaNumber").hide().text(sisaKamar).fadeIn(600, function() {
                if (sisaKamar <= 5) {
                    $(this).css("color", "#ff4d4d"); // Merah jika hampir penuh
                } else {
                    $(this).css("color", "#c5a059"); // Bronze jika aman
                }
            });
        }).fail(function() {
            console.error("Gagal memuat statistik hotel.");
        });
    }

    // --- 3. LOGIKA DATATABLES (DATA RESERVASI) ---
    if ($("#reservasiTable").length) {
        $("#reservasiTable").DataTable({
            ajax: {
                url: "/api/reservasi",
                dataSrc: "data" // Menyesuaikan res.json({ data: rows })
            },
            columns: [
                { data: "id" },
                { data: "nama" },
                { data: "kamar" },
                { data: "checkin" },
                { data: "checkout" },
                {
                    data: "status",
                    render: function(data) {
                        // Badge mewah menyesuaikan tema dark
                        if (data === "Terisi" || data === "Confirmed") {
                            return '<span class="badge" style="background: #4a3f28; color: #c5a059; border: 1px solid #c5a059;">Terisi</span>';
                        } else {
                            return '<span class="badge" style="background: rgba(197, 160, 89, 0.1); color: #c5a059; border: 1px solid rgba(197, 160, 89, 0.3);">Tersedia</span>';
                        }
                    }
                },
                {
                    data: "id",
                    render: function(data) {
                        return `<button class="btn btn-sm delete" data-id="${data}" 
                                style="border: 1px solid #ff4d4d; color: #ff4d4d; background: transparent;">
                                <i class="bi bi-trash"></i> Delete
                                </button>`;
                    }
                }
            ],
            // Styling DataTables agar masuk ke tema Dark
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Cari Reservasi...",
            }
        });
    }
});

// --- 4. LOGIKA DELETE (DILUAR READY AGAR DELEGASI WORK) ---
$(document).on("click", ".delete", function() {
    let id = $(this).data("id");

    if (confirm("Apakah Anda yakin ingin menghapus data reservasi ini?")) {
        $.ajax({
            url: "/api/reservasi/" + id,
            type: "DELETE",
            success: function(response) {
                alert("Data berhasil dihapus.");
                // Jika di halaman Dashboard, reload untuk update stat. 
                // Jika di halaman Data, reload tabel.
                location.reload(); 
            },
            error: function() {
                alert("Gagal menghapus data.");
            }
        });
    }
});
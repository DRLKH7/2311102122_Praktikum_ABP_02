const sqlite3 = require("sqlite3").verbose()

const db = new sqlite3.Database("./hotel.db")

db.serialize(() => {

    db.run(`CREATE TABLE IF NOT EXISTS reservasi (
        id INTEGER PRIMARY KEY AUTOINCREMENT,
        nama TEXT,
        nik TEXT,
        hp TEXT,
        alamat TEXT,
        kamar TEXT,
        checkin TEXT,
        checkout TEXT,
        status TEXT
    )`)

})

module.exports = db
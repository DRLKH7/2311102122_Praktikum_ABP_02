const db = require("../database/db")

exports.getAll = (callback) => {
    db.all("SELECT * FROM reservasi", callback)
}

exports.create = (data, callback) => {
    const sql = `
    INSERT INTO reservasi 
    (nama, nik, hp, alamat, kamar, checkin, checkout, status)
    VALUES (?,?,?,?,?,?,?,?)`

    db.run(sql,
        [
            data.nama,
            data.nik,
            data.hp,
            data.alamat,
            data.kamar,
            data.checkin,
            data.checkout,
            "Terisi"
        ],
        callback
    )
}

exports.delete = (id, callback) => {
    db.run("DELETE FROM reservasi WHERE id=?", [id], callback)
}
const Reservasi = require("../models/reservasiModel")

exports.getReservasi = (req, res) => {

    Reservasi.getAll((err, rows) => {

        if (err) {
            res.status(500).json(err)
        } else {
            res.json({ data: rows })
        }

    })

}

exports.createReservasi = (req, res) => {

    Reservasi.create(req.body, (err) => {

        if (err) {
            res.status(500).json(err)
        } else {
            res.json({ message: "Reservasi berhasil" })
        }

    })

}

exports.deleteReservasi = (req, res) => {

    Reservasi.delete(req.params.id, (err) => {

        if (err) {
            res.status(500).json(err)
        } else {
            res.json({ message: "Data dihapus" })
        }

    })

}
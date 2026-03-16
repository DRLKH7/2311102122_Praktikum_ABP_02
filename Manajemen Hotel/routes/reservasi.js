const express = require("express")
const router = express.Router()

const controller = require("../controllers/reservasiController")

router.get("/", controller.getReservasi)

router.post("/", controller.createReservasi)

router.delete("/:id", controller.deleteReservasi)

module.exports = router
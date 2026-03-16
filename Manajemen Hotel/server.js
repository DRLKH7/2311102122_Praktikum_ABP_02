const express = require("express")
const bodyParser = require("body-parser")
const path = require("path")
const cors = require("cors")

const reservasiRoutes = require("./routes/reservasi")

const app = express()

app.use(cors())
app.use(bodyParser.json())
app.use(bodyParser.urlencoded({ extended: true }))

// static folder
app.use(express.static(path.join(__dirname, "public")))

// API
app.use("/api/reservasi", reservasiRoutes)

// halaman
app.get("/", (req, res) => {
    res.sendFile(path.join(__dirname, "view", "dashboard.html"))
})

app.get("/form", (req, res) => {
    res.sendFile(path.join(__dirname, "view", "form-reservasi.html"))
})

app.get("/data", (req, res) => {
    res.sendFile(path.join(__dirname, "view", "data-reservasi.html"))
})

app.listen(3000, () => {
    console.log("Server running http://localhost:3000")
})
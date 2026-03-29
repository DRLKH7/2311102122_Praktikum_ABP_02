function getQuote() {
    const quoteEl = document.querySelector(".quote");

    if (!quoteEl) return;

    quoteEl.innerText = "Loading...";

    fetch("https://dummyjson.com/quotes/random")
        .then(res => res.json())
        .then(data => {
            quoteEl.innerText = data.quote + " - " + data.author;
        })
        .catch(error => {
            console.error(error);
            quoteEl.innerText = "Gagal ambil data, internet lu atau API-nya bermasalah";
        });
}

document.addEventListener("DOMContentLoaded", function () {
    getQuote();
    setInterval(getQuote, 10000);
});
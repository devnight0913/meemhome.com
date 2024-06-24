import Chart from "chart.js/auto";

window.Chart = Chart;
document.addEventListener("DOMContentLoaded", function () {
    var menuToggle = document.querySelector("#menu-toggle");
    if (menuToggle) {
        menuToggle.addEventListener("click", function (event) {
            event.preventDefault();
            console.log("clicked");
            document.querySelector("#wrapper").classList.toggle("toggled");
        });
    }

    // var modals = [].slice.call(document.querySelectorAll(".modal"));

    // modals.map(function (modal) {
    //     modal.addEventListener("hidden.bs.modal", function (event) {
    //         document.body.classList.remove("overflow-hidden");
    //         document.body.classList.add("overflow-auto");
    //     });
    //     modal.addEventListener("shown.bs.modal", function (event) {
    //         document.body.classList.add("overflow-hidden");
    //         document.body.classList.remove("overflow-auto");
    //     });
    // });
});

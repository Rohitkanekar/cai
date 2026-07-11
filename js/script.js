/*========================================== HAMBURGER ==========================================*/

const hamburger = document.querySelector(".hamburger");
const menu = document.querySelector(".menu");
hamburger.addEventListener("click", () => {
    hamburger.classList.toggle("active");
    menu.classList.toggle("active");
    document.body.classList.toggle("menu-open");
});

/* Close Menu on Click */

document.querySelectorAll(".menu a").forEach(link => {
    link.addEventListener("click", () => {
        hamburger.classList.remove("active");
        menu.classList.remove("active");
        document.body.classList.remove("menu-open");
    });
});
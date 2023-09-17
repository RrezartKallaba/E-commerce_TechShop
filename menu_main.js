// Hapja e menys kur klikohet butoni hamburget menu
function toggleMenu() {
    var menu = document.getElementById("myLinks");
    var iconHamburger = document.querySelector(".icon-hamburger");
    var iconClose = document.querySelector(".icon-close");

    if (menu.style.display === "block") {
        menu.style.display = "none";
        iconHamburger.style.display = "block";
        iconClose.style.display = "none";
    } else {
        menu.style.display = "block";
        iconHamburger.style.display = "none";
        iconClose.style.display = "block";
    }
}
// Mbyllja menysë pas klikimit në ndonjë faqe
function closeMenu() {
    var menu = document.getElementById("myLinks");
    var iconHamburger = document.querySelector(".icon-hamburger");
    var iconClose = document.querySelector(".icon-close");

    if (window.innerWidth <= 868) {
        menu.style.display = "none";
        iconHamburger.style.display = "block";
        iconClose.style.display = "none";
    }
}

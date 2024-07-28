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

// ==== CART ==================
let cartIcon = document.querySelector('#cart-icon');
let cart = document.querySelector('.cart');
let closeCart = document.querySelector('#close-cart');

// == Open cart
cartIcon.onclick = () => {
    cart.classList.add('active');
};

// == Close cart
closeCart.onclick = () => {
    cart.classList.remove('active');
};

// == Close Working JavaScript
if (document.readyState == 'loading') {
    document.addEventListener('DOMContentLoaded', ready);
} else {
    ready();
};

document.addEventListener("contextmenu", function(e) {
    e.preventDefault();
}, false);

document.addEventListener("keydown", function(e) {
    if (e.key == "F12") {
        e.preventDefault();
    }
});
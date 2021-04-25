// When the user scrolls the page, execute myFunction  //https://www.w3schools.com/howto/howto_js_navbar_sticky.asp

window.onscroll = function () { myFunction() };

// Get the navbar
var navbar = document.getElementById("sidebar");
var previousHeight = navbar.style.top;


// Add the sticky class to the navbar when you reach its scroll position. Remove "sticky" when you leave the scroll position
function myFunction() {
    if (window.pageYOffset > 0) {
        navbar.style.top = 0;
    } else {
        navbar.style.top = previousHeight;
    }
}
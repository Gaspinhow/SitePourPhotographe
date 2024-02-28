document.addEventListener("DOMContentLoaded", function() {
    const footer = document.querySelector("footer a");
    
    footer.addEventListener("click", function(event) {
        event.preventDefault(); 
        window.location.href = "a-propos.html";
    });
});

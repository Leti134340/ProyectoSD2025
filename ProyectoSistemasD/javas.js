const toggle = document.getElementById("menuToggle");
const menu = document.getElementById("dropdownMenu");

toggle.addEventListener("click", () => {
  menu.style.display = (menu.style.display === "block") ? "none" : "block";
});

window.addEventListener("click", function(e) {
  if (!e.target.matches('#menuToggle')) {
    menu.style.display = "none";
  }
});

document.getElementById("logo").onclick = function() {
    alert("¡Haz hecho clic en el logo de Trasshy!");
};
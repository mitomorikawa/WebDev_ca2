const setSimple = function () {
   document.querySelector("#mediumPhotoGenerator").style.display = "none";
   document.querySelector("#complexPhotoGenerator").style.display = "none";
   document.querySelectorAll("#mediumPhotoGenerator input").forEach(i => i.removeAttribute("required"));
   document.querySelectorAll("#complexPhotoGenerator input").forEach(i => i.removeAttribute("required"));
}

const setMedium = function () {
   document.querySelector("#mediumPhotoGenerator").style.display = "block";
   document.querySelector("#complexPhotoGenerator").style.display = "none";
   document.querySelectorAll("#mediumPhotoGenerator input").forEach(i => i.setAttribute("required", ""));
   document.querySelectorAll("#complexPhotoGenerator input").forEach(i => i.removeAttribute("required"));
}

const setComplex = function () {
   document.querySelector("#complexPhotoGenerator").style.display = "block";
   document.querySelector("#mediumPhotoGenerator").style.display = "none";
   document.querySelectorAll("#complexPhotoGenerator input").forEach(i => i.setAttribute("required", ""));
   document.querySelectorAll("#mediumPhotoGenerator input").forEach(i => i.removeAttribute("required"));
}
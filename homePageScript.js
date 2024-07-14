var profile = document.getElementById("profile");

var handouts = document.getElementById("handouts");

var exams = document.getElementById("exam");

var cats = document.getElementById("cat");

var ebook = document.getElementById("ebook");

var upload = document.getElementById("upload");

var thesis = document.getElementById("thesis");

var upload = document.getElementById("upload");

var log_out = document.getElementById("logOut");

var about = document.getElementById("home_page_top_about");

about.onclick = function () {
    window.open("about.php","_self");
}
upload.onclick = function () {
    window.open("upload.php","_self");
}

log_out.onclick = function () {
    window.open("end.php","_self");
}

profile.onclick = function () {
    window.open("profilePage.php","_self");
}

handouts.onclick = function () {
    window.open("index.php?type=handout","_self");
}

exams.onclick = function () {
    window.open("index.php?type=Exam","_self");
}

cats.onclick = function () {
    window.open("index.php?type=cat","_self");
}

ebook.onclick = function () {
    window.open("index.php?type=ebook","_self");
}

upload.onclick = function () {
    window.open("upload.php","_self");
}

thesis.onclick = function () {
    window.open("index.php?type=thesis","_self");
}

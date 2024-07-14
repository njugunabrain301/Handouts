var profile = document.getElementById("profile");

var handouts = document.getElementById("handouts_menu");

var exams = document.getElementById("exams_menu");

var cats = document.getElementById("cats_menu");

var ebook = document.getElementById("ebook_menu");

var upload = document.getElementById("upload_menu");

var thesis = document.getElementById("thesis_menu");

var home = document.getElementById("home_menu");


home.onclick = function () {
    window.open("homePage.php","_self");
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
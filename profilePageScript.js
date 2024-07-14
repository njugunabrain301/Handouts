var profile_menu = document.getElementById("profile_page_menu");

var profile_pane = document.getElementById("profile_page_left_panel");
var profile_page_pwd = document.getElementById("profile_page_pwd");
var profile_page_image = document.getElementById("profile_page_image");

var profile_page_name = document.getElementById("profile_page_name");

var profile_page_occupation = document.getElementById("profile_page_occupation");

var profile_page_email = document.getElementById("profile_page_email");

var profile_page_regNo = document.getElementById("profile_page_regNo");

var change_image = document.getElementById("profile_change_image");

var change_name = document.getElementById("profile_change_name");

var change_occupation = document.getElementById("profile_change_occupation");

var change_email = document.getElementById("profile_change_email");

var change_regNo = document.getElementById("profile_change_regNo");

var profile_page_about = document.getElementById('profile_page_about');

var change_pwd = document.getElementById("profile_change_pwd");

var body = document.getElementById('profileBody');

body.style.overflowY = 'auto';

profile_page_about.onclick = function (){
    window.open('about.php','_self');
}

profile_page_image.onclick = function () {
    hide();
    change_image.className = "profile_change_image";
}

profile_page_pwd.onclick = function () {
    hide();
    change_pwd.className = "profile_change_pwd";
}

profile_page_name.onclick = function () {
    hide();
    change_name.className = "profile_change_name";
}

profile_page_email.onclick = function () {
    hide();
    change_email.className = "profile_change_email"; 
}

function hide(){
    change_pwd.className = "profile_hidden";
    change_name.className = "profile_hidden";
    change_image.className = "profile_hidden";
    change_email.className = "profile_hidden";
}

profile_menu.onclick = function () {
    
     var first = document.getElementsByClassName('first_child');
    var middle = document.getElementsByClassName('middle_child');
    var last = document.getElementsByClassName('last_child');
    
   
   
    if(profile_pane.className == "hidden"){
        profile_pane.className = "profile_page_left_panel_visible";
        
        first[0].id = "first_child";
        middle[0].id = "middle_child";
        last[0].id = "last_child";
        
        body.className = "fixed2";
        body.style.overflowY='hidden';
    }else{
        profile_pane.className = "hidden";
        
        first[0].id = "";
        middle[0].id = "";
        last[0].id = "";
        
        body.className = "";
        body.style.overflowY = 'auto';
    }
}
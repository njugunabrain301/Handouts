var left_panel = document.getElementById("left_panel");

var menu = document.getElementById("menu");

var right_panel = document.getElementById("right_panel");

var filterContent = document.getElementById("filterContent");

var filter = document.getElementById("fil");

var span1 = document.getElementById("span1");

var span2 = document.getElementById("span2");

var first = document.getElementsByClassName('first_child');

var middle = document.getElementsByClassName('middle_child');

var last = document.getElementsByClassName('last_child');
    
var body = document.getElementById('container');

var body2 = document.getElementById('indexBody');


function show_menu(){
    filterContent.className = "hideFilter";
    
    left_panel.className = "left_panel_visible";
        
        first[0].id = "first_child";
        middle[0].id = "middle_child";
        last[0].id = "last_child";
        body.className = "fixed";
        body2.className = "fixed";
}
function hide_menu(){
    filterContent.className = "hideFilter";
    left_panel.className = "left_panel_hidden";
        
        first[0].id = "";
        middle[0].id = "";
        last[0].id = "";
        body.className = "";
        body2.className = "";
}

function show_filter(){
    hide_menu();
    
    filterContent.className = "showFilter";
    span1.className = "active";
    span2.className = "active";
}

function hide_filter(){
    
    filterContent.className = "hideFilter";
    span1.className = "";
    span2.className = "";
}

filter.onclick = function () {
    "use strict";
     left_panel.className = "left_panel_hidden";
    
    right_panel.className = "right_panel_full";
    
    if(filterContent.className == "hideFilter"){
        show_filter();
    }else{
        hide_filter();
    }
    
};

menu.onclick = function () {
    "use strict";
    hide_filter();
    if(left_panel.className == "left_panel_hidden"){
        show_menu();
    }else{
        hide_menu();
    }
}


var done = document.getElementById("done");
done.onclick = function () {
    "use strict";
};
function check2() {
    var search = document.getElementById("searchItem").value;
    
    if(search === ""){
        return false;
    }else{
        return true;
    }
    
}
function check() {
    var cc = document.getElementById("courseCode").value;
    var ct = document.getElementById("courseTitle").value;
    var t = document.getElementById("type").value;
    var y = document.getElementById("year").value;
    
    if (cc === "" && ct === "" && t === "" && y === "") {
        alert("Enter search values");
        return false;
    } else {
        filterContent.className = "hideFilter";
        alert("You are through");
        return true;
    }
}


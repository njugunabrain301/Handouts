var about_menu = document.getElementById("about_page_menu");

var about_pane = document.getElementById("about_page_left_panel");

about_menu.onclick = function () {
    
     var first = document.getElementsByClassName('first_child');
    var middle = document.getElementsByClassName('middle_child');
    var last = document.getElementsByClassName('last_child');
   
    var body = document.getElementById('about_page');
    
    if(about_pane.className == "hidden"){
        about_pane.className = "about_page_left_panel_visible";
        
        first[0].id = "first_child";
        middle[0].id = "middle_child";
        last[0].id = "last_child";
        
        body.className = "fixed";
        
    }else{
        about_pane.className = "hidden";
        
        first[0].id = "";
        middle[0].id = "";
        last[0].id = "";
        
        body.className = "";
    }
}
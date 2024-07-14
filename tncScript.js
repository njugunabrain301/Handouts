var tnc_menu = document.getElementById("tnc_menu");

var tnc_pane = document.getElementById("left_panel");

tnc_menu.onclick = function () {
    
     var first = document.getElementsByClassName('first_child');
    var middle = document.getElementsByClassName('middle_child');
    var last = document.getElementsByClassName('last_child');
   
    var body = document.getElementById('tnc');
    
    if(tnc_pane.className == "hidden"){
        tnc_pane.className = "about_page_left_panel_visible";
        
        first[0].id = "first_child";
        middle[0].id = "middle_child";
        last[0].id = "last_child";
        
        body.className = "fixed";
        
    }else{
        tnc_pane.className = "hidden";
        
        first[0].id = "";
        middle[0].id = "";
        last[0].id = "";
        
        body.className = "";
    }
}
<?php
if(mail("bjmbugua7@gmail.com", "Handouts Recovery Code","Your recovery code is ","jinglestudioofficial@gmail.com")){
    echo "mail sent";
}else{
    echo "mail not sent ";
    $errorMessage = error_get_last()['message'];
    echo $errorMessage;
}
?>

<html>
<head>
    <link type="text/css" rel="stylesheet" href="css/fontawesome.min.css">
    
</head>
<i class="fab fa-accessible-icon"></i>
</html>
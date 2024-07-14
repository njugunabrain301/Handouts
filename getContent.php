<?php
    require "databaseLogIn.php";
    class index extends connection{
        private $pages;
        private $page = 1;
        private $query;
        private $result;

        public function set(){
                $type = "";
                $code = "";
                $year = "";
                $search = "";
                $sort = "date";
                $faculty = "";
                $department = "";
                if(isset($_GET['sort'])){
                    $sort = $_GET['sort'];
                    $_SESSION['sort']=$_GET['sort']; 
                }else{
                    if(!isset($_SESSION['sort'])){
                        $_SESSION['sort'] = "date";
                        $sort = "date";
                    }else{
                        $sort = $_SESSION['sort'];
                    }
                }
                if(isset($_GET['ucode'])){
                    $code = strtoupper($_GET['ucode']);
                    $_SESSION['code'] = $_GET['ucode'];
                }else{
                    if(!isset($_SESSION['code'])){
                        $_SESSION['code'] = "";
                        $code = "";
                    }else{
                        $code = $_SESSION['code'];
                    }
                }
                if(isset($_GET['year'])){
                    $year = strtoupper($_GET['year']);
                    $_SESSION['year'] = $_GET['year'];
                }else{
                    if(!isset($_SESSION['year'])){
                        $_SESSION['year'] = "";
                        $year = "";
                    }else{
                        $year = $_SESSION['year'];
                    }
                }
        
                if(isset($_GET['type'])){
                    $type = strtoupper($_GET['type']);
                    $_SESSION['type'] = $_GET['type'];
                }else{
                    if(!isset($_SESSION['type'])){
                        $_SESSION['type'] = "";
                        $type = "";
                    }else{
                        $type = $_SESSION['type'];
                    }
                }
                if(isset($_GET['faculty'])){
                    $faculty = strtoupper($_GET['faculty']);
                    $_SESSION['faculty'] = $_GET['faculty'];
                }else{
                    if(!isset($_SESSION['faculty'])){
                        $_SESSION['faculty'] = "";
                        $faculty = "";
                    }else{
                        $faculty = $_SESSION['faculty'];
                    }
                }
                if(isset($_GET['department'])){
                    $department = strtoupper($_GET['department']);
                    $_SESSION['department'] = $_GET['department'];
                }else{
                    if(!isset($_SESSION['department'])){
                        $_SESSION['department'] = "";
                        $department = "";
                    }else{
                        $department = $_SESSION['department'];
                    }
                }
                if(strtoupper($year) == "ALL"){
                    $year = "";
                }   
                if(strtoupper($type) == "ALL"){
                    $type = "";
                }
                $this->query = "SELECT * from ".$this->database.".handouts where unitCode like ? and type like ? and year like ? and faculty like ? and department like ?";
                
                if(isset($_GET['search'])){
                    $search = strtoupper($_GET['search']);
                    $_SESSION['search'] = $_GET['search'];
                }else{
                    if(!isset($_SESSION['search'])){
                        $_SESSION['search'] = "";
                        $search = "";
                    }else{
                        $search = $_SESSION['search'];
                    }
                }
                if(strtoupper($sort) == "DATE"){
                    $sort = " Id DESC";
                }else{
                    $sort = " name";
                }
                $item = " unitCode like ? or unitTitle like ? or name like ?"; 
                $this->query = $this->query." and (".$item.")";
                $this->query = $this->query." order by ?";  
                $results = $this->connect()->prepare($this->query);
                $results->execute(["%$code%", "%$type%", "%$year%", "%$faculty%", "%$department%", "%$search%", "%$search%", "%$search%", $sort]);
                $total = $results->rowCount();
                $this->pages = explode('.',($total/5))[0];
                if(($total%5) != 0){
                    $this->pages = $this->pages+1;
                }
                if(isset($_GET['next'])){
                    if($_SESSION['offset'] < $this->pages){
                        $_SESSION['offset']+=1;
                        $this->page = $_SESSION['offset'];
                    }else{
                        $this->page = $_SESSION['offset'];
                    }
                }
                if(isset($_GET['previous'])){
                    if($_SESSION['offset'] > 1){
                        $_SESSION['offset']-=1;
                        $this->page = $_SESSION['offset'];
                    }else{
                        $this->page = $_SESSION['offset'];
                    }
                }
                $offset = 5 * ($this->page-1);
                
                $this->query = $this->query." limit 5 offset ".$offset;
                if(isset($_SESSION['user'])){
                    echo "<div class='loggedIn'>Logged in as ".$this->encode($_SESSION['user'])."</div><div class='links' id='button'><a href=\"end.php\">Log out</a></div>";
                }else{
                    echo "<div class='loggedIn'>Logged out</div>";
                    echo "<div class='links'><a href=\"logIn.php\">Log in</a></div><div class='links'><a href=\"signup.php\">Sign up</a></div>";
        
                }
            $this->result = $this->connect()->prepare($this->query);
            
            $this->result->execute(["%$code%", "%$type%", "%$year%", "%$faculty%", "%$department%", "%$search%", "%$search%", "%$search%", $sort]);
        }
        public function getContent(){
            try{
                //$this->results = $this->connect()->query($this->query);
                while($items = $this->result->FETCH()){
                    echo "<div class=\"hts\"><div class='inleft'><p><a href='documents/".$items['name']."' open>".$this->encode($items['name'])."</a><br>Unit code: ".$this->encode($items['unitCode'])."<br>Uploaded on ".$items['date']."<br>Type :".$items['type']."<br>Unit Title :".$this->encode($items['unitTitle'])."</p></div></div><div class='inright'><div class= 'download'  id = 'documents/".$items['name']."' onclick=\"downloader('documents/".$items['name']."',event)\"><a>Download</a></div></div>";
                }
                if($this->result->rowCount() == 0){
                    echo "No match found";
                }else{
                    if($this->pages > 1){
                        echo "<form action='index.php' method='GET'><input type='submit' value='Previous' name='previous' id='previous'></form><p id='pages'>Page ".($this->page)." of ".$this->pages."</p><form action='index.php' method='GET'><input type='submit' value='Next' name='next' id='next'></form>"; 
                    }
                }
            }catch(Exception $e){
                echo "<script>alert($e);</script>";
            }
        }
        public function encoder(){
            if(isset($_SESSION['code'])){
                $_SESSION['safe_code'] = $this->encode($_SESSION['code']);
            }
            if(isset($_SESSION['faculty'])){
                $_SESSION['safe_faculty'] = $this->encode($_SESSION['faculty']);
            }
            if(isset($_SESSION['department'])){
                $_SESSION['safe_department'] = $this->encode($_SESSION['department']);
            }
            if(isset($_SESSION['search'])){
                $_SESSION['safe_search'] = $this->encode($_SESSION['search']);
            }
        }
    }
    $myClass = new index();
    $myClass->encoder();
?>
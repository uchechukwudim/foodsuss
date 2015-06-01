<?php
//this class is used by instanteSearch class to process searched request
 function loadPage($search, $pages, $cont){

$output ='';
 
     
     
     $sql = "SELECT country_names, map_picture, description FROM country WHERE country_names LIKE '%$search%' LIMIT $pages, 6";
    $count =getNumberOfRows($sql);
    
    if($count == 0)
    {
        $output = "There was no resuslt";
    }else
    {
            $result = SQLExc($sql);

           while($row = mysqli_fetch_array($result))
           {
                extract($row);
                
               $output .= '<div id="loadCon">
            
                    <div id="picture">
                    <img src="'.$map_picture.'" alt="" height="70" width="70">
                    </div>
                    <div id="Cname">
                        <a href="http://localhost/php/food.php?country='.$country_names.'&continent='.$cont.'" class ="Clink">'.$country_names.'</a>
                    </div>
                    <div id="Desc">
                        A Huge consumer of Casava. Country very reach
                        with food. Click to see more foods and how the are
                        prepared.
                    </div>
            
                     </div>';

           }
    }
    echo $output;
    
 }
 
 function LoadPagination($page){
 $per_page = 6;

$page_query = mysql_query("SELECT COUNT(`country_id`) FROM country");
$pages = ceil(mysql_result($page_query, 0)/ $per_page);


$output ='';
 
     
     $search = $_POST['searchval'];
     $sql = "SELECT country_names, map_picture, description FROM country WHERE country_names LIKE '%$search%' LIMIT 0, $page";
    $count =getNumberOfRows($sql);
    
    if($count == 0)
    {
        $output = "There was no resuslt";
    }else
    {
            $result = SQLExc($sql);

           while($row = mysqli_fetch_array($result))
           {
                extract($row);
                
               $output .= '<div id="loadCon">
            
                    <div id="picture">
                    <img src="'.$map_picture.'" alt="" height="70" width="70">
                    </div>
                    <div id="Cname">
                        <a href="http://localhost/php/food.php?country='.$country_names.'" class ="Clink">'.$country_names.'</a>
                    </div>
                    <div id="Desc">
                        A Huge consumer of Casava. Country very reach
                        with food. Click to see more foods and how the are
                        prepared.
                    </div>
            
          </div>';

           }
    }
    echo($output);
    
 }
?>

<?php
   include ("C:\wamp\path\mysql\SqlConnect.php");
   $output = '';
    if(isset($_POST['state']) && isset($_POST['page']) && isset($_POST['continent']))
    {
       $stateCon = $_POST['state'];
       $page = $_POST['page'];
       $Continent = $_POST['continent'];
        $sql = " SELECT country_names, map_picture, description FROM country WHERE continent_id = '$stateCon' LIMIT $page, 6";
         $result = SQLExc($sql);
           while($row = mysqli_fetch_array($result))
            {
               extract($row);
              
            
              $output .= '<div id="loadCon">
            
                    <div id="picture">
                    <img src="'.$map_picture.'" alt="" height="70" width="70">
                    </div>
                    <div id="Cname">
                        <a href="http://localhost/php/food.php?country='.$country_names.'&continent='.$Continent.'" class ="Clink">'.$country_names.'</a>
                    </div>
                    <div id="Desc">
                        '.$description.'
                        A Huge consumer of Casava Palm Oil. Country very reach
                        with food. Click to see more foods and how the are
                        prepared.
                    </div>
             </div>';
          
               }// end of while
    }
    echo $output;
?>

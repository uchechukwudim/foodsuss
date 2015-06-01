<?php
 include ("C:\wamp\path\mysql\SqlConnect.php");
    $output = '';
/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
    if(isset($_POST['food']) && isset($_POST['country']))
    {
        $foodName = $_POST['food'];
        $country = $_POST['country'];
         $sql = "SELECT Product_name FROM food_products WHERE food_name = '$foodName' AND country_names = '$country'";
         
         $result = SQLExc($sql);
         
         
        if(getNumberOfRows($sql) <= 0)
         {
              $output = "$foodName,";
         }
         else{
              while($row = mysqli_fetch_array($result)){
        
           extract($row);
          
            $output .= '<div class="prodList">
                             '.$Product_name.'
                         </div>';
           
        }
         }
       
        
    }
    
   echo $output;
?>

<?php

 function otherCountry($country, $food)
 {
     $output = '';
     $sql = "SELECT country_names FROM food_country WHERE food_name = '$food'";
     
     $result = SQLExc($sql);
     
     while($row = mysqli_fetch_array($result))
     {
         extract($row);
           if($country_names != $country)
            {
               $output .= $country_names."</br>";
            }
     }
     
     return $output;
 }
 

?>

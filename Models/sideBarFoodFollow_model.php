<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of homeFoodFollow
 *
 * @author Uche
 */
class sideBarFoodFollow_model extends Model {
    //put your code here   
    function __construct() {
        parent::__construct();
        $this->id = $this->getUserID(Session::get('user'));
        $this->FirstName = $this->getUserFirstName($this->id);
        $this->enrypter = array(525250.22,625315.14,825020.24,4253290.34,125345.54);
    }
    
    public function foodFollow()
    {

        $sql = "SELECT F.food_name, C.country_names, F.food_description, F.food_picture, F.Nutrients
                FROM  `food` AS F
                INNER JOIN food_follow AS FF ON F.food_id = FF.food_id
                INNER JOIN country AS C ON C.country_id = FF.country_id
                WHERE FF.user_id = :user_id LIMIT 0 , 6";
        
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':user_id' => $this->id));
        
       $foodsFollow = $sth->fetchAll();
        //echo json_encode/((int)$this->getCountryID($foodsFollow[0]['country_names']));
       $this->loadFoods($foodsFollow, $page='');
    }
    
    private function loadFoods($data, $page='')
    {
        $src = '';
        $title = '';
        $header = '<div style="margin-left: 25px; font-size: 1.2em"  id="foodFollowingHeader"><img src="'.URL.'pictures/search/ENRI_FOOD.png" width="30" height="28"> Foods You Follow</div>';
        if($page)
        {
              $output = '';
        }
        else{
              $output = $header;
        }
      
        for($i=0; $i < count($data); $i++)
        {
            $food_id = $this->getFoodId($data[$i]["food_name"]);
            $country_id = (int)$this->getCountryID($data[$i]['country_names']);
            if($this->isFollowFood($this->id, $food_id, $country_id))
            {
                $src = URL."pictures/foods/ufollow.png";
                $title = "unfollow ".$data[$i]["food_name"]." in ".$data[$i]["country_names"]."";
            }
            else
            {
                $src = URL."pictures/foods/follow.png";
                  $title = "follow ".$data[$i]["food_name"]." in ".$data[$i]["country_names"]."";
            }
            $output .= '<div class="foodCon">
                       <script  type="text/javascript">
                        inifityScroltooltipCont(\''.$i.'\');
                            inifityScroltooltipNut(\''.$i.'\')
                        </script>
                 <div class="followFood" ><img class="followFoodimg" src="'.$src.'" title="'.$title.'" width="30" height="30"  onclick="followFood(\''.$this->id.'\',\''. $this->getFoodId($data[$i]["food_name"]).'\',\''.$this->getCountryID($data[$i]["country_names"]).'\',\''.$i.'\')"></div>
                     <div class="foodpic">
                            <img src="data:image/jpeg;base64,'.base64_encode($data[$i]["food_picture"]).'" height="100" width="100">
                     </div>
                     <div class="foodName">
                      '.$data[$i]["food_name"].'
                      </div>
                     
                     <div class="foodDesc">
                      '.$data[$i]["food_description"].'
                     </div>
                   <div class="enri_recipes">
                     <span ><a href="'.URL.MEAL.''.$data[$i]["food_name"].'/'.$data[$i]["country_names"].'"><img src="'.URL.'pictures/foods/ENRI_RECIPE_ICON.png" width="30" title="recipes" alt=""></a></span>
                     </div>
                     <div class="products" onclick="products(\''.$data[$i]["food_name"].'\',\''.$data[$i]["country_names"].'\');">
                         <div id = "Prod" style=""><img src="'.URL.'pictures/foods/ENRI_PRODUCT_ICONS.png" width="40" title="products" alt=""></div>
                     </div>
           
             <div class="OtherCountryNuterients">
                <ul>
                    <li class="Count" title="'.$data[$i]["country_names"].'">Countries<div class="TOOLTIPCont"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDERCont"></div></li>
                    <li class="Nutr"  style="margin-left: 10px;" title="'. $data[$i]["Nutrients"].'">Nutrients<div class="TOOLTIPNut"><span class ="tooler"></span></div><div  class="TOOLTIPHOLDERNut"></div></li>
                </ul>
            </div>
          
           </div>';
        }
        
        echo json_encode($output);
    }
    
     private function isFollowFood($user_id, $food_id, $country_id)
    {
        $sql = "SELECT user_id from food_follow WHERE user_id = :user_id AND food_id= :food_id AND country_id= :country_id";
       $sth = $this->db->prepare($sql);
       $sth->setFetchMode(PDO::FETCH_ASSOC);
       $sth->execute(array(
           ":user_id" => $user_id,
           ":food_id" => $food_id,
           ":country_id" => $country_id
       ));
       
       $data = $sth->fetchAll(PDO::FETCH_ASSOC);
       
       if(count($data)> 0)
       {
           return true;
       }
       else 
       {
           return false;
       }
    }
    
     function otherCountry($country, $food)
     {
     $output = '';
     $sql = "SELECT country_names FROM food_country WHERE food_name = :food";
     
    $sth = $this->db->prepare($sql);
    $sth->setFetchMode(PDO::FETCH_ASSOC);
    $sth->execute(array(
        ':food' => $food
    ));
     $data = $sth->fetchAll(PDO::FETCH_ASSOC);
     for($i=0; $i < count($data); $i++)
     {
      
     if($data[$i]['country_names'] != $country)
            {
               $output .= $data[$i]['country_names'] ."</br>";
            }
     }
     
     return $output;
  }
  
    function infinityFoodFollow($page)
    {
              $sql = "SELECT F.food_name, C.country_names, F.food_description, F.food_picture, F.Nutrients
                FROM  `food` AS F
                INNER JOIN food_follow AS FF ON F.food_id = FF.food_id
                INNER JOIN country AS C ON C.country_id = FF.country_id
                WHERE FF.user_id = :user_id LIMIT $page, 6";
        
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':user_id' => $this->id));
        
        $foodsFollow = $sth->fetchAll();
        $this->loadFoods($foodsFollow, $page);
    }
}

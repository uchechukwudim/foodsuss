<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of search_model
 *
 * @author Uche
 */
class search_model extends Model {
    //put your code here
    function __construct()
     {
        parent::__construct();
         $this->id = $this->getUserID(Session::get('user'));
        $this->FirstName = $this->getUserFirstName($this->id);
        $this->enrypter = array(525250.22,625315.14,825020.24,4253290.34,125345.54);
     }
     
     public function index($search_val)
     {
         
        $sql = "SELECT R.recipe_title, RI.recipe_photo, R.user_id, R.food_id, R.country_id
                FROM  `recipes` AS R
                INNER JOIN recipes_images AS RI ON R.recipe_image_id = RI.recipe_image_id
                WHERE R.recipe_title LIKE  '%$search_val%'
                UNION 
                SELECT recipe_title, recipe_photo, user_id, food_id, country_id
                FROM recipe_post
                WHERE recipe_title LIKE  '%$search_val%'";
        
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        
        $search_result = $sth->fetchAll();
 
        echo $this->loadRecipeSearchResult($search_result);
     }
     private function loadRecipeSearchResult($search_result)
     {
         $output = '';
         
         for($looper = 0; $looper < count($search_result); $looper++)
         {
             $output .='<div class="RecipeSearchResult">
                        <img src="data:image/jpeg;base64,'.base64_encode($search_result[$looper]['recipe_photo']).'" width="50" height="50">'
                     . '<span class="recipe_title">'.$this->getLinkedRecipeTitle($search_result[$looper]['recipe_title'], $search_result[$looper]['user_id'], $search_result[$looper]['food_id'], $search_result[$looper]['country_id']).'</span><br>'
                     . '<span class="postedBy">Posted By '.$this->getRecipePostUser($search_result[$looper]['user_id']).'</span>
                        </div>';
         }
         
         return $output;
     }
     
     private function getLinkedRecipeTitle($recipe_title, $user_id, $food_id, $country_id)
     {
         $zero = '0';
         $linkedTitle = '';
         if($user_id === $zero)
         {
             $linkedTitle = '<a href="'.URL.'foodfinder/meal/'.$this->getFoodName($food_id).'/'.$this->getCountryName($country_id).'">'.$recipe_title.'</a>';
         }
         else
         {
             $linkedTitle = '<a href="'.URL.'profile/user/'.$this->view->encrypt($user_id).'">'.$recipe_title.'</a>';
         }
         
         return $linkedTitle;
     }
     
     private function getRecipePostUser($user_id){
         $enri = 'ENRI';
         if($user_id === '0'){
             return $enri;
             
         }
         else{
             return $this->getUserFirstName($user_id).' '.$this->getUserLastName($user_id);
         }
     }
     
     
     public function searchForFood($search_val)
     {
        $sql = "SELECT FC.food_name, FC.country_names, F.food_picture
                FROM food_country AS FC
                INNER JOIN food AS F ON FC.food_name = F.food_name
                WHERE FC.food_name LIKE  '%$search_val%'";
        $sth = $this->db->Sdb->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute();
        
        $search_result = $sth->fetchAll();
         
        echo $this->loadFoodSearchResult($search_result);
     }
     
      private function loadFoodSearchResult($search_result)
      {
          $output = '';
         
         for($looper = 0; $looper < count($search_result); $looper++)
         {
             $output .='<div class="foodSearchResult">
                        <img src="data:image/jpeg;base64,'.base64_encode($search_result[$looper]['food_picture']).'" width="50" height="50">'
                     . '<span class="food_name"><a href="'.URL.'foodfinder/food/'.$search_result[$looper]['country_names'].'">'.$search_result[$looper]['food_name'].'</a></span><br>'
                     . '<span class="country_name">Location '.$search_result[$looper]['country_names'].'</span>
                        </div>';
         }
         
         return $output;
      }
     
     public function searchForProducts($search_val) 
     {
         $sql = "SELECT FP.product_name, FP.food_name, FP.country_names, P.product_picture
                 FROM food_products AS FP
                 INNER JOIN products AS P ON FP.product_name = P.product_name
                 WHERE FP.product_name LIKE  '%$search_val%'";
         
         $sth = $this->db->Sdb->prepare($sql);
         $sth->setFetchMode(PDO::FETCH_ASSOC);
         $sth->execute();
        
        $search_result = $sth->fetchAll();
        echo $this->loadProductsSearchResult($search_result);
     }
     
     private function loadProductsSearchResult($search_result)
     {
         
          $output = '';
         
         for($looper = 0; $looper < count($search_result); $looper++)
         {
             $output .=' <div class="productSearchResult">
                        <img src="data:image/jpeg;base64,'.base64_encode($search_result[$looper]['product_picture']).'" width="50" height="50">'
                     . '<span class="product_name"><a href="'.URL.'/foodfinder/meal/'.$search_result[$looper]['food_name'].'/'.$search_result[$looper]['country_names'].'">'.$search_result[$looper]['product_name'].'</a></span><br>'
                     . '<span class="Food_country_names">Produced from the food '.$search_result[$looper]['food_name'].'.  Origin '.$search_result[$looper]['country_names'].'.</span>
                         </div>';
         }
         
         return $output;
     }
    
     
     public function searchForUsers($search_val, $search_for)
     {
        $user_type = $this->get_user_type($search_for);
        
        $sql = "SELECT user_id, FirstName, LastName, picture, user_type
                FROM user_details
                WHERE user_type = :userType
                AND (FirstName LIKE  '%$search_val%' || LastName LIKE  '%$search_val%')";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':userType'=> $user_type));
        
        $search_result = $sth->fetchAll();
        echo $this->loadUserSearchResult($search_result);
     }
     
     private function loadUserSearchResult($search_result)
     {
          
          $output = '';
         
         for($looper = 0; $looper < count($search_result); $looper++)
         {
             $output .=' <div class="userSearchResult">
                         '.$this->view->checkUserPicture($search_result[$looper]['picture'], 50, 50).'
                         <span class="names"><a href="'.URL.'profile/user/'.$this->view->encrypt($search_result[$looper]['user_id']).'">'.$search_result[$looper]['FirstName'].' '.$search_result[$looper]['LastName'].'</a></span><br>
                         <span class="user_type">'.$search_result[$looper]['user_type'].'<img src="'.URL.'pictures/verify.png" width="15" height="15" class="verify"></span>
                         </div>';
         }
         
         return $output;
     }
     
     private function get_user_type($search_for)
     {
          $foodies = 'FOODIES'; $chef = 'CHEFS'; $resaturants = 'RESTAURANTS'; $userType = '';
          
          if($search_for === $foodies)
          {
              $userType = 'Foodie';
          }
          else if($search_for === $chef)
          {
              $userType = 'Chef';
          }
          else if($search_for === $resaturants)
          {
              $userType = 'Restaurant';
          }
          
          return $userType;
     }
     

}

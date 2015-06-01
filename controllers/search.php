<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of search
 *
 * @author Uche
 */
class search extends Controller{
    //put your code here
    
     function __construct() {
          parent::__construct();
          $this->sessionCheck();
  
    }
    
    function index()
    {
          if(!isset($_POST['search_value'])){
            $_SESSION['from_search'] = false;
             $fileName = "error/logedinError/index";
            $this->view->renderLogedinError($fileName);
            return false;
        }
        
        $recipe = 'RECIPE'; $food = 'FOOD'; $foodies = 'FOODIES'; $chef = 'CHEFS'; $resaturants = 'RESTAURANTS';
        $products = 'PRODUCTS'; $search_for= '';
        
        if(isset($_POST['searchFor']))
        {
            $search_for = $_POST['searchFor'];
        }
        else {
            $search_for = $recipe;
        }
               
        $search_val = $_POST['search_value'] ;
        
        if(empty($search_val))
        {
            echo $this->SetDefaultSearchResult();
        }
        else{
                $_SESSION['from_search'] = true;
                if($search_for === $recipe){
                   $this->model->index($search_val, $search_for);
                }
                else if($search_for === $food)
                {
                    $this->model->searchForFood($search_val);
                }
                else if($search_for === $products)
                {
                    $this->model->searchForProducts($search_val);
                }
                else{
                    $this->model->searchForUsers($search_val, $search_for);
                }
        }
        
      
    }
    
  private  function SetDefaultSearchResult()
   {
        $recipe = 'RECIPE'; $food = 'FOOD'; $foodies = 'FOODIES'; $chef = 'CHEFS'; $resaturants = 'RESTAURANTS';
        $products = 'PRODUCTS';
     $defaultSR = '<ul id="searchChoices">
                       <li onclick="getWhatTosearchFor(\''.$recipe.'\')"><img src="'.URL.'pictures/search/ENRI_RECIPE.png" width="30" height="30"><span>Recipe</span></li>
                        <li onclick="getWhatTosearchFor(\''.$food.'\')"><img src="'.URL.'pictures/search/ENRI_FOOD.png" width="30" height="30"><span>Food</span></li>
                        <li onclick="getWhatTosearchFor(\''.$products.'\')"><img src="'.URL.'pictures/search/ENRI_PRODUCT_ICONS.png" width="30" height="30"><span>Products</span></li>
                        <li onclick="getWhatTosearchFor(\''.$foodies.'\')"><img src="'.URL.'pictures/search/ENRI_friends_follow.png" width="30" height="30"><span>Foodies</span></li>
                        <li onclick="getWhatTosearchFor(\''.$chef.'\')"><img src="'.URL.'pictures/search/ENRI_CHEF.png" width="30" height="30"><span>Chefs</span></li>
                        <li onclick="getWhatTosearchFor(\''.$resaturants.'\')"><img src="'.URL.'pictures/search/ENRI_REST.png" width="30" height="30"><span>Restaurants</span></li>
                    </ul>';
       $_SESSION['from_search'] = true;
    return $defaultSR;
 
}
}

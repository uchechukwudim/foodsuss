<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of restaurantProfileAboutMe_model
 *
 * @author Uche
 */
class restaurantProfileAboutMe_model extends Model{
    //put your code here
    function __construct() {
        parent::__construct();
         $this->id = $this->getUserID(Session::get('user'));
        $this->FirstName = $this->getUserFirstName($this->id);
        $this->email = $_SESSION['user'];
    }
    
   public function restaurantAboutMe($userId)
   {
       if($userId){
           //load about me for users
           $sql = "SELECT * FROM restaurant_users WHERE user_id = :user_id";
           $sth = $this->db->prepare($sql);
           $sth->setFetchMode(PDO::FETCH_ASSOC);
           $sth->execute(array(':user_id'=>$userId));
           
           $restuarantDetails = $sth->fetchAll();
           $this->loadrestuarantDetails($restuarantDetails);
           die();
           
       }
       else{
           // load my about me
            $sql = "SELECT * FROM restaurant_users WHERE user_id = :user_id";
           $sth = $this->db->prepare($sql);
           $sth->setFetchMode(PDO::FETCH_ASSOC);
           $sth->execute(array(':user_id'=>  $this->id));
           
           $restuarantDetails = $sth->fetchAll();
    
          
          $this->loadrestuarantDetails($restuarantDetails);
           die();
       }
   }
   
   private function loadrestuarantDetails($restuarantDetails)
   {
        $editImageTitle = 'click to edit. double click to save edited text';
       $output = '<script>
          
                         initializee();
                         codeAddress(\''.$restuarantDetails[ZERO]['city'].'\');
                    </script>
                <div id="meHolder">
                    <div id="About">
                        
                        <div id="aboutHeader">About Us <img src="'.URL.'pictures/profile/pen_edit.png" width="10" height="10" title="'.$editImageTitle.'""></div>
                        <div id="aboutText">
                          '.  $this->view->getAboutUsData($restuarantDetails[0]['about_us']).'
                        </div>
                        
                    </div>
                    
                    <div id="location">
                         <div id="LocationHeader">Location</div>
                          <div id="LocationText">
                              <div id="mobile"><b>phone:</b><div id="Mh">'.$restuarantDetails[0]['phone'].'</div></div>
                              <div id="address"><b>address:</b><div id="Ah">'.$restuarantDetails[0]['address'].'</div></div>
                              <div id="currentLocation"><b>current city:</b><div id="CCh">'.$restuarantDetails[0]['city'].'</div></div>     
                                  <div id="FromLoc"><b>opening times</b><div id="Fmh">'.$restuarantDetails[0]['opening_times'].'</div></div>
                              <div id="email"><b>email:</b><div id="Eh">'.$restuarantDetails[ZERO]['restaurant_email'].'</div></div>
                        </div>
                    </div>
                    <div id="map-canvas"></div>
                    
                    <div id="cuisine">
                         <div id="cuisineHeader">Cuisine<img src="'.URL.'pictures/profile/pen_edit.png" width="10" height="10" title="'.$editImageTitle.'"></div>
                         <div id="cuisineText" onkeyup="processInputsFromAbout(event)" >
                          '.$this->view->getRestfavoriteData($restuarantDetails[0]['cuisins'], $type= 'Cuisine').'
                        </div>
                    </div>
                    
                    <div id="mostFood">
                         <div id="mostFoodHeader">Most use Foods<img src="'.URL.'pictures/profile/pen_edit.png" width="10" height="10" title="'.$editImageTitle.'"></div>
                         <div id="mostFoodText">
                              '.$this->view->getRestfavoriteData($restuarantDetails[0]['food_specialty'], $type= 'Foods').'
                         </div>
                    </div>
                    
                    <div id="mostIngredients">
                         <div id="mostIngredientsHeader">Most use Ingredients<img src="'.URL.'pictures/profile/pen_edit.png" width="10" height="10" title="'.$editImageTitle.'"></div>
                         <div id="mostIngredientsText">
                              '.$this->view->getRestfavoriteData($restuarantDetails[0]['most_used_Ingrdient'], $type= 'Ingredients').'
                         </div>
                    </div>
                    
                    <div id="mostRecipes">
                         <div id="mostRecipesHeader">Most ordered menu item<img src="'.URL.'pictures/profile/pen_edit.png" width="10" height="10" title="'.$editImageTitle.'"></div>
                         <div id="mostRecipesText">
                             '.$this->view->getRestfavoriteData($restuarantDetails[0]['most_used_recipe'], $type= 'Recipes').'
                         </div>
                    </div>
                    

                </div>';
        
        echo json_encode($output);
        
    }
    
  
    public function sendResAboutInfoToServer($postText, $userDetailscolumn)
    {
         $sql = "UPDATE  `enri_users`.`restaurant_users` SET  `".$userDetailscolumn."` =  :postText WHERE  `restaurant_users`.`user_id` = :user_id";
        
        $sth = $this->db->prepare($sql);
       if( $sth->execute(array(
           ":postText" =>$postText,
           ":user_id" => $this->id
        ))){
           echo json_encode(true);
       }
       else
       {
           echo json_encode($sth->errorInfo());
       }
    }
}

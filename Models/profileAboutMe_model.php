<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of profileAboutMe_model
 *
 * @author Uche
 */
class profileAboutMe_model extends profile_model {
    //put your code here
    function __construct() {
        parent::__construct();
        
        $this->id = $this->getUserID(Session::get('user'));
        $this->FirstName = $this->getUserFirstName($this->id);
        $this->email = $_SESSION['user'];
    }
    
    public function AboutMe($userId='')
    {
          //getting user details here
        
        if($userId){
            $sql = "SELECT * FROM user_details WHERE user_id = :user_id";

           $sth = $this->db->prepare($sql);
           $sth->setFetchMode(PDO::FETCH_ASSOC);

           $sth->execute(array(
               ':user_id' => $userId
           ));
          $email = $this->getEmail($userId);
           $userDetails = $sth->fetchAll();
           $this->loadAboutMe($userDetails, $email, $userId);
        }
        else
        {
              $sql = "SELECT * FROM user_details WHERE user_id = :user_id";
         
                $sth = $this->db->prepare($sql);
                $sth->setFetchMode(PDO::FETCH_ASSOC);

                $sth->execute(array(
                    ':user_id' => $this->id
                ));

                $userDetails = $sth->fetchAll();
                $email = $this->getEmail($this->id);
                $this->loadAboutMe($userDetails, $email, $userId);
        }
       
        
    }
    
    private function loadAboutMe($userDetails, $email='', $user_id)
    {
        $editImageTitle = 'click to edit. double click to save edited text';
        $output = '<script>
                         initializee();
                         codeAddress(\''.$userDetails[ZERO]['city'].'\');
                    </script>
                    <div id="meHolder">
                    <div id="About"> 
                        <div id="aboutHeader">About Me <img src="'.URL.'pictures/profile/pen_edit.png" width="10" height="10" title="'.$editImageTitle.'"></div>
                        <div id="aboutText">
                          '.  $this->getAboutUsData($userDetails[0]['About_me'], $user_id).'
                        </div>
                        
                    </div>
                    
                    <div id="location">
                         <div id="LocationHeader">Location</div>
                          <div id="LocationText">
                              <div id="mobile"><b>Mobile:</b><div id="Mh">'.$userDetails[0]['Mobile'].'</div></div>
                              <div id="address"><b>Address:</b><div id="Ah">'.$userDetails[0]['address'].'</div></div>
                              <div id="currentLocation"><b>Current city:</b><div id="CCh">'.$userDetails[0]['city'].'</div></div>
                              <div id="FromLoc"><b>From:</b><div id="Fmh">'.$userDetails[0]['town'].'</div></div>
                              <div id="email"><b>Email:</b><div id="Eh">'.$email.'</div></div>
                        </div>
                    </div>
                    <div id="map-canvas"></div>
                    <div id="favFood">
                         <div id="favFoodHeader">Favorite Foods <img src="'.URL.'pictures/profile/pen_edit.png" width="10" height="10" title="'.$editImageTitle.'"></div>
                         <div id="favFoodText">
                          '.$this->getfavoriteData($userDetails[0]['favorite_foods'], $type= 'Foods', $user_id).'
                        </div>
                    </div>
                    
                    <div id="favRestuarant">
                         <div id="favRestuarantHeader">Favorite Restaurant<img src="'.URL.'pictures/profile/pen_edit.png" width="10" height="10" title="'.$editImageTitle.'"></div>
                         <div id="favRestuaranText">
                              '.$this->getfavoriteData($userDetails[0]['favorite_restaurant'], $type= 'Restaurants', $user_id).'
                         </div>
                    </div>
                    
                    <div id="favIngredients">
                         <div id="favIngredientsHeader">Favorite Ingredients<img src="'.URL.'pictures/profile/pen_edit.png" width="10" height="10" title="'.$editImageTitle.'"></div>
                         <div id="favIngredientsText">
                              '.$this->getfavoriteData($userDetails[0]['favorite_ingredient'], $type= 'Ingredients', $user_id).'
                         </div>
                    </div>
                    
                    <div id="favRecipes">
                         <div id="favRecipesHeader">Favorite Recipes<img src="'.URL.'pictures/profile/pen_edit.png" width="10" height="10" title="'.$editImageTitle.'"></div>
                         <div id="favRecipesText">
                             '.$this->getfavoriteData($userDetails[0]['favorite_recipes'], $type= 'Recipes', $user_id).'
                         </div>
                    </div>
                    

                </div>';
        
        echo json_encode($output);
        
    }
    
    private function getfavoriteData($favData, $type, $user_id)
    {
        if(!empty($favData))
        {
            return $favData;
        }
        else if(empty($favData) && !empty($user_id)){
             return "No Favorite $type";
        }
        else 
        {
            return "No Favorite $type. Edit your Favorite ".$type.".";
        }
    }
    
     private function getAboutUsData($abousUs, $user_id)
    {
        if(!empty($abousUs))
        {
            return $abousUs;
        }
        else if(empty($abousUs) && !empty($user_id)){
             return "No About Me";
        }
        else 
        {
            return "No About Me. Edit your About Me.";
        }
    }
    
    public function sendLocationInfoToServer($postText, $userDetailscolumn)
    {
        $sql = "UPDATE  `enri_users`.`user_details` SET  `".$userDetailscolumn."` =  :postText WHERE  `user_details`.`user_details_id` = :user_id";
        
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

<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of C_Url
 *
 * @author Uche
 */
class C_Url {
    //put your code here
    
    public function __construct() {
 
           try{
                $this->ch = curl_init();
                if(FALSE === $this->ch)
                     throw new Exception('failed to initialize');

            }catch(Exception $e){

                  trigger_error(sprintf(
                      'Curl failed with error #%d: %s',
                      $e->getCode(), $e->getMessage()),
                      E_USER_ERROR);
            }
    }
    
    public function getFoodShops($RecipeInfo, $user_location){
              
        $url = 'https://maps.googleapis.com/maps/api/place/textsearch/json?query='.$RecipeInfo.'+foodshop+in+'.$user_location.'&type=food|grocery_or_supermarket|store&key=AIzaSyDSsNwqvTZyPW2MN-ucJxMctb2a_06x7R0';
        curl_setopt($this->ch, CURLOPT_URL, $url);
        curl_setopt($this->ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($this->ch, CURLOPT_SSL_VERIFYPEER, false);
        $content = json_decode(curl_exec($this->ch), true);
        
        if (FALSE === $content)
            throw new Exception(curl_error($this->ch), curl_errno($this->ch));
        
       // var_dump(json_decode($content, true));
        return $content['results'];
    }
    
    
}

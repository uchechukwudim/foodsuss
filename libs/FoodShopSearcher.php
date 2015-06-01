<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of FoodShopSearcher
 *
 * @author Uche
 */
class FoodShopSearcher {
    //put your code here
    function __construct() {
       
       
       if($xml = simplexml_load_file('https://maps.googleapis.com/maps/api/place/textsearch/xml?query=restaurants+in+Sydney&key=AIzaSyDSsNwqvTZyPW2MN-ucJxMctb2a_06x7R0')){
       var_dump($xml);
       }
       else{
           echo "no internet";
       }
    }
}

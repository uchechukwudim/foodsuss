<?php
require 'CypeSimpledbConnect.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Places
 *
 * @author Uche
 */

$places = new Places();
$places->CheckPlaces();

 if($places->placesCount > 0)
 {
     header( "refresh:$places->seconds;Places.php" );
 }

class Places {
  private $cSimpledb ;
  public $placesCount ;
  public  $seconds = 100;
    function __construct(){ 
      $this->cSimpledb =  new CypeSimpledbConnect();
      $this->placesCount= $this->cSimpledb->CheckPlacesIsUedWithNoCount();
   }
 
   function CheckPlaces()
   {
         require 'index.php';
  
   }
}

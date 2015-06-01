<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of CypeSimpledbConnect
 *
 * @author Uche
 */
require 'aws-autoloader.php';
use Aws\SimpleDb\SimpleDbClient;

class CypeSimpledbConnect {
 
    private  $key_Id = "AKIAIQIPCBB22ONWI4OQ";
    private  $secret_key = "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";
    private  $region = 'us-west-2';
    private $client;
    private $cities;
    
    function __construct()
    { 
     
        $this->client = SimpleDbClient::factory(array(
            'key'    => $this->key_Id,
            'secret' => $this->secret_key,
            'region'  => $this->region
         ));
   }
   
   function creatdomain($DomainName)
   {
       $this->client->createDomain(array('DomainName' => $DomainName));
   }
   
   function PutIntoClubBar($itemName, $id, $club_logo, $club_name, $club_address, $city, $country)
   {
        $this->client->putAttributes(array(
        'DomainName' => 'clubs_bars',
        'ItemName'   => $itemName,
        'Attributes' => array(
            array('Name'=>'id', 'Value'=> $itemName),
            array('Name'=>'club_name', 'Value' => $club_name),
            array('Name'=>'club_logo', 'Value' => $club_logo),
            array('Name'=>'club_address', 'Value' => $club_address),
            array('Name'=> 'city', 'Value'=> $city),
            array('Name'=>'country', 'Value'=> $country),
            )
        ));
      
       $sql = "select id from places where city='".$city."'";
       $result = $this->SQLQuery($sql);
       $item = $result['Items'];
       $itName = $item[0]['Name'];
       $isUsed = "Yes";
      $this->PutIntoPlaces($itName, $isUsed);
       echo json_encode($itName);
   }
   
   function CheckPlacesIsUedWithNoCount()
   {
       $sql = "select * from places where isUsed='No'";
       $result = $this->SQLQuery($sql);
       
       return count($result['Items']);
   }
   function PutIntoPlaces($itemName, $isUsed)
   {
        $this->client->putAttributes(array(
        'DomainName' => 'places',
        'ItemName'   => $itemName,
        'Attributes' => array(
            array('Name'=>'isUsed', 'Value'=> $isUsed, 'Replace'=> true),
            )
        ));
   }
   
   function SQLQuery($sql)
   {
       $result = $this->client->select(array(
        'SelectExpression' => $sql
       ));
       
       return $result;
   }
    
   function SQLQueryResultForPlacesDomain()
   {
       $count = 0;
        $sql = "select city from places where isUsed = 'No' limit 1";
        $result = $this->SQLQuery($sql);
        
        foreach($result['Items'] as $item)
        {
           $this->cities[$count] = $item['Attributes'][0]['Value'];
           $count++;
        }
        
        return $this->cities;
    }
    
    private function getAttribute($result)
    {
        $item = $result['Items'];
        $id = $item[0]['Name'];
        
        return $id;
    }
      
   
   
   
   function SqlIteratorQuery($sql)
   {
       $iterator = $this->client->getIterator('Select', array(
        'SelectExpression' => $sql
        ));
       
       return $iterator;
   }
  
   
   function IncreaseId()
   {
       $sql = "select id from `clubs_bars` where id is not null order by id desc limit 1";
       $result = $this->SQLQuery($sql);
       
       $item = $result['Items'];
       $Id = $item[0]['Name'];
       
       if($Id)
       {
           return $this->zero_padding($Id);
       }
       else{
           return $this->zero_padding(0);
       }
       
   }
   
   function zero_padding($no_zeros_id) {
	  $zero_padded_id = "";

	    $id_length = strlen($no_zeros_id);
	    if ($id_length == 1) {
	        $zero_padded_id = "00000".$no_zeros_id; 
	    } else if ($id_length == 2) {
	        $zero_padded_id = "0000".$no_zeros_id;
	    } else if ($id_length == 3) {
	        $zero_padded_id = "000".$no_zeros_id;
	    } else if ($id_length == 4) {
	        $zero_padded_id = "00".$no_zeros_id;
	    } else if ($id_length == 5) {
	        $zero_padded_id = "0".$no_zeros_id;
	    } else if ($id_length == 6) {
	        $zero_padded_id = $no_zeros_id;
	    }

	    return $zero_padded_id;
	}
        
   function Tester()
   {
       $domains = $this->client->getIterator('ListDomains')->toArray();
     var_export($domains);
   }
   
}

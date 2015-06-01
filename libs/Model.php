<?php
use Mailgun\Mailgun;
class Model {

    function __construct() {
        $this->db = new database();
         $this->view = new View(); //instanciate it here as every controller passes through this this
         $this->notification = new notification();
         $this->userSwitch = 0;
          $this->enrypter = array(525250.22,625315.14,825020.24,4253290.34,125345.54);
    }
 
    public function getUserDetails($user_id)
    {
         $sql = "SELECT FirstName, LastName, picture FROM user_details WHERE user_id = :user_id";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(':user_id'=> $user_id));
        
        $userDetails = $sth->fetchAll();
        
        return $userDetails;
    }
      //getting user details functions starts here::::::::::::::::::::::::
    function getUserID($Email)
    {
        $sql = "SELECT user_id FROM users WHERE user_email= :email";
        
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ':email' => $Email
        ));
        $data  = $sth->fetchAll(PDO::FETCH_ASSOC);
        
        return $data[0]['user_id'];
    }
    
    function getEmail($user_id)
    {
        $sql = "SELECT user_email FROM users WHERE user_id = :user_id";
        
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ':user_id' => $user_id
        ));
        $data  = $sth->fetchAll(PDO::FETCH_ASSOC);
        
        return $data[0]['user_email'];
    }
    
    public function getUserFirstName($userid)
    {
        $sql = "SELECT FirstName FROM  user_details WHERE user_id= :id";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ':id' => $userid
        ));
        $data  = $sth->fetchAll(PDO::FETCH_ASSOC);
        
        return $data[0]['FirstName'];
    }
    
 
    public function getUserLastName($userid)
    {
        $sql = "SELECT LastName FROM  user_details WHERE user_id= :id";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ':id' => $userid
        ));
        $data  = $sth->fetchAll(PDO::FETCH_ASSOC);
        
        return $data[0]['LastName'];
    }
    
    public function getDOB($userId)
    {
        $sql = "SELECT DOB FROM user_details WHERE user_id = :userId";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ':userId' => $userId
        ));
        
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $data[ZERO]['DOB'];
        
    }
    
    public function getUserImage($userId)
    {
        $sql = "SELECT picture FROM user_details WHERE user_id = :userId";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ':userId' => $userId
        ));
        
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $data[0]['picture'];
        
    }
    
    public function getUserType($userId)
    {
        $sql = "SELECT user_type FROM user_details WHERE user_id = :userId";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ':userId' => $userId
        ));
        
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $data[0]['user_type'];
        
    }
    
     public function getUserCity($userId)
    {
        $sql = "SELECT city FROM user_details WHERE user_id = :userId";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ':userId' => $userId
        ));
        
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $data[0]['city'];
        
    }
    
     public function getUserCountry($userId)
    {
        $sql = "SELECT country FROM user_details WHERE user_id = :userId";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ':userId' => $userId
        ));
        
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        return $data[0]['country'];
        
    }
    
    public function getCountryNationality($country){
        $sql = "SELECT nationality FROM countriesandnationalitites WHERE country_name = :country";
        $sth = $this->db->Sdb->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(":country" => $country));
        
        $Country = $sth->fetchAll();
        
        return $Country[0]['nationality'];
    }
    
    //getting user details functions end here::::::::::::::::::::::::
    
    //getting foodfinder details 
    function getContinent($country_name)
    {
        $sql = "SELECT continent_id FROM country WHERE country_names = :country";
        
        $sth = $this->db->Sdb->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ':country' =>  $country_name
        ));
        
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        
        return $data[0]["continent_id"];
    }
    
    function getCountryID($country_name)
    {
        $sql = "SELECT country_id FROM country where country_names = :countryName";
        $sth = $this->db->Sdb->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ":countryName" => $country_name
        ));
        
         $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        
         return $data[0]["country_id"];
    }
    
     function getCountryName($country_id)
     {
        $sql = "SELECT country_names FROM country where country_id = :countryId";
        $sth = $this->db->Sdb->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ":countryId" => $country_id
        ));
        
         $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        
         return $data[0]["country_names"];
     }
     function getCountryFlagPicture($countryName)
     {
        $sql = "SELECT flag_picture FROM country where country_names = :country_names";
        $sth = $this->db->Sdb->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ":country_names" => $countryName
        ));
        
         $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        
         return $data[0]["flag_picture"];
     }
    
    
    function getRecipeId($recipeName)
    {
        $sql = "SELECT recipe_id FROM recipes WHERE recipe_title = :RecipeTitle";
        $sth = $this->db->Sdb->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ':RecipeTitle' => $recipeName
        ));
        
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        
        return $data[0]['recipe_id'];
    }  
    
    function getRecipeName($recipe_id)
    {
        $sql = "SELECT recipe_title FROM recipes WHERE recipe_id = :RecipeId";
        $sth = $this->db->Sdb->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ':RecipeId' => $recipe_id
        ));
        
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        
        return $data[0]['recipe_title'];
    }
    
    
     function getRecipePostId($hashTagTitle)
    {
        $sql = "SELECT recipe_post_id FROM recipe_post WHERE recipe_title = :recipe_title";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ':recipe_title' => "$hashTagTitle"
        ));
        
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        
        return $data[0]['recipe_post_id'];
    }
    
       
     function getRecipePostTitle($recipe_post_id)
    {
        $sql = "SELECT recipe_title FROM recipe_post WHERE recipe_post_id = :recipe_post_id";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ':recipe_post_id' => $recipe_post_id
        ));
        
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        
        return $data[0]['recipe_title'];
    }
    public function getRecipePostCountry($recipe_post_id){
        $sql = "SELECT country_id FROM recipe_post WHERE recipe_post_id = :recipe_post_id";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ':recipe_post_id' => $recipe_post_id
        ));
        
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        
        return $this->getCountryName($data[0]['country_id']);
    }
    
    function getFoodId($foodname)
    {
       $sql = "SELECT food_id FROM food WHERE food_name = :foodName";
        $sth = $this->db->Sdb->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ':foodName' => $foodname
        ));
        
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
        if($data){
            return $data[0]['food_id'];
        }else{
            return EMPTYSTRING;
        }
        
    }
    
     function getFoodName($food_id)
    {
       $sql = "SELECT food_name FROM food WHERE food_id = :foodId";
        $sth = $this->db->Sdb->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ':foodId' => $food_id
        ));
        
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
       
        return $data[0]['food_name'];
    }
    
    function getFoodPicture($food_name)
    {
       $sql = "SELECT food_picture FROM food WHERE food_name = :foodName";
        $sth = $this->db->Sdb->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ':foodName' => $food_name
        ));
        
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
       
        return $data[0]['food_picture'];
    }
    
    public function getProductId($product_name){
        $sql = "SELECT product_id FROM products WHERE product_name = :product_name";
        $sth = $this->db->Sdb->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ':product_name' => $product_name
        ));
        
        $data = $sth->fetchAll(PDO::FETCH_ASSOC);
       
        return $data[0]['product_id'];
    }
    
     public function getRestuarantName($user_id)
     {
         $sql = "SELECT restaurant_name FROM restaurant_users WHERE user_id = :userId";
        $sth = $this->db->prepare($sql);
        $sth->setFetchMode(PDO::FETCH_ASSOC);
        $sth->execute(array(
            ':userId' => $user_id
        ));
        
        $data = $sth->fetchAll();
         if($data){
            return $data[0]['restaurant_name'];
            
         }else{
            return EMPTYSTRING;
        }
        
     }
     
    
     
     public function getUserFLNameOrRestNameOrEstName($user_id)
     {
         $res = "Restaurant"; $est = "Establishment";
         $user_type = $this->getUserType($user_id);
         
         if($user_type === $res)
         {
             return $this->getRestuarantName($user_id);
         }
         else
         {
             return $this->getUserFirstName($user_id)." ".$this->getUserLastName($user_id);
         }
         
     }


     public function checkForFriendUser_id($thisUserId, $user_id, $friend_user_id)
     {
         if((int)$user_id === (int)$thisUserId)
         {
           
             return (int)$friend_user_id;
         }
         else if((int)$user_id !== (int)$thisUserId)
         {
       
             return (int)$user_id;
         }
     }
    
     
    function SCTSurfix($data, $whichPl, $whichSig)
    {
        if($data == 1)
        {
            return $data." ".$whichSig;
        }
        else 
        {
            return $data." ".$whichPl;
        }
    }
    
  function timeCounter($posttime){
    $suffix = '';
    $currentTim = time();
    $timeDiff = $currentTim - $posttime;
    
    switch(1)
    {
        case ($timeDiff < 60):
          $count = $timeDiff;
            
            if($count==0)
                $count = "a moment";
            else if($count==1)
                $suffix = "second";
            else 
                $suffix = "seconds";
            
         break;
         
        case ($timeDiff > 60 && $timeDiff < 3600):
          $count = floor($timeDiff/60);
           if($count==1)
                $suffix = "Minute";
            else 
                $suffix = "Minutes";
            
         break;
         
          case ($timeDiff > 3600 && $timeDiff < 86400):
                $count = floor($timeDiff/3600);
             if($count==1)
                  $suffix = "hour";
              else 
                  $suffix = "hours";       
         break;
         
         case ($timeDiff > 86400 && $timeDiff < 604800):
                $count = floor($timeDiff/86400);
             if($count==1)
                  $suffix = "day";
              else 
                  $suffix = "days";
              
         break;
         
          case ($timeDiff > 604800 && $timeDiff < 2629743):
                $count = floor($timeDiff/604800);
             if($count==1)
                  $suffix = "week";
              else 
                  $suffix = "weeks";
              
         break;
         
         case ($timeDiff > 2629743 && $timeDiff < 31556926):
                $count = floor($timeDiff/2629743);
             if($count==1)
                  $suffix = "month";
              else 
                  $suffix = "months";
              
         break;
         
         case ($timeDiff > 31556926):
                $count = floor($timeDiff/31556926);
             if($count==1)
                  $suffix = "year";
              else 
                  $suffix = "years";
              
         break;
    }

        return "Posted ".$count." ".$suffix." ago";
 }
 
public  function encrypt($sData)
{
    $val = rand(ZERO, 4);

    $encrpter = $this->enrypter[$val];
    $id =(double)$sData*$encrpter;

   return base64_encode($id).$val;
}

   public function post_statsSurfix($number){
        $oneBil = "1b+";
        if($number > 999 && $number <= 9999){
            return $this->checkHunInThou($number);
        }
        else if( $number > 9999 && $number <= 99999){
            return $this->checkHunInTensThous($number);
        }else if($number > 99999 && $number <= 999999){
            return $this-> checkHunInHunThous($number);
        }else if($number > 999999 && $number <= 9999999){
            return $this->checkMill($number);
        }else if($number > 9999999 && $number <= 99999999){
            return $this->checkTensMill($number);
        }else if($number > 99999999 && $number <= 999999999){
            return $this->checkHunsMill($number);
        }else if($number > 999999999 && $number <= 9999999999){
            return $oneBil ;
        }else{
            return $number;
        }
            
        
    }
    
    
   private function checkHunInThou($number){
       $one = 1;
       $strNum = $number."";
       
       if((int)$strNum[$one] > ZERO )
       {
           return (int)$strNum[ZERO].".".(int)$strNum[$one]."k" ;
       }else if((int)$strNum[$one] === ZERO ){
            return (int)$strNum[ZERO]."k";
       }
    
   }
   
   private function checkHunInTensThous($number){
        $two = 2;
        $one = 1;
        $strNum = $number."";
        
        if((int)$strNum[$two] > ZERO ){
            return (int)$strNum[ZERO]."".(int)$strNum[$one].".".(int)$strNum[$two]."k";
        }else if((int)$strNum[$two] === ZERO){
            return (int)$strNum[ZERO]."".(int)$strNum[$one]."k";
        }
   }
   private function checkHunInHunThous($number){
        $two = 2;
        $one = 1;
        $strNum = $number."";
        return (int)$strNum[ZERO]."".(int)$strNum[$one]."".(int)$strNum[$two]."k";
   }
   
   private function checkMill($number){
        $one = 1;
        $strNum = $number."";
        
        if((int)$strNum[$one] > ZERO){
            return (int)$strNum[ZERO].".".(int)$strNum[$one]."m";
        }else if((int)$strNum[$one] === ZERO){
             return (int)$strNum[ZERO]."m";
        }
   }
   
   private function checkTensMill($number){
        $two = 2;
        $one = 1;
        $strNum = $number."";
        
        if((int)$strNum[$two] > ZERO){
            return (int)$strNum[ZERO]."".(int)$strNum[$one].".".(int)$strNum[$two]."m";
        }else{
             return (int)$strNum[ZERO]."".(int)$strNum[$one]."m";
        }
        
   }
   
   private function checkHunsMill($number){
        $two = 2;
        $one = 1;
        $strNum = $number."";
        return (int)$strNum[ZERO]."".(int)$strNum[$one]."".(int)$strNum[$two]."m";
   }
   
     function verify($to, $subject, $message, $header, $name){
         return $this->send_mail($to, $subject, $message, $header, $name);
     }
     
     public function send_mail($to,$subject,$message,$header, $name){
            $API_KEY = "key-e3b26a3500b85a05b2364458cd7238a1";
         
            # Instantiate the client.
            $mgClient = new Mailgun($API_KEY);
            $domain = "enrifinder.com";

            # Make the call to the client.
            $result = $mgClient->sendMessage($domain, array(
                'from'    => 'enri '.$header,
                'to'      => $to,
                'subject' => $subject,
                'text'    => '',
                'html'    => $message
            ), array(
                'inline' => array(ENRILOGO)
            ));
         
            if($result){
                return true;
            }else{
                return false;
            }
    }
        
    public function send_relationship_mail($to, $subject, $message, $header, $name, $user_picture_path, $user_pic_name){

                $API_KEY = "key-e3b26a3500b85a05b2364458cd7238a1";

                # Instantiate the client.
                $mgClient = new Mailgun($API_KEY);
                $domain = "enrifinder.com";

                # Make the call to the client.
                $result = $mgClient->sendMessage($domain, array(
                    'from'    => 'enri '.$header,
                    'to'      => $to,
                    'subject' => $subject,
                    'text'    => '',
                    'html'    => $message
                ), array(
                    'inline' => array(ENRILOGO, $user_picture_path)
                ));
                if($result){
                    unlink($user_picture_path);
                    return true;
                }else{
                    return false;
                }          
    }

        
        
         public function getRelationshipEmailBody($name, $subText, $buttonText, $to){
          

            $message = '
			<html>
			<head>
                         <meta charset="UTF-8">
			  <title></title>
			</head>
			<body >
			<table  bgcolor="whitesmoke"  width= "700px">
                            <tr>
                                <td colspan="3" width="500px" height ="500px" align="center">
                                                 <div id="contain" style="width: 600px; height:500px; background: white; margin-top: 50px;">
                                                                        <a href="'.URL.'"><img src ="cid:enri_logo.png" width="80" style="margin-right: 400px; margin-top: 10px; width: 80px; "></a>
                                                                        <div id="DetailsHolder" style="position: relative; top: 80px;  text-align: center;" >
                                                                                        <img src="cid:'.$to.'.png" width="100px" style="margin-bottom: 20px;">
                                                                                        <div style=" font-family: Arial; color: grey; font-size: 15px; margin-bottom:  20px ;"><b>'.$name.''. $subText .'</b></div>
                                                                                        <div style=" font-family: Arial; font-size: 1.125em; background: orangered; width: 150px; color: white; padding: 10px 5px 10px 5px; font-weight: 700; margin-bottom: 20px; margin-left: 220px;"><a style="text-decoration: none; color: white;" href="'.URL.'">'.$buttonText.'</a></div>
                                                                        </div>

                                                </div>
                                    <div style=" font-family: Arial; font-size: 0.75em; color: grey;  margin-top: 50px;  margin-bottom: 30px;"><span style="padding-bottom: 15px;">&copy; copyright 2015 Enri Inc All rights reserved.</span><br><br> 39 Circular road, Elekahia Estate, RV, 500102</div>
                                </td>
                            </tr>

                        </table>
			</body>
                        </html>
			';
            
            return $message;
        }
        
         public function getRecipeCommentEmailBody($name, $subText, $buttonText, $to){
          

            $message = '
			<html>
			<head>
                         <meta charset="UTF-8">
			  <title></title>
			</head>
			<body >
			<table  bgcolor="whitesmoke"  width= "700px">
                            <tr>
                                <td colspan="3" width="500px" height ="500px" align="center">
                                                 <div id="contain" style="width: 600px; height:500px; background: white; margin-top: 50px;">
                                                                        <a href="'.URL.'"><img src ="cid:enri_logo.png" width="80" style="margin-right: 400px; margin-top: 10px; width: 80px; "></a>
                                                                        <div id="DetailsHolder" style="position: relative; top: 80px;  text-align: center;" >
                                                                                        <img src="cid:'.$to.'.png" width="100px" style="margin-bottom: 20px;">
                                                                                        <div style=" font-family: Arial; color: grey; font-size: 15px; margin-bottom:  20px ;"><b>'.$name.''. $subText .'</b></div>
                                                                                        <div style=" font-family: Arial; font-size: 1.125em; background: orangered; width: 150px; color: white; padding: 10px 5px 10px 5px; font-weight: 700; margin-bottom: 20px; margin-left: 220px;"><a style="text-decoration: none; color: white;" href="'.URL.'">'.$buttonText.'</a></div>
                                                                        </div>

                                                </div>
                                    <div style=" font-family: Arial; font-size: 0.75em; color: grey;  margin-top: 50px;  margin-bottom: 30px;"><span style="padding-bottom: 15px;">&copy; copyright 2015 Enri Inc All rights reserved.</span><br><br> 39 Circular road, Elekahia Estate, RV, 500102</div>
                                </td>
                            </tr>

                        </table>
			</body>
                        </html>
			';
            
            return $message;
        }
 
}
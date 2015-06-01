<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$authcode= $_GET["code"];

$clientid='724459132357-q0cfvt8li65pdc3cf9nnhon0g2urur9j.apps.googleusercontent.com';

$clientsecret='AF1bi9uBdAg7qAs-hwnAQmRy';

//Add your redirect URl

$redirecturi='http://enrifinder.com/libs/GmailContactList.php'; //change to localhost

$fields=array(

'code'=>  urlencode($authcode),

'client_id'=>  urlencode($clientid),

'client_secret'=>  urlencode($clientsecret),

'redirect_uri'=>  urlencode($redirecturi),

'grant_type'=>  urlencode('authorization_code')

);

//url-ify the data for the POST

$fields_string='';

foreach($fields as $key=>$value) { $fields_string .= $key.'='.$value.'&'; }

$fields_string=rtrim($fields_string,'&');

//open connection

$ch = curl_init();

//set the url, number of POST vars, POST data

curl_setopt($ch,CURLOPT_URL,'https://accounts.google.com/o/oauth2/token');

curl_setopt($ch,CURLOPT_POST,5);

curl_setopt($ch,CURLOPT_POSTFIELDS,$fields_string);

// Set so curl_exec returns the result instead of outputting it.

curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

//to trust any ssl certificates

curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

//execute post

$result = curl_exec($ch);

//close connection

curl_close($ch);

//extracting access_token from response string

$response   =  json_decode($result);

$accesstoken= $response->access_token;

 

if( $accesstoken!='')
    $_SESSION['token']= $accesstoken;

    //passing accesstoken to obtain contact details
    $urll = 'https://www.google.com/m8/feeds/contacts/default/full?max-results=20&oauth_token='. $_SESSION['token'];
    $xmlresponse = curl_file_get_contents($urll) ;
    var_dump($xmlresponse);
    //reading xml using SimpleXML
    echo "<h3>Email Addresses:</h3>";
    $xml = new SimpleXMLElement($xmlresponse);
    $xml->registerXPathNamespace('gd', 'http://schemas.google.com/g/2005');
    $result = $xml->xpath('//gd:email');
    foreach ($result as $title) {
            echo $title->attributes()->address . "<br>";
}


function curl_file_get_contents($url)
{
       $curl = curl_init();
       $userAgent = 'Mozilla/4.0 (compatible; MSIE 6.0; Windows NT 5.1; .NET CLR 1.1.4322)';
       curl_setopt($curl,CURLOPT_URL,$url);  //The URL to fetch. This can also be set when initializing      a session with curl_init().
       curl_setopt($curl,CURLOPT_RETURNTRANSFER,TRUE);//TRUE to return the transfer as a string of the return value of curl_exec() instead of outputting it out directly.
       curl_setopt($curl,CURLOPT_CONNECTTIMEOUT,5);   //The number of seconds to wait while trying to connect.
       curl_setopt($curl, CURLOPT_USERAGENT, $userAgent);  //The contents of the "User-Agent: " header to be used in a HTTP request.
       curl_setopt($curl, CURLOPT_FOLLOWLOCATION, TRUE);  //To follow any "Location: " header that the server sends as part of the HTTP header.
      curl_setopt($curl, CURLOPT_AUTOREFERER, TRUE);  //To automatically set the Referer: field in requests where it follows a Location: redirect.
      curl_setopt($curl, CURLOPT_TIMEOUT, 10);  //The maximum number of seconds to allow cURL functions to execute.
      curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, FALSE);  //To stop cURL from verifying the peer's certificate.
      $contents = curl_exec($curl);
      curl_close($curl);
      return $contents;
}

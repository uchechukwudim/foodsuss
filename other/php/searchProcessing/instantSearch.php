
<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <link rel="stylesheet" href="http://localhost/Css/countryListPage/loadCountries.css" type="text/css"   media="screen">
        <title></title>
    </head>
    <body>
<?php
include ("C:\wamp\path\mysql\SqlConnect.php");
include ("C:\wamp\path\searchBox\processRequest.php");


if(isset($_POST['searchval']) && isset($_POST['pages']) && isset($_POST['continent']))
{
    $search = $_POST['searchval'];  
    $pages = $_POST['pages'];
    $cont = $_POST['continent'];
    
    //calculate how man
    $sql = "SELECT country_names, map_picture, description FROM country WHERE country_names LIKE '%$search%'";
    $count =getNumberOfRows($sql);
    if($pages < $count)
    {
        loadPage($search, $pages, $cont);
    }
}
      
    
           
 

    

//:::::::::process search

?>
    </body>
</html>

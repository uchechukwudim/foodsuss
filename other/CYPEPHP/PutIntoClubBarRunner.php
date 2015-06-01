<?php
require 'CypeSimpledbConnect.php';
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$cSimpledb = new CypeSimpledbConnect();

if(isset($_POST['clubName']) && isset($_POST['clubAddress'])&& isset($_POST['clubLogo']) &&isset($_POST['clubCity']))
{
    $club_name = $_POST['clubName'];
    $club_logo =$_POST['clubLogo'];
    $club_address = $_POST['clubAddress'];
    $city = $_POST['clubCity'];
    $country = "";
  $id = $cSimpledb->IncreaseId();
  $id++;
  $cSimpledb->PutIntoClubBar($cSimpledb->zero_padding($id),$cSimpledb->zero_padding($id), $club_logo, $club_name, $club_address, $city, $country);
 
}
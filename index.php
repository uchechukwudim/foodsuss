<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 * 
 * PUBLIC index. works with bootstrap
 */
//use auto loader (spl auto laoder)

require 'config/path.php';
require 'config/Continent.php';
require Libs.'mailgun/vendor/autoload.php';

require Libs.'class.phpmailer.php';
require Libs.'class.smtp.php';
require Libs.'class.pop3.php';
require Libs.'Main.php';
require Libs.'FoodShopSearcher.php';
require Libs.'C_Url.php';
require Libs.'Controller.php';
require Libs.'View.php';
require Libs.'Database.php';
require Libs.'Model.php';
require Libs.'Session.php';
require Libs.'Image.php';
require Libs.'forms.php';
require Libs.'notification.php';

$Main = new Main();
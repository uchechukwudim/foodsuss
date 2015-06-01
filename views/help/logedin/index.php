<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <script>var JURL = '<?php echo URL ?>';</script>
        <link rel="stylesheet" href="<?php echo URL ?>views/css/help/helpsheet.css">
         <link rel="shortcut icon" href="<?php echo URL ?>Icon.png" />
         <script type="text/javascript" src="<?php echo URL ?>js/jquery-1.9.1.js"></script>
        <script src="<?php echo URL.''.View ?>help/js/help.js" type="text/javascript"></script>
        <title>Help</title>
    </head>
    <body>
        <div class="wrapper">
            <section>
                <header>
                     <div id='logo'>
                        <img src="<?php echo URL ?>pictures/enri_logo_trans.png" alt="" width="100"><span>Help</span>
                    </div>
                    <h1>Help</h1>
                    <p>
                        Please send us an email if you need any help or need to make enquires.<br>
                        <img src="<?php echo URL ?>pictures/index/ENRI_MESSAGE_SMALL.png"> <span>help@enrifinder.com.</span><br>
                        
                    </p>
                </header>
                
                <div class="container">
                    <div class="contactformHolder">
                        <form method="post">
                            <input type="text" name="names" id="contact_names" placeholder="names"><br>
                            <input type="text" name="names" id="contact_email" placeholder="email"><br>
                            <textarea cols="55" rows="10" id="message" draggable="false"></textarea><br>
                            <span class="errorMessage"></span>
                            <button onclick="clearForm()" type="button" name="cancel" id="contact_cancel">cancel</button>
                            <button onclick="sendHelpEmail()" type="button" name="submit" id="contact_submit">email</button>
                             
                        </form>
                    </div>
                </div>
            </section>
            
            <section>
                <div class="AboutFooter">
                     <span>&copy; ENRI 2015</span>
                   <ul>
                       <li><a href="<?php echo URL ?>home">Home</a></li>
                        <li><a href="<?php echo URL ?>aboutus">About</a></li>
                       <li><a href="<?php echo URL ?>terms">Terms</a></li>
                       <li><a href="<?php echo URL ?>policy">policy</a></li>
                      
                   </ul>
                </div>
            </section>
        </div>
    </body>
</html>

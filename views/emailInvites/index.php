<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
           <script>var JURL = "<?php echo URL ?>";</script>
         <script type="text/javascript" src="<?php echo JQUERY ?>"></script>
         <script type="text/javascript" src="<?php echo URL ?>views/emailInvites.js"></script>   
          <link rel="shortcut icon" href="<?php echo URL ?>Icon.png" />
        <title>Invite Friends</title>
        <style>
            fieldset{
                
                    font-size: 16px;
                    /*width: 70.01960784313725%; 500px*/
                    border: 1px solid rgba(0, 0, 0, 0.1);
                    border-radius: 2px;
                    box-shadow: 0 0 10px 0px rgba(12, 3, 25, 0.8);
                    margin-bottom : 1.5em;
                   
                }
                legend{
                    font-size: 20px;
                    color: orangered;
                    position: relative;
                    top: 01.36078431372549em; /* 20px*/
                    margin-bottom: 01.36078431372549em; /*20px */;
                    text-align: center;
                }

       
                [type="checkbox"]:not(:checked),
                [type="checkbox"]:checked {
                  position: absolute;
                  left: -9999px;
                }
                [type="checkbox"]:not(:checked) + label,
                [type="checkbox"]:checked + label {
                  position: relative;
                  padding-left: 25px;
                  cursor: pointer;
                }

                /* checkbox aspect */
                [type="checkbox"]:not(:checked) + label:before,
                [type="checkbox"]:checked + label:before {
                  content: '';
                  position: absolute;
                  left:0; top: 2px;
                  width: 17px; height: 17px;
                  border: 1px solid #aaa;
                  background: #f8f8f8;
                  border-radius: 3px;
                  box-shadow: inset 0 1px 3px rgba(0,0,0,.3)
                }
                /* checked mark aspect */
                [type="checkbox"]:not(:checked) + label:after,
                [type="checkbox"]:checked + label:after {
                  content: '✔';
                  position: absolute;
                  top: 0; left: 4px;
                  font-size: 14px;
                  color: orangered;
                  transition: all .2s;
                }
                /* checked mark aspect changes */
                [type="checkbox"]:not(:checked) + label:after {
                  opacity: 0;
                  transform: scale(0);
                }
                [type="checkbox"]:checked + label:after {
                  opacity: 1;
                  transform: scale(1);
                }
                /* disabled checkbox */
                [type="checkbox"]:disabled:not(:checked) + label:before,
                [type="checkbox"]:disabled:checked + label:before {
                  box-shadow: none;
                  border-color: #bbb;
                  background-color: #ddd;
                }
                [type="checkbox"]:disabled:checked + label:after {
                  color: #999;
                }
                [type="checkbox"]:disabled + label {
                  color: #aaa;
                }
                /* accessibility */
                [type="checkbox"]:checked:focus + label:before,
                [type="checkbox"]:not(:checked):focus + label:before {
                  border: 1px dotted blue;
                }

                /* hover style just for information */
                label:hover:before {
                  border: 1px solid #4778d9!important;
                }


               

                label{
                    color: grey;
                    font-size: 1.2em;
                }
                button{
                    margin-top: 15px;
                    background: orangered;
                    color: white;
                    padding: 5px 15px 5px 15px;
                    position: relative;
                    left: 47.61904761904762%; /*450px*/;
                }
            
        </style>
    </head>
    <body>
       <div id="inviteHolder">  
           <?php if(empty($contacts)){ ?>
           <div style="color: grey; font-size: 16px;">We could not get any contact from your email</div>
           <?php }else{ ?>
            <form id="email_invites" name="inviteForm" enctype="multipart/form-data">
                <fieldset>
                        <legend><b>Invite your Friends to enri</b></legend>
                         <?php $counter=0; foreach ($contacts as $title){?>
                           <p>
                                <input type="checkbox" id="test<?php echo $counter; ?>" name="contact[email_<?php echo  $counter; ?>]" value="<?php echo $title->attributes()->address; ?>" checked="checked" />
                                <label for="test<?php echo $counter; ?>"><?php echo $title->attributes()->address; ?></label>
                          </p>
                              
                         <?php $counter++; } ?>
                        <button onclick="processInvites()" id="inviteButton" type="submit" form="inviteForm">Invite</button>
                </fieldset>
            </form>
           <?php } ?>
      </div>
    </body>
</html>
<script type="text/javascript" >
    function processInvites(){
    var emails = new Array();
    var count = 0;
    $('input[type=checkbox]:checked').map(function(_, el) {
  
        emails[count] = ($(el).val());
        count++;
    }).get();
    $('#inviteButton').append('<img src="'+JURL+'pictures/ajax-loader-white.gif" width="15">');
   $.ajax({
       url: JURL+"Suggestusers/processInviteEmails",
       type: "POST",
       dataType: "json",
       data: {emails: emails},
       success:function(data){
           $('#email_invites fieldset').html('<div styel="text-align: center; font-size: 16px; font-weight: 700; color: grey">Thank you for inviting your friend(s) to join enri </div>');
       }
   });
}
</script>
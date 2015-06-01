
 <script src="http://localhost/js/jquery.min.js" type="text/javascript"></script>
 <script src="http://localhost/js/jquery-2.0.0.js" type="text/javascript"></script>
<?php

        if(isset($_POST['comment']) && isset($_FILES['image']))
        {
             
             $file_name = $_FILES['image']['name'];
             $file_ext = strtolower(end(explode('.', $file_name)));
             $file_size = $_FILES['image']['size'];
             $file_temp = $_FILES['image']['tmp_name'];
             static $destination = "C:\wamp\path\pictures";
             static $commentSize; //to be given
             
             //print_r(strlen($_POST['comment']));
             UserInputIntoDatabase($file_name, $file_ext,  $file_size, $file_temp, $destination, $_POST['comment']);
        }
        
    //process image    
  function processImage($file_name, $file_ext,  $file_size, $file_temp)
  {
     static $maxSize = 3145728;
     $errors = '';
     $accepted_ext = array('jpg', 'png', 'jpeg', 'gif');
     $Image = array();
     
      if(in_array($file_ext, $accepted_ext) === false)
      {
          $errors .= 'Extention Not allowed'."</br>";
      }
      
      if($file_size >$maxSize)
      {
          $errors .= 'File size to big'."</br>";
      }
      
      if(empty($errors))
      {
          //create 
          $image = array("image_name" => $file_name, "image_temp" => $file_temp);
      }
      else
      {
          ?>   
          <script type = text/javascript>
           showErrorImageMessage("<?php echo $errors ?>", "<?php echo $_POST['comment']?>");
           
           </script>;
           <?php
          
      }
      
      return $image;
  }
  
  //insert food recommendation from users into database
  function UserInputIntoDatabase($image_name, $image_ext, $image_size, $image_tmp, $image_Destination, $foodComment)
  {
         if(strlen(trim($foodComment)) == 0)
         {
             //error messsage
             ?>   
          <script type = text/javascript>
           var EntryMessage = "There was no entry in the Textarea";
           showErrorNoEntryMessage(EntryMessage);
          function showErrorNoEntryMessage(message)
          {
            $('#er_message').html(""+ message);
            $('#error_layer').show();
            $('#error_dialog').show();
            $('#error_close').show();
            
             $('#error_close').click(function(){
                 $('#error_layer').hide();
                $('#error_dialog').hide();
                $('#error_close').hide();
                 
             });
            $(document).keyup(function(e){
                    if(e.which == 27){
                    // Close my modal window
                     $('#error_layer').hide();
                    $('#error_dialog').hide();
                    $('#error_close').hide();
                }
             });
          }
           </script>;
           <?php
         }
         else
         {
               if(strlen($image_name) != 0 && strlen($foodComment) !== 0)
               {
                   //process image here
                   if(processImage($image_name, $image_ext,$image_size, $image_tmp))
                   {
                       $image = processImage($image_name, $image_ext,$image_size, $image_tmp);
                       
                       //addslashes here
                       $im_nm = addslashes($image['image_name']);
                       $im = addslashes($image['image_temp']);
                       
                        //insert data into database here image and comment
                        $sql = "INSERT INTO  usersfoodinput VALUES ('', '$foodComment', '$im_nm', '$im', '')";
                   
                        $result = SQLInsertUpdateDelete($sql);
                        
                        if($result)
                        {
                            ?>
                                <script type="text/javascript">
                                    var EntryMessage = "Food sent. </br> </br> Thank you for telling us about the food we dont know.";
                                    showErrorNoEntryMessage(EntryMessage);
                            
                                </script>
                                
                            <?php
                        }
                    
                   }
                   
                  
              
               }
               else if(strlen($image_name) === 0 && strlen($foodComment) !==0)
               {
                    //insert comment alone with out image
                    $sql = "INSERT INTO  usersfoodinput VALUES ('', '', '', '', '')";
               }
         }
  }

 ?>

 
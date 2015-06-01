 <!DOCTYPE html>
<div id="Findercontainer">
    
    <?php echo "</br>"?>
       <?php include("C:\wamp\path\header.php"); ?>
         <div id="Finderleftnav">
             <div id="FinderSwrapper">
                <?php
                         include("C:\wamp\path\searchBox\searchform.php"); 
                ?>
             </div>
         </div>
         <div id="FinderrightNav">right nav</div>
         
         <div id="Finderbody">
             <div id="tag">
                    <img src="http://localhost/pictures/foods/tag.jpg"> <span>Tell us food we don't know about</span>
                    <span id='navCountry'> <?php echo $country; ?></span> <img src='' width='20' height='20' class='im1'> 
            </div>
            
            <form action ="" method ="post" enctype="multipart/form-data" id="usrform">   

                      <textarea  name="comment" form="usrform" id ='inputFood' ></textarea>

                     <div id="btnTag">
                         <button id="submitBt" type="submit" name='submit' form="usrform">Tell</button>
                         <div id="uploadPic">
                            Picture
                            <input type="file" name="file" id="file"/>
                         </div>
                     </div>
            </form>
         </div>
         
         
</div>

 <!---
        error dialog box start here
        -->
        <div id="error_layer"></div>   
         <div id="error_dialog">
             <div id="header_dialog"><span class ="txt">Error Message</span></div>
             <div id="er_message"></div>
            <div id="error_close">| x |</div>
        </div>
        
        <!---
        error dialog box end here
        -->

        <div id="productLayer"></div>
        <div id="productDialog">
            <div id="ProductClose">|x|</div>
            <div id="header_dialogProd"><span class="txt"></span></div>
            <div id="holdProd"></div>
        </div>
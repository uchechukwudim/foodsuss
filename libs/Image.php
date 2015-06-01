<?php

class Image {
    
    public $file_name;
    public $file_ext;
    public $file_size;
    public $file_temp ;
    static $maxSize = 3145728;
    
    function __construct() {
        
    }
    
  function initializeImage($image)
  {
      $this->file_name = $image['image']['name'];
      $this->file_ext = strtolower(end(explode('.', $this->file_name)));
      $this->file_size =  $image['image']['size'];
      $this->file_temp =  $image['image']['tmp_name'];
  }
    
  function getImgeName()
  {
      return $this->file_name;
  }
  
  function getImgeExtentiom()
  {
      return $this->file_ext;
  }
  
  function getImgeSize()
  {
      return $this->file_name;
  }
  
  function getImgeTempLoc()
  {
      return $this->file_temp;
  }
    
  function processImage($file_name, $file_ext,  $file_size, $file_temp)
  {
     
     $errors = '';
     $accepted_ext = array('jpg', 'png', 'jpeg', 'gif');
     $image = array();
     
      if(in_array($file_ext, $accepted_ext) === false)
      {
          $errors .= 'Extention Not allowed'."</br>";
      }
      
      if($file_size > $this->maxSize)
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
  
  
// This function will proportionally resize image 
function resizeImage($CurWidth,$CurHeight,$MaxSize,$DestFolder,$SrcImage,$Quality,$ImageType)
{
    //Check Image size is not 0
    if($CurWidth <= 0 || $CurHeight <= 0) 
    {
        return false;
    }
    
    //Construct a proportional size of new image
    $ImageScale         = min($MaxSize/$CurWidth, $MaxSize/$CurHeight); 
    $NewWidth           = ceil($ImageScale*$CurWidth);
    $NewHeight          = ceil($ImageScale*$CurHeight);
    $NewCanves          = imagecreatetruecolor($NewWidth, $NewHeight);
    
    // Resize Image
    if(imagecopyresampled($NewCanves, $SrcImage,0, 0, 0, 0, $NewWidth, $NewHeight, $CurWidth, $CurHeight))
    {
        switch(strtolower($ImageType))
        {
            case 'image/png':
                imagepng($NewCanves,$DestFolder);
                break;
            case 'image/gif':
                imagegif($NewCanves,$DestFolder);
                break;          
            case 'image/jpeg':
            case 'image/pjpeg':
                imagejpeg($NewCanves,$DestFolder,$Quality);
                break;
            default:
                return false;
        }
    //Destroy image, frees memory   
    if(is_resource($NewCanves)) {imagedestroy($NewCanves);} 
    return true;
    }

}

//This function corps image to create exact square images, no matter what its original size!
function cropImage($CurWidth,$CurHeight,$iSize,$DestFolder,$SrcImage,$Quality,$ImageType)
{    
    //Check Image size is not 0
    if($CurWidth <= 0 || $CurHeight <= 0) 
    {
        return false;
    }
    
    //abeautifulsite.net has excellent article about "Cropping an Image to Make Square bit.ly/1gTwXW9
    if($CurWidth>$CurHeight)
    {
        $y_offset = 0;
        $x_offset = ($CurWidth - $CurHeight) / 2;
        $square_size    = $CurWidth - ($x_offset * 2);
    }else{
        $x_offset = 0;
        $y_offset = ($CurHeight - $CurWidth) / 2;
        $square_size = $CurHeight - ($y_offset * 2);
    }
    
    $NewCanves  = imagecreatetruecolor($iSize, $iSize); 
    if(imagecopyresampled($NewCanves, $SrcImage,0, 0, $x_offset, $y_offset, $iSize, $iSize, $square_size, $square_size))
    {
        switch(strtolower($ImageType))
        {
            case 'image/png':
                imagepng($NewCanves,$DestFolder);
                break;
            case 'image/gif':
                imagegif($NewCanves,$DestFolder);
                break;          
            case 'image/jpeg':
            case 'image/pjpeg':
                imagejpeg($NewCanves,$DestFolder,$Quality);
                break;
            default:
                return false;
        }
    //Destroy image, frees memory   
    if(is_resource($NewCanves)) {imagedestroy($NewCanves);} 
    return true;

    }
      
}
}
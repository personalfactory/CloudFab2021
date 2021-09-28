<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
  <?php include('../include/validator.php'); ?>
  <head>
      <?php include('../include/header.php'); ?>
  </head>
  <body>
   
    <div id="mainContainer">
      <div id="container" style="width:1000px; margin:15px auto; ">
        <a href="/CloudFab/index.php"><?php echo $filtroTornaHome ?> </a>
        
        <?php
        
        echo "</br>";
        echo '<a href="./SyncOrigami/dist/log">VEDI FILE DI LOG</a><br/>';
        
        
        
//        $filename = "./SyncOrigami/dist/log/sync.log";
//        $handle = fopen($filename, "r");
//        $contents = fread($handle, filesize($filename));
//        echo "$contents";
//        fclose($handle);
        
        ?>
      </div>
    </div>
  </body>
</html>

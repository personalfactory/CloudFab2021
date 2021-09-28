<?php

define('UPLOAD_DIR', '/var/www/CloudFab/doc/ddt');

if (isset($_POST['action']) and $_POST['action'] == 'upload') {
    
    if (isset($_FILES['user_file'])) {
        
         $file = $_FILES['user_file'];
//       print_r($file);
        if ($file['error'] == UPLOAD_ERR_OK and is_uploaded_file($file['tmp_name'])) {
            move_uploaded_file($file['tmp_name'], UPLOAD_DIR . $file['name']);
            echo "FILE CARICATO!";
        }
    }
}

?>
<!--<script type="text/javascript">
          history.back();
        </script>-->
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <?php
        ini_set('display_errors', '1');
        include('./include/header.php'); 
        ?>      
    </head>
    <body>
        <div id="Login">
            <form action="login2.php" method="POST" autocomplete="off">
                <div align="right">
                    <table class="tableLingue"> 
                    <tr >
                        <td style='text-align: right;'>
                            <?php
//#################### SCELTA DELLA LINGUA #################################
                            $lingue = array(1 => 'Italiano', 'English');
                            $flags = array(1 => 'IT', 'EN');

                            $lingua = @$_GET['lingua'];
                           
                            foreach ($lingue as $k => $v) {
                                ?>
                                <a href="?lingua=<?php echo $k; ?>">
                                    <img src="/CloudFab/images/bandiera_<?php echo $flags[$k]; ?>.gif"  alt="<?php echo $v; ?>" 
                                         style="margin-left: 5px; margin-right: 5px; margin-bottom:5px; margin-top: 5px;" 
                                         title="<?php echo $v; ?>" border="0" align="right"/>
                                </a>
                                <?php
                            }
                            if (!$lingua)
                                $lingua = 1; // default italiano
                                
//###########################################################################
                            //ATTENZIONE questa parte di codice viene incluse anke all'interno dell' header
                            //sistemare i percorsi in modo da includerlo solo nell'header
                            switch ($lingua) {
                                case 1:
                                    include ('./lingue/it.php');
                                    break;
                                case 2:
                                    include ('./lingue/en.php');
                                    break;
                                case 3:
                                    include ('./lingue/fr.php');
                                    break;
                            }

                            ?>

                        </td>
                    </tr>
                </table>
                    </div>
                
                <div style="height:60px;text-align:center;"><img src="/CloudFab/images/inephosLogoR.png" style="width:264px;height:72px;"/></div>
            <br/>
            <br/>
            <br/>
                <table class="table2">
                    
                    <tr style="text-align:center">
                        <td><input id="inputLogin" type="text" name="username" value="" placeholder="<?php echo $loginUsername ?>" /></td>
                    </tr>
                     <tr style="text-align:center">
                        <td><input id="inputLogin"  type="password" name="password" value="" placeholder="<?php echo $loginPassword ?>" /></td>
                    </tr>
                    <input type="hidden" name="lingua" value="<?php echo $lingua ?>">                 
                        <tr height="20px"></tr>
                 
                        <tr style="height:40px;">                           
                            <td colspan="2" style="text-align:center; border-right:5px;background:#E1E1E1;width:150px">                                
                                <input style="background:#E1E1E1;border:none" type="submit" name="submit" value="<?php echo $loginValue ?>" />  
                            </td>
                        </tr>
                </table>
            </form>
            <div style="float:right;padding-top:50px;padding-right:20px">
                    <img src="/CloudFab/images/linkSitoPf.png" style="width:97.2px;height:57.9px;padding-left:20px;"/></div>
        </div>
    </body>
</html>
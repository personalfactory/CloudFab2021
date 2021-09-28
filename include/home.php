<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('validator.php'); ?>
    <head>
        <?php
        //#################### SCELTA DELLA LINGUA #################################
        //L'indicizzazione della lingua deve corrispondere a quello della tabella lingua
        
        $lingue = array(1 => 'Italiano', 'English');
        $flags = array(1 => 'IT', 'EN');

        if (isset($_GET['lingua'])) {
            $_SESSION['lingua'] = @$_GET['lingua'];
        }
        if (!isset($_SESSION['lingua']))
            $_SESSION['lingua'] = 1; // default italiano
        
        include('header.php');
        
        ?>
    </head>
    <body>                  
        <div style="float:left;padding-top:10px">
            <table class="tableLingue"> 
                <tr>                                              
                    <td >
                        <?php
//                            //#################### SCELTA DELLA LINGUA #################################


                        foreach ($lingue as $k => $v) {
                            ?>
                            <a href="?lingua=<?php echo $k; ?>">
                                <img src="/CloudFab/images/bandiera_<?php echo $flags[$k]; ?>.gif"  alt="<?php echo $v; ?>" 
                                     style="margin-left: 5px; margin-right: 5px; margin-bottom:2px; margin-top: 2px;" 
                                     title="<?php echo $v; ?>" border="0" align="right"/>
                            </a>
                            <?php
                        }
                        ?>
                    </td>
                </tr>
            </table>

        </div>
        <div id="mainContainer"> 

            <?php
//            include('menu.php');
//$_SESSION['objPermessiVis']->printPermessi();
            ?>
            <div id="container" style ="margin:15px auto; height:600px; width:800px;">
                <img src="/CloudFab/images/homepageinephos.png" class="images" style = " height:100%; width:100%; "/>


            </div>

        </div>
    </body>
</html>


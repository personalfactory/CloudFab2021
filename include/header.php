<title>iNephos</title>

<link rel="stylesheet" type="text/css" href='/CloudFab/css/styleAdmin.css?ts=<?=time()?>&quot' />
<link rel="shortcut icon" href="/CloudFab/images/favicon16.ico"/>
<script type="text/javascript" src="/CloudFab/js/XulMenu.js"/></script>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8"/>

<script language="javascript">

    function mostraNascondiMenu() {
        if (document.getElementById('menuInephos').style.visibility === 'hidden') {
            document.getElementById('menuInephos').style.visibility = 'visible';
        } else {
            document.getElementById('menuInephos').style.visibility = 'hidden';
        }


    }
</script>
<?php
//############## GESTIONE DELLA LINGUA ######################################
//Inclusione del file contenente tutte le stringhe ed i messaggi visualizzati 
include("/var/www/CloudFab/lingue/gestore.php");

if (isset($_SESSION['username'])) {
    ?>
    <h1> 
        <div style='float:right;padding-right:40px;padding-top:20px;'><img src='../images/agente.jpg' /><?php echo " Ciao  " . $_SESSION['username'] ?></div>
        <div>
            <a href="../index.php"><img src="/CloudFab/images/inephosLogoR.png" style="width:250px;height:68.2px; align:end;padding-left:5px;padding-right:20px;border:0"/></a>
            <a href="http://www.personalfactory.eu" target="blank" title="<?php echo $titleLinkSitoPf ?>" target="blank"><img src="/CloudFab/images/linkSitoPf.png" style="align:end; width:97.2px;height:57.9px;padding-right:20px;border:0"/></a>
            <a href="http://www.personalfactory.eu/prodotti/" target="blank" title="<?php echo $titleLinkProdottiPf ?>"><img src="/CloudFab/images/linkSitoProdotti.png" style="align:end; width:64.2px;height:63.2px;padding-right:20px;border:0"/></a> 
            <a href="http://www.inephos.eu/configuratore/login.php" target="blank" title="<?php echo $titleLinkConfiguratore ?>"><img src="/CloudFab/images/linkConfiguratore.png" style="align:end; width:38px;height:60px;padding-right:20px;border:0"/></a>  
            <a href="http://185.17.107.70/owncloud/" target="blank" title="<?php echo $titleLinkOwnCloud ?>"><img src="/CloudFab/images/owncloud-pf.png" style="align:end;width:120px;height:60px;padding-right:20px;border:0"/></a>
            <a href="https://www.yammer.com/isolmix.com/" target="blank" title="<?php echo $titleLinkYammer ?>"><img src="/CloudFab/images/yammer.png" style="text-align:end; width:103.2px;height:21.9px;border:0"/></a>
            <a href="https://www.inephos.eu/GestoreUtenti/index.php" target="blank" title="<?php echo "Gestore Utenti"?>"><img src="/GestoreUtenti/image/link_gestione.png" style="text-align:end; width:80.0px;height:50.0px;border:0"/></a>
		</div>

    </h1>
<div style="float:left;">
    <div style="width:230px;
         background:#A00028;	  
         text-align:center;
         color:#FFFFFF;margin:10px"
         onClick="mostraNascondiMenu()"><?php echo $filtroMenu ?> 
        <img src="/CloudFab/images/arrow3.png" style="width:10.5px;height:6px;" class="buttonMenu"/></div>    
    <div id="menuInephos">
        <?php include('/var/www/CloudFab/include/menu_verticale.php'); ?>
    </div>
    <br/>
    <br/>
    
</div>

<?php } ?>


<!--##################### Form di scelta della valuta #######################-->
<div style="float:right; " >
    <?php
    $valuteBs = array(1 => 'Euro', 'US Dollar');
    $flags = array(1 => 'euro', 'dollar');

    foreach ($valuteBs as $k => $v) {
        
        ?>
        <input type="image" id="valutaBs[<?php echo $k ?>]" name="valutaBs[<?php echo $k ?>]" value="<?php echo $k ?>"
               src="/CloudFab/images/valuta_<?php echo $flags[$k]; ?>.png"   
               style="margin-left: 5px; margin-right: 5px; margin-bottom:2px;margin-top: 2px;border:0; align:right"
               alt="<?php echo $v; ?>"
               title="<?php echo $v; ?>" 
               onclick="javascript:AggiornaPagina();" />
               <?php
           }
           ?>
</div> 

<?php
if($TipoProdOb=="NomeProdObEs"){ ?>
<tr>
    <td class="cella4"><?php echo $filtroLabProdottoObiet ?></td>
    <td>
        <table  width="100%">
    <td class="cella4">
        <input type="radio" id="scegli_target" name="scegli_target" onclick="javascript:visualizzaListBoxProbObEsistente();" value="NomeProdObEs" checked="checked"/><?php echo $filtroLabEsistente ?></td>
    <td class="cella1">
        <div id="ProdObEsistente" >
            <select id="NomeProdObEs" name="NomeProdObEs">
                <option value="<?php echo $ProdOb ?>" selected="<?php echo $ProdOb ?>"><?php echo $ProdOb ?></option>
                <?php
                mysql_data_seek($sqlProdOb, 0);
                while ($rowProdOb = mysql_fetch_array($sqlProdOb)) {
                    ?>
                    <option value="<?php echo($rowProdOb['prod_ob']) ?>"><?php echo($rowProdOb['prod_ob']) ?></option>
                <?php } ?>
            </select>
        </div></td>
</tr>
<tr>
    <td class="cella4" title="<?php echo $titleLabDigitaProdOb ?>">
        <input type="radio" id="scegli_target" name="scegli_target" onclick="javascript:visualizzaFormNuovoProdOb();" value="NomeProdObNuovo" /><?php echo $filtroLabNuovo ?></td>
    <td class="cella1">
        <div id="ProdObNuovo" style="visibility:hidden;" >
            <textarea name="NomeProdObNuovo" id="NomeProdObNuovo" ROWS=2 COLS=60 title="<?php echo $titleLabDigitaProdOb ?>"/></textarea>
    </div></td>
 </tr> 
        </table>
    </td>
</tr>  

<?php } else if ($TipoProdOb=="NomeProdObNuovo"){ ?>
    
   <tr>
    <td class="cella4"><?php echo $filtroLabProdottoObiet ?></td>
    <td>
        <table  width="100%">
    <td class="cella4">
        <input type="radio" id="scegli_target" name="scegli_target" onclick="javascript:visualizzaListBoxProbObEsistente();" value="NomeProdObEs" /><?php echo $filtroLabEsistente ?></td>
    <td class="cella1">
        <div id="ProdObEsistente" style="visibility:hidden;">
            <select id="NomeProdObEs" name="NomeProdObEs">
                 <option value="" selected=""><?php echo $labelOptionSelectProdObiet ?> </option>
                <?php
                mysql_data_seek($sqlProdOb, 0);
                while ($rowProdOb = mysql_fetch_array($sqlProdOb)) {
                    ?>
                    <option value="<?php echo($rowProdOb['prod_ob']) ?>"><?php echo($rowProdOb['prod_ob']) ?></option>
                <?php } ?>
            </select>
        </div></td>
</tr>
<tr>
    <td class="cella4" title="<?php echo $titleLabDigitaProdOb ?>">
        <input type="radio" id="scegli_target" name="scegli_target" onclick="javascript:visualizzaFormNuovoProdOb();" value="NomeProdObNuovo" checked="checked"/><?php echo $filtroLabNuovo ?></td>
    <td class="cella1">
        <div id="ProdObNuovo">
            <textarea name="NomeProdObNuovo" id="NomeProdObNuovo" ROWS=2 COLS=60 title="<?php echo $titleLabDigitaProdOb ?>" value="<?php echo $ProdOb ?>"/><?php echo $ProdOb ?></textarea>
    </div></td>
 </tr> 
        </table>
    </td>
</tr> 
    
    
<?php } ?>
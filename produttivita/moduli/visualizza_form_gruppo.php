<!--################################################################################-->
<!--########################### PRODUTTIVITA  ######################################-->
<!--################################################################################-->	
<?php
begin();
$sqlLiv6 = selectCampoByNome("livello_6", $strUtAzGruppo);
$sqlLiv5 = selectCampoByNome("livello_5", $strUtAzGruppo);
$sqlLiv4 = selectCampoByNome("livello_4", $strUtAzGruppo);
$sqlLiv3 = selectCampoByNome("livello_3", $strUtAzGruppo);
$sqlLiv2 = selectCampoByNome("livello_2", $strUtAzGruppo);
$sqlLiv1 = selectCampoByNome("livello_1", $strUtAzGruppo);
commit();
?>	
<table width="100%">    
        <tr id="96">
            <td class="cella7">
                <input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaSestoLivello();" value="SestoLivello"/><?php echo $filtroSestoLivello ?></td>
            <td bgcolor="#FFFFFF">
                <div id="LivelloSei" style="visibility:hidden;" >
                    <select id="SestoLivello" name="SestoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&ScegliGruppo=' + this.form.scegli_gruppo.value +
                                '&SestoLivello=' + this.form.SestoLivello.value +
                                '&Submit=1', 'SettaVar');">

                        <?php
//            $sql = mysql_query("SELECT DISTINCT(livello_6) AS livello_6 FROM gruppo WHERE livello_6 IS NOT NULL AND livello_6<>'' ORDER BY livello_6") or die("Errore 111: " . mysql_error());
                        while ($row = mysql_fetch_array($sqlLiv6)) {
                            ?>
                            <option value="<?php echo($row['livello_6']) ?>"><?php echo($row['livello_6']) ?></option>
                        <?php } ?>
                    </select>
                </div>
            </td>
        </tr>
    
    <tr>
        <td  class="cella7">
            <input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaQuintoLivello();" value="QuintoLivello" checked="checked"/><?php echo $filtroQuintoLivello ?></td>
        <td bgcolor="#FFFFFF">
            <div id="LivelloCinque" >
                <select id="QuintoLivello" name="QuintoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&ScegliGruppo=' + this.form.scegli_gruppo.value +
                                '&QuintoLivello=' + this.form.QuintoLivello.value +
                                '&Submit=1', 'SettaVar');">
                    <option value=""><?php echo $labelOptionGruppoDefault; ?></option> 
                    <?php
//                    $sql = mysql_query("SELECT DISTINCT(livello_5) AS livello_5 FROM gruppo WHERE livello_5 IS NOT NULL AND livello_5<>'' ORDER BY livello_5") or die("Errore 110: " . mysql_error());
                    while ($row = mysql_fetch_array($sqlLiv5)) {
                        ?>
                        <option value="<?php echo($row['livello_5']) ?>"><?php echo($row['livello_5']) ?></option>
                    <?php } ?>
                </select>
            </div></td>
    </tr> 
    <tr>
        <td  class="cella7">
            <input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaQuartoLivello();" value="QuartoLivello" /><?php echo $filtroQuartoLivello ?></td>
        <td  bgcolor="#FFFFFF">
            <div id="LivelloQuattro" style="visibility:hidden;">
                <select id="QuartoLivello" name="QuartoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&ScegliGruppo=' + this.form.scegli_gruppo.value +
                                '&QuartoLivello=' + this.form.QuartoLivello.value +
                                '&Submit=1', 'SettaVar');">
                    <option value=""><?php echo $labelOptionGruppoDefault; ?></option>  
                    <?php
//            $sql = mysql_query("SELECT DISTINCT(livello_4) AS livello_4 FROM gruppo WHERE livello_4 IS NOT NULL AND livello_4<>'' ORDER BY livello_4") or die("Errore 109: " . mysql_error());
                    while ($row = mysql_fetch_array($sqlLiv4)) {
                        ?>
                        <option value="<?php echo($row['livello_4']) ?>"><?php echo($row['livello_4']) ?></option>
                    <?php } ?>
                </select>
            </div></td>
    </tr>

    <tr>
        <td  class="cella7">
            <input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaTerzoLivello();" value="TerzoLivello"/><?php echo $filtroTerzoLivello ?></td>
        <td  bgcolor="#FFFFFF"><div id="LivelloTre" style="visibility:hidden;">
                <select id="TerzoLivello" name="TerzoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&ScegliGruppo=' + this.form.scegli_gruppo.value +
                                '&TerzoLivello=' + this.form.TerzoLivello.value +
                                '&Submit=1', 'SettaVar');">
                    <option value=""><?php echo $labelOptionGruppoDefault; ?></option> 
                    <?php
//            $sql = mysql_query("SELECT DISTINCT(livello_3) AS livello_3 FROM gruppo WHERE livello_3 IS NOT NULL AND livello_3<>''ORDER BY livello_3") or die("Errore 108: " . mysql_error());
                    while ($row = mysql_fetch_array($sqlLiv3)) {
                        ?>
                        <option value="<?php echo($row['livello_3']) ?>"><?php echo($row['livello_3']) ?></option>
                    <?php } ?>
                </select>
            </div></td>
    </tr>

    <tr>
        <td  class="cella7">
            <input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaSecondoLivello();" value="SecondoLivello" /><?php echo $filtroSecondoLivello ?></td>
        <td  bgcolor="#FFFFFF"><div id="LivelloDue" style="visibility:hidden;">
                <select id="SecondoLivello" name="SecondoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&ScegliGruppo=' + this.form.scegli_gruppo.value +
                                '&SecondoLivello=' + this.form.SecondoLivello.value +
                                '&Submit=1', 'SettaVar');">
                    <option value=""><?php echo $labelOptionGruppoDefault; ?></option>  
                    <?php
//            $sql = mysql_query("SELECT DISTINCT(livello_2) AS livello_2 FROM gruppo WHERE livello_2 IS NOT NULL AND livello_2<>'' ORDER BY livello_2") or die("Errore 107: " . mysql_error());
                    while ($row = mysql_fetch_array($sqlLiv2)) {
                        ?>
                        <option value="<?php echo($row['livello_2']) ?>"><?php echo($row['livello_2']) ?></option>
                    <?php } ?>
                </select>
            </div></td>
    </tr>

    <tr>
        <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaPrimoLivello();" value="PrimoLivello" /><?php echo $filtroPrimoLivello ?></td>
        <td bgcolor="#FFFFFF"><div id="LivelloUno" style="visibility:hidden;">
                <select id="PrimoLivello" name="PrimoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&PrimoLivello=' + this.form.PrimoLivello.value +
                                '&Submit=1', 'SettaVar');">
                    <option value=""><?php echo $labelOptionGruppoDefault; ?></option> 
                    <?php
//            $sql = mysql_query("SELECT DISTINCT(livello_1) AS livello_1 FROM gruppo WHERE livello_1 IS NOT NULL AND livello_1<>'' ORDER BY livello_1") or die("Errore 106: " . mysql_error());
                    while ($row = mysql_fetch_array($sqlLiv1)) {
                        ?>
                        <option value="<?php echo($row['livello_1']) ?>"><?php echo($row['livello_1']) ?> </option>
                    <?php } ?>
                </select>
            </div></td>
    </tr>
</table>


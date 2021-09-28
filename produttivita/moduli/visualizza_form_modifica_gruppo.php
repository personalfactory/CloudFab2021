<!--################################################################################-->
<!--########################### PRODUTTIVITA     ###################################-->
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

$LivelloGruppo = $_SESSION['LivelloGruppo'];
$Gruppo = $_SESSION['Gruppo'];

if ($LivelloGruppo == 'SestoLivello') {
    ?>	
    <table width="100%">

        <tr id="96">
            <td  class="cella7">
                <input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaSestoLivello();" value="SestoLivello" checked="checked"/><?php echo $filtroSestoLivello ?> </td>
            <td  bgcolor="#FFFFFF">
                <div id="LivelloSei" >
                    <select id="SestoLivello" name="SestoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&SestoLivello=' + this.form.SestoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
                        <option value="<?php echo $Gruppo; ?>" selected ><?php echo $Gruppo; ?></option>
                        <?php
//                        $sql = mysql_query("SELECT DISTINCT(livello_6) AS livello_6 
//												FROM gruppo 
//												WHERE 
//													livello_6 IS NOT NULL 
//												AND 
//													livello_6<>'' 
//												AND 
//													livello_6<>'" . $Gruppo . "'  
//												ORDER BY 
//													livello_6") or die("Errore 111: " . mysql_error());
                        while ($row = mysql_fetch_array($sqlLiv6)) {
                            ?>
                            <option value="<?php echo($row['livello_6']) ?>"><?php echo($row['livello_6']) ?></option>
                        <?php } ?>
                    </select>
                </div>
            </td>
        </tr>

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaQuintoLivello();" value="QuintoLivello" /><?php echo $filtroQuintoLivello ?> </td>
            <td   bgcolor="#FFFFFF"><div id="LivelloCinque" style="visibility:hidden;">
                    <select id="QuintoLivello" name="QuintoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&QuintoLivello=' + this.form.QuintoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlLiv5)) {
                            ?>
                            <option value="<?php echo($row['livello_5']) ?>"><?php echo($row['livello_5']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr> 
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaQuartoLivello();" value="QuartoLivello" /><?php echo $filtroQuartoLivello ?> </td>
            <td  bgcolor="#FFFFFF"><div id="LivelloQuattro" style="visibility:hidden;">
                    <select id="QuartoLivello" name="QuartoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&QuartoLivello=' + this.form.QuartoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
                    <?php
                            while ($row = mysql_fetch_array($sqlLiv4)) {
                                ?>
                            <option value="<?php echo($row['livello_4']) ?>"><?php echo($row['livello_4']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaTerzoLivello();" value="TerzoLivello"/><?php echo $filtroTerzoLivello ?></td>
            <td  bgcolor="#FFFFFF"><div id="LivelloTre" style="visibility:hidden;">
                    <select id="TerzoLivello" name="TerzoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&TerzoLivello=' + this.form.TerzoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
                    <?php
                    while ($row = mysql_fetch_array($sqlLiv3)) {
                        ?>
                            <option value="<?php echo($row['livello_3']) ?>"><?php echo($row['livello_3']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaSecondoLivello();" value="SecondoLivello" /><?php echo $filtroSecondoLivello ?> </td>
            <td  bgcolor="#FFFFFF"><div id="LivelloDue" style="visibility:hidden;">
                    <select id="SecondoLivello" name="SecondoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&SecondoLivello=' + this.form.SecondoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
                    <?php
                    while ($row = mysql_fetch_array($sqlLiv2)) {
                        ?>
                            <option value="<?php echo($row['livello_2']) ?>"><?php echo($row['livello_2']) ?></option>
                            <?php } ?>
                    </select>
                </div></td>
        </tr>

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaPrimoLivello();" value="PrimoLivello" /><?php echo $filtroPrimoLivello ?> </td>
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
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
                    <?php
                    while ($row = mysql_fetch_array($sqlLiv1)) {
                        ?>
                            <option value="<?php echo($row['livello_1']) ?>"><?php echo($row['livello_1']) ?> </option>
                    <?php } ?>
                    </select>
                </div></td>
        </tr>
    </table>
                    <?php } ?>
                    <?php if ($LivelloGruppo == 'QuintoLivello') { ?>	
    <table width="100%">

        <tr id="96">
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaSestoLivello();" value="SestoLivello" /><?php echo $filtroSestoLivello ?> </td>
            <td  bgcolor="#FFFFFF"><div id="LivelloSei" style="visibility:hidden;">
                    <select id="SestoLivello" name="SestoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&SestoLivello=' + this.form.SestoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
    <?php
    
    while ($row = mysql_fetch_array($sqlLiv6)) {
        ?>
                            <option value="<?php echo($row['livello_6']) ?>"><?php echo($row['livello_6']) ?></option>
                    <?php } ?>
                    </select>
                </div></td>
        </tr>

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaQuintoLivello();" value="QuintoLivello" checked="checked"/><?php echo $filtroQuintoLivello ?> </td>
            <td   bgcolor="#FFFFFF"><div id="LivelloCinque" >
                    <select id="QuintoLivello" name="QuintoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&QuintoLivello=' + this.form.QuintoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
                        <option value="<?php echo $Gruppo; ?>" selected><?php echo $Gruppo; ?></option>

    <?php
    while ($row = mysql_fetch_array($sqlLiv5)) {
        ?>
                            <option value="<?php echo($row['livello_5']) ?>"><?php echo($row['livello_5']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr> 

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaQuartoLivello();" value="QuartoLivello" /><?php echo $filtroQuartoLivello ?> </td>
            <td  bgcolor="#FFFFFF"><div id="LivelloQuattro" style="visibility:hidden;">
                    <select id="QuartoLivello" name="QuartoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&QuartoLivello=' + this.form.QuartoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
    <?php
    while ($row = mysql_fetch_array($sqlLiv4)) {
        ?>
                            <option value="<?php echo($row['livello_4']) ?>"><?php echo($row['livello_4']) ?></option>
                    <?php } ?>
                    </select>
                </div></td>
        </tr>

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaTerzoLivello();" value="TerzoLivello"/><?php echo $filtroTerzoLivello ?></td>
            <td  bgcolor="#FFFFFF"><div id="LivelloTre" style="visibility:hidden;">
                    <select id="TerzoLivello" name="TerzoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&TerzoLivello=' + this.form.TerzoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
    <?php
    while ($row = mysql_fetch_array($sqlLiv3)) {
        ?>
                            <option value="<?php echo($row['livello_3']) ?>"><?php echo($row['livello_3']) ?></option>
    <?php } ?>
                    </select>
                </div></td>
        </tr>

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaSecondoLivello();" value="SecondoLivello" /><?php echo $filtroSecondoLivello ?> </td>
            <td  bgcolor="#FFFFFF"><div id="LivelloDue" style="visibility:hidden;">
                    <select id="SecondoLivello" name="SecondoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&SecondoLivello=' + this.form.SecondoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlLiv2)) {
                            ?>
                            <option value="<?php echo($row['livello_2']) ?>"><?php echo($row['livello_2']) ?></option>
    <?php } ?>
                    </select>
                </div></td>
        </tr>

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick=	       	"javascript:visualizzaPrimoLivello();" value="PrimoLivello" /><?php echo $filtroPrimoLivello ?> </td>
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
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlLiv1)) {
                            ?>
                            <option value="<?php echo($row['livello_1']) ?>"><?php echo($row['livello_1']) ?> </option>
    <?php } ?>
                    </select>
                </div></td>
        </tr>
    </table>
<?php } ?>

                <?php if ($LivelloGruppo == 'QuartoLivello') { ?>	
    <table width="100%">

        <tr id="96">
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaSestoLivello();" value="SestoLivello" /><?php echo $filtroSestoLivello ?> </td>
            <td  bgcolor="#FFFFFF"><div id="LivelloSei" style="visibility:hidden;">
                    <select id="SestoLivello" name="SestoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&SestoLivello=' + this.form.SestoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
                        <?php
                       
                        while ($row = mysql_fetch_array($sqlLiv6)) {
                            ?>
                            <option value="<?php echo($row['livello_6']) ?>"><?php echo($row['livello_6']) ?></option>
    <?php } ?>
                    </select>
                </div></td>
        </tr>

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaQuintoLivello();" value="QuintoLivello" /><?php echo $filtroQuintoLivello ?> </td>
            <td   bgcolor="#FFFFFF"><div id="LivelloCinque" style="visibility:hidden;">
                    <select id="QuintoLivello" name="QuintoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&QuintoLivello=' + this.form.QuintoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlLiv5)) {
                            ?>
                            <option value="<?php echo($row['livello_5']) ?>"><?php echo($row['livello_5']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr> 

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaQuartoLivello();" value="QuartoLivello" checked="checked"/><?php echo $filtroQuartoLivello ?> </td>
            <td  bgcolor="#FFFFFF"><div id="LivelloQuattro" >
                    <select id="QuartoLivello" name="QuartoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&QuartoLivello=' + this.form.QuartoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
                        <option value="<?php echo $Gruppo; ?>" selected><?php echo $Gruppo; ?></option>
                        <?php
                        while ($row = mysql_fetch_array($sqlLiv4)) {
                            ?>
                            <option value="<?php echo($row['livello_4']) ?>"><?php echo($row['livello_4']) ?></option>
    <?php } ?>
                    </select>
                </div></td>
        </tr>

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaTerzoLivello();" value="TerzoLivello"/><?php echo $filtroTerzoLivello ?></td>
            <td  bgcolor="#FFFFFF"><div id="LivelloTre" style="visibility:hidden;">
                    <select id="TerzoLivello" name="TerzoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&TerzoLivello=' + this.form.TerzoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlLiv3)) {
                            ?>
                            <option value="<?php echo($row['livello_3']) ?>"><?php echo($row['livello_3']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaSecondoLivello();" value="SecondoLivello" /><?php echo $filtroSecondoLivello ?> </td>
            <td  bgcolor="#FFFFFF"><div id="LivelloDue" style="visibility:hidden;">
                    <select id="SecondoLivello" name="SecondoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&SecondoLivello=' + this.form.SecondoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
                    <?php
                    while ($row = mysql_fetch_array($sqlLiv2)) {
                        ?>
                            <option value="<?php echo($row['livello_2']) ?>"><?php echo($row['livello_2']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaPrimoLivello();" value="PrimoLivello" /><?php echo $filtroPrimoLivello ?> </td>
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
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
                    <?php
                    while ($row = mysql_fetch_array($sqlLiv1)) {
                        ?>
                            <option value="<?php echo($row['livello_1']) ?>"><?php echo($row['livello_1']) ?> </option>
                    <?php } ?>
                    </select>
                </div></td>
        </tr>
    </table>
                    <?php } ?>

                    <?php if ($LivelloGruppo == 'TerzoLivello') { ?>	
    <table width="100%">


        <tr id="96">
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaSestoLivello();" value="SestoLivello" /><?php echo $filtroSestoLivello ?> </td>
            <td  bgcolor="#FFFFFF"><div id="LivelloSei" style="visibility:hidden;">
                    <select id="SestoLivello" name="SestoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&SestoLivello=' + this.form.SestoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
                    <?php
                    while ($row = mysql_fetch_array($sqlLiv6)) {
                        ?>
                            <option value="<?php echo($row['livello_6']) ?>"><?php echo($row['livello_6']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaQuintoLivello();" value="QuintoLivello" /><?php echo $filtroQuintoLivello ?> </td>
            <td   bgcolor="#FFFFFF"><div id="LivelloCinque" style="visibility:hidden;">
                    <select id="QuintoLivello" name="QuintoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&QuintoLivello=' + this.form.QuintoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
    <?php
    while ($row = mysql_fetch_array($sqlLiv5)) {
        ?>
                            <option value="<?php echo($row['livello_5']) ?>"><?php echo($row['livello_5']) ?></option>
                    <?php } ?>
                    </select>
                </div></td>
        </tr> 

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaQuartoLivello();" value="QuartoLivello" /><?php echo $filtroQuartoLivello ?> </td>
            <td  bgcolor="#FFFFFF"><div id="LivelloQuattro" style="visibility:hidden;" >
                    <select id="QuartoLivello" name="QuartoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&QuartoLivello=' + this.form.QuartoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
    <?php
    while ($row = mysql_fetch_array($sqlLiv4)) {
        ?>
                            <option value="<?php echo($row['livello_4']) ?>"><?php echo($row['livello_4']) ?></option>
                    <?php } ?>
                    </select>
                </div></td>
        </tr>

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaTerzoLivello();" value="TerzoLivello" checked="checked"/><?php echo $filtroTerzoLivello ?></td>
            <td  bgcolor="#FFFFFF"><div id="LivelloTre" >
                    <select id="TerzoLivello" name="TerzoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&TerzoLivello=' + this.form.TerzoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
                        <option value="<?php echo $Gruppo; ?>" selected><?php echo $Gruppo; ?></option>
    <?php
    while ($row = mysql_fetch_array($sqlLiv3)) {
        ?>
                            <option value="<?php echo($row['livello_3']) ?>"><?php echo($row['livello_3']) ?></option>
                    <?php } ?>
                    </select>
                </div></td>
        </tr>

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaSecondoLivello();" value="SecondoLivello" /><?php echo $filtroSecondoLivello ?> </td>
            <td  bgcolor="#FFFFFF"><div id="LivelloDue" style="visibility:hidden;">
                    <select id="SecondoLivello" name="SecondoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&SecondoLivello=' + this.form.SecondoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
                    <?php
                    while ($row = mysql_fetch_array($sqlLiv2)) {
                        ?>
                            <option value="<?php echo($row['livello_2']) ?>"><?php echo($row['livello_2']) ?></option>
                    <?php } ?>
                    </select>
                </div></td>
        </tr>

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick=	       	"javascript:visualizzaPrimoLivello();" value="PrimoLivello" /><?php echo $filtroPrimoLivello ?> </td>
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
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlLiv1)) {
                            ?>
                            <option value="<?php echo($row['livello_1']) ?>"><?php echo($row['livello_1']) ?> </option>
    <?php } ?>
                    </select>
                </div></td>
        </tr>
    </table>
                <?php } ?>

                <?php if ($LivelloGruppo == 'SecondoLivello') { ?>	
    <table width="100%">


        <tr id="96">
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaSestoLivello();" value="SestoLivello" /><?php echo $filtroSestoLivello ?> </td>
            <td  bgcolor="#FFFFFF"><div id="LivelloSei" style="visibility:hidden;">
                    <select id="SestoLivello" name="SestoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&SestoLivello=' + this.form.SestoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
    <?php
    
    while ($row = mysql_fetch_array($sqlLiv6)) {
        ?>
                            <option value="<?php echo($row['livello_6']) ?>"><?php echo($row['livello_6']) ?></option>
                    <?php } ?>
                    </select>
                </div></td>
        </tr>

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaQuintoLivello();" value="QuintoLivello" /><?php echo $filtroQuintoLivello ?> </td>
            <td   bgcolor="#FFFFFF"><div id="LivelloCinque" style="visibility:hidden;">
                    <select id="QuintoLivello" name="QuintoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&QuintoLivello=' + this.form.QuintoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
    <?php
    while ($row = mysql_fetch_array($sqlLiv5)) {
        ?>
                            <option value="<?php echo($row['livello_5']) ?>"><?php echo($row['livello_5']) ?></option>
    <?php } ?>
                    </select>
                </div></td>
        </tr> 

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaQuartoLivello();" value="QuartoLivello" /><?php echo $filtroQuartoLivello ?> </td>
            <td  bgcolor="#FFFFFF"><div id="LivelloQuattro" style="visibility:hidden;" >
                    <select id="QuartoLivello" name="QuartoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&QuartoLivello=' + this.form.QuartoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlLiv4)) {
                            ?>
                            <option value="<?php echo($row['livello_4']) ?>"><?php echo($row['livello_4']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaTerzoLivello();" value="TerzoLivello" /><?php echo $filtroTerzoLivello ?></td>
            <td  bgcolor="#FFFFFF"><div id="LivelloTre" style="visibility:hidden;">
                    <select id="TerzoLivello" name="TerzoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&TerzoLivello=' + this.form.TerzoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
                    <?php
//                            $sql = mysql_query("SELECT DISTINCT(livello_3)AS livello_3 FROM gruppo WHERE livello_3 IS NOT NULL AND livello_3<>''ORDER BY livello_3") or die("Errore 108: " . mysql_error());
                            while ($row = mysql_fetch_array($sqlLiv3)) {
                                ?>
                            <option value="<?php echo($row['livello_3']) ?>"><?php echo($row['livello_3']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaSecondoLivello();" value="SecondoLivello" checked="checked"/><?php echo $filtroSecondoLivello ?> </td>
            <td  bgcolor="#FFFFFF"><div id="LivelloDue" >
                    <select id="SecondoLivello" name="SecondoLivello"onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&SecondoLivello=' + this.form.SecondoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
                        <option value="<?php echo $Gruppo; ?>" selected ><?php echo $Gruppo; ?></option>
                    <?php
                    while ($row = mysql_fetch_array($sqlLiv2)) {
                        ?>
                            <option value="<?php echo($row['livello_2']) ?>"><?php echo($row['livello_2']) ?></option>
    <?php } ?>
                    </select>
                </div></td>
        </tr>

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick=	       	"javascript:visualizzaPrimoLivello();" value="PrimoLivello" /><?php echo $filtroPrimoLivello ?> </td>
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
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlLiv1)) {
                            ?>
                            <option value="<?php echo($row['livello_1']) ?>"><?php echo($row['livello_1']) ?> </option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
    </table>
<?php } ?>

<?php if ($LivelloGruppo == 'PrimoLivello') { ?>	
    <table width="100%">
        <tr id="96">
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaSestoLivello();" value="SestoLivello" /><?php echo $filtroSestoLivello ?> </td>
            <td  bgcolor="#FFFFFF"><div id="LivelloSei" style="visibility:hidden;">
                    <select id="SestoLivello" name="SestoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&SestoLivello=' + this.form.SestoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlLiv6)) {
                            ?>
                            <option value="<?php echo($row['livello_6']) ?>"><?php echo($row['livello_6']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaQuintoLivello();" value="QuintoLivello" /><?php echo $filtroQuintoLivello ?> </td>
            <td   bgcolor="#FFFFFF"><div id="LivelloCinque" style="visibility:hidden;">
                    <select id="QuintoLivello" name="QuintoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&QuintoLivello=' + this.form.QuintoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
                    <?php
                    while ($row = mysql_fetch_array($sqlLiv5)) {
                        ?>
                            <option value="<?php echo($row['livello_5']) ?>"><?php echo($row['livello_5']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr> 

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaQuartoLivello();" value="QuartoLivello" /><?php echo $filtroQuartoLivello ?> </td>
            <td  bgcolor="#FFFFFF"><div id="LivelloQuattro" style="visibility:hidden;" >
                    <select id="QuartoLivello" name="QuartoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&QuartoLivello=' + this.form.QuartoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
    <?php
    while ($row = mysql_fetch_array($sqlLiv4)) {
        ?>
                            <option value="<?php echo($row['livello_4']) ?>"><?php echo($row['livello_4']) ?></option>
                    <?php } ?>
                    </select>
                </div></td>
        </tr>

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaTerzoLivello();" value="TerzoLivello" /><?php echo $filtroTerzoLivello ?></td>
            <td  bgcolor="#FFFFFF"><div id="LivelloTre" style="visibility:hidden;">
                    <select id="TerzoLivello" name="TerzoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&TerzoLivello=' + this.form.TerzoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
    <?php
    while ($row = mysql_fetch_array($sqlLiv5)) {
        ?>
                            <option value="<?php echo($row['livello_3']) ?>"><?php echo($row['livello_3']) ?></option>
                    <?php } ?>
                    </select>
                </div></td>
        </tr>

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaSecondoLivello();" value="SecondoLivello" /><?php echo $filtroSecondoLivello ?> </td>
            <td  bgcolor="#FFFFFF"><div id="LivelloDue" style="visibility:hidden;">
                    <select id="SecondoLivello" name="SecondoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&SecondoLivello=' + this.form.SecondoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
    <?php
    while ($row = mysql_fetch_array($sqlLiv2)) {
        ?>
                            <option value="<?php echo($row['livello_2']) ?>"><?php echo($row['livello_2']) ?></option>
    <?php } ?>
                    </select>
                </div></td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick=	       	"javascript:visualizzaPrimoLivello();" value="PrimoLivello" checked="checked"/><?php echo $filtroPrimoLivello ?> </td>
            <td bgcolor="#FFFFFF"><div id="LivelloUno" >
                    <select id="PrimoLivello" name="PrimoLivello" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&PrimoLivello=' + this.form.PrimoLivello.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGruppoDefault ?></option> 
                        <option value="<?php echo $Gruppo; ?>" selected><?php echo $Gruppo; ?></option>
                        <?php
                        while ($row = mysql_fetch_array($sqlLiv1)) {
                            ?>
                            <option value="<?php echo($row['livello_1']) ?>"><?php echo($row['livello_1']) ?> </option>
                    <?php } ?>
                    </select>
                </div></td>
        </tr>
    </table>
                    <?php }
                    ?>

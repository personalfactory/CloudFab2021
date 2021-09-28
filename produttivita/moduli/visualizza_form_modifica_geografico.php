<!--############################################################################-->
<!--########################### PRODUTTIVITA  ##################################-->
<!--############################################################################-->	
<?php
begin();
$sqlMondo = selectDistinctCampoByNome("mondo", "mondo");
$sqlCont = selectDistinctCampoByNome("continente", "nome_continente");
$sqlSt = selectDistinctCampoByNome("stato", "nome_stato");
$sqlReg = selectDistinctCampoByNome("regione", "nome_regione");
$sqlProv = selectDistinctCampoByNome("provincia", "nome_provincia");
$sqlCom = selectDistinctCampoByNome("comune", "nome_comune");
commit();


$TipoRiferimento = $_SESSION['TipoRiferimento'];
$Geografico = $_SESSION['Geografico'];

if ($TipoRiferimento == 'Mondo') {
    ?>
    <table width="100%">
        <tr>
            <td  class="cella7">
                <input type="radio" id="scegli_geografico" name="scegli_geografico"	onclick="javascript:visualizzaMondo();" value="Mondo" checked="checked"/><?php echo $filtroMondo ?></td>
            <td bgcolor="#FFFFFF">
                <div id="Mondo" >
                    <select id="Mondo" name="Mondo" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Mondo=' + this.form.Mondo.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 

                        <?php
                        while ($row = mysql_fetch_array($sqlMondo)) {
                            ?>
                            <option value="<?php echo $Geografico; ?>" selected ><?php echo $Geografico; ?></option>
                        <?php } ?>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaContinente();" value="Continente" /><?php echo $filtroContinente ?></td>
            <td bgcolor="#FFFFFF"><div id="Continente" style="visibility:hidden;">
                    <select id="NomeContinente" name="Continente" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Continente=' + this.form.NomeContinente.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlCont)) {
                            ?>
                            <option value="<?php echo($row['nome_continente']) ?>"><?php echo($row['nome_continente']) ?> </option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaStato();" value="Stato" /><?php echo $filtroStato ?></td>
            <td  bgcolor="#FFFFFF"><div id="Stato" style="visibility:hidden;">
                    <select id="NomeStato" name="Stato" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Stato=' + this.form.NomeStato.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlSt)) {
                            ?>
                            <option value="<?php echo($row['nome_stato']) ?>"><?php echo($row['nome_stato']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaRegione();" value="Regione"/><?php echo $filtroRegione ?></td>
            <td  bgcolor="#FFFFFF"><div id="Regione" style="visibility:hidden;">
                    <select id="NomeRegione" name="Regione" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Regione=' + this.form.NomeRegione.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlReg)) {
                            ?>
                            <option value="<?php echo($row['nome_regione']) ?>"><?php echo($row['nome_regione']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaProvincia();" value="Provincia" /><?php echo $filtroProvincia ?></td>
            <td  bgcolor="#FFFFFF"><div id="Provincia" style="visibility:hidden;">
                    <select id="NomeProvincia" name="Provincia" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Provincia=' + this.form.NomeProvincia.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlProv)) {
                            ?>
                            <option value="<?php echo($row['nome_provincia']) ?>"><?php echo($row['nome_provincia']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaComune();" value="Comune" />
                <?php echo $filtroComune ?></td>
            <td  bgcolor="#FFFFFF"><div id="Comune" style="visibility:hidden;">
                    <select id="NomeComune" name="Comune" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Comune=' + this.form.NomeComune.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlCom)) {
                            ?>
                            <option value="<?php echo($row['nome_comune']) ?>"><?php echo($row['nome_comune']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
    </table>
<?php } ?>

<?php if ($TipoRiferimento == 'Continente') { ?>
    <table width="100%">
        
        <tr>
            <td  class="cella7">
                <input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaMondo();" value="Mondo" /> 
                <?php echo $filtroMondo ?></td>
            <td bgcolor="#FFFFFF">
                <div id="Mondo" style="visibility:hidden;">
                    <select id="Mondo" name="Mondo" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Mondo=' + this.form.Mondo.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 

                        <?php
                        while ($row = mysql_fetch_array($sqlMondo)) {
                            ?>
                            <option value="<?php echo($row['mondo']) ?>"><?php echo($row['mondo']) ?></option>
                        <?php } ?>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick=	       		"javascript:visualizzaContinente();" value="Continente" checked="checked"/>
                <?php echo $filtroContinente ?></td>
            <td bgcolor="#FFFFFF"><div id="Continente" >
                    <select id="NomeContinente" name="Continente" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Continente=' + this.form.NomeContinente.value +
                                '&Submit=1', 'SettaVar');">

                        <option value="<?php echo $Geografico; ?>" selected ><?php echo $Geografico; ?></option>
                        <?php
                        while ($row = mysql_fetch_array($sqlCont)) {
                            ?>
                            <option value="<?php echo($row['nome_continente']) ?>"><?php echo($row['nome_continente']) ?> </option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaStato();" value="Stato" />
                <?php echo $filtroStato ?></td>
            <td  bgcolor="#FFFFFF"><div id="Stato" style="visibility:hidden;">
                    <select id="NomeStato" name="Stato" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Stato=' + this.form.NomeStato.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 

                        <?php
                        while ($row = mysql_fetch_array($sqlSt)) {
                            ?>
                            <option value="<?php echo($row['nome_stato']) ?>"><?php echo($row['nome_stato']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaRegione();" value="Regione"/>
                <?php echo $filtroRegione ?></td>
            <td  bgcolor="#FFFFFF"><div id="Regione" style="visibility:hidden;">
                    <select id="NomeRegione" name="Regione" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Regione=' + this.form.NomeRegione.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlReg)) {
                            ?>
                            <option value="<?php echo($row['nome_regione']) ?>"><?php echo($row['nome_regione']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaProvincia();" value="Provincia" />
                <?php echo $filtroProvincia ?></td>
            <td  bgcolor="#FFFFFF"><div id="Provincia" style="visibility:hidden;">
                    <select id="NomeProvincia" name="Provincia" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Provincia=' + this.form.NomeProvincia.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlProv)) {
                            ?>
                            <option value="<?php echo($row['nome_provincia']) ?>"><?php echo($row['nome_provincia']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaComune();" value="Comune" />
                <?php echo $filtroComune ?></td>
            <td  bgcolor="#FFFFFF"><div id="Comune" style="visibility:hidden;">
                    <select id="NomeComune" name="Comune" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Comune=' + this.form.NomeComune.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlCom)) {
                            ?>
                            <option value="<?php echo($row['nome_comune']) ?>"><?php echo($row['nome_comune']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
    </table>
<?php } ?>

<?php if ($TipoRiferimento == 'Stato') { ?>
    <table width="100%">

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" 					 										onclick="javascript:visualizzaMondo();" value="Mondo" > 
                <?php echo $filtroMondo ?></td>
            <td bgcolor="#FFFFFF">
                <div id="Mondo" style="visibility:hidden;">
                    <select id="Mondo" name="Mondo" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Mondo=' + this.form.Mondo.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 

                        <?php
                        while ($row = mysql_fetch_array($sqlMondo)) {
                            ?>
                            <option value="<?php echo($row['mondo']) ?>"><?php echo($row['mondo']) ?></option>
                        <?php } ?>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick=	       		"javascript:visualizzaContinente();" value="Continente" />
                <?php echo $filtroContinente ?></td>
            <td bgcolor="#FFFFFF"><div id="Continente" style="visibility:hidden;" >
                    <select id="NomeContinente" name="Continente" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Continente=' + this.form.NomeContinente.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlCont)) {
                            ?>
                            <option value="<?php echo($row['nome_continente']) ?>"><?php echo($row['nome_continente']) ?> </option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaStato();" value="Stato" checked="checked"/>
                <?php echo $filtroStato ?></td>
            <td  bgcolor="#FFFFFF"><div id="Stato" >
                    <select id="NomeStato" name="Stato" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Stato=' + this.form.NomeStato.value +
                                '&Submit=1', 'SettaVar');">
                        <option value="<?php echo $Geografico; ?>" selected><?php echo $Geografico; ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlSt)) {
                            ?>
                            <option value="<?php echo($row['nome_stato']) ?>"><?php echo($row['nome_stato']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaRegione();" value="Regione"/>
                <?php echo $filtroRegione ?></td>
            <td  bgcolor="#FFFFFF"><div id="Regione" style="visibility:hidden;">
                    <select id="NomeRegione" name="Regione" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Regione=' + this.form.NomeRegione.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlReg)) {
                            ?>
                            <option value="<?php echo($row['nome_regione']) ?>"><?php echo($row['nome_regione']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaProvincia();" value="Provincia" />
                <?php echo $filtroProvincia ?></td>
            <td  bgcolor="#FFFFFF"><div id="Provincia" style="visibility:hidden;">
                    <select id="NomeProvincia" name="Provincia" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Provincia=' + this.form.NomeProvincia.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlProv)) {
                            ?>
                            <option value="<?php echo($row['nome_provincia']) ?>"><?php echo($row['nome_provincia']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaComune();" value="Comune" />
                <?php echo $filtroComune ?></td>
            <td  bgcolor="#FFFFFF"><div id="Comune" style="visibility:hidden;">
                    <select id="NomeComune" name="Comune" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Comune=' + this.form.NomeComune.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlCom)) {
                            ?>
                            <option value="<?php echo($row['nome_comune']) ?>"><?php echo($row['nome_comune']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
    </table>
<?php } ?>

<?php if ($TipoRiferimento == 'Regione') { ?>
    <table width="100%">

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaMondo();" value="Mondo" > 
                <?php echo $filtroMondo ?></td>
            <td bgcolor="#FFFFFF">
                <div id="Mondo" style="visibility:hidden;">
                    <select id="Mondo" name="Mondo" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Mondo=' + this.form.Mondo.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 

                        <?php
                        while ($row = mysql_fetch_array($sqlMondo)) {
                            ?>
                            <option value="<?php echo($row['mondo']) ?>"><?php echo($row['mondo']) ?></option>
                        <?php } ?>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick=	       		"javascript:visualizzaContinente();" value="Continente" />
                <?php echo $filtroContinente ?></td>
            <td bgcolor="#FFFFFF"><div id="Continente" style="visibility:hidden;" >
                    <select id="NomeContinente" name="Continente" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Continente=' + this.form.NomeContinente.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlCont)) {
                            ?>
                            <option value="<?php echo($row['nome_continente']) ?>"><?php echo($row['nome_continente']) ?> </option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaStato();" value="Stato" />
                <?php echo $filtroStato ?></td>
            <td  bgcolor="#FFFFFF"><div id="Stato" style="visibility:hidden;" >
                    <select id="NomeStato" name="Stato" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Stato=' + this.form.NomeStato.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlSt)) {
                            ?>
                            <option value="<?php echo($row['nome_stato']) ?>"><?php echo($row['nome_stato']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaRegione();" value="Regione" checked="checked"/>
                <?php echo $filtroRegione ?></td>
            <td  bgcolor="#FFFFFF"><div id="Regione" >
                    <select id="NomeRegione" name="Regione" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Regione=' + this.form.NomeRegione.value +
                                '&Submit=1', 'SettaVar');">
                        <option value="<?php echo $Geografico; ?>" selected><?php echo $Geografico; ?></option>
                        <?php
                        while ($row = mysql_fetch_array($sqlReg)) {
                            ?>
                            <option value="<?php echo($row['nome_regione']) ?>"><?php echo($row['nome_regione']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaProvincia();" value="Provincia" />
                <?php echo $filtroProvincia ?></td>
            <td  bgcolor="#FFFFFF"><div id="Provincia" style="visibility:hidden;">
                    <select id="NomeProvincia" name="Provincia" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Provincia=' + this.form.NomeProvincia.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlProv)) {
                            ?>
                            <option value="<?php echo($row['nome_provincia']) ?>"><?php echo($row['nome_provincia']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaComune();" value="Comune" />
                <?php echo $filtroComune ?></td>
            <td  bgcolor="#FFFFFF"><div id="Comune" style="visibility:hidden;">
                    <select id="NomeComune" name="Comune" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Comune=' + this.form.NomeComune.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlCom)) {
                            ?>
                            <option value="<?php echo($row['nome_comune']) ?>"><?php echo($row['nome_comune']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
    </table>
<?php } ?>
<?php if ($TipoRiferimento == 'Provincia') { ?>
    <table width="100%">
       
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" 					 										onclick="javascript:visualizzaMondo();" value="Mondo" > 
                <?php echo $filtroMondo ?></td>
            <td  bgcolor="#FFFFFF"><div id="Mondo" style="visibility:hidden;">Riferimento MONDO</div></td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick=	       		"javascript:visualizzaContinente();" value="Continente" />
                <?php echo $filtroContinente ?></td>
            <td bgcolor="#FFFFFF"><div id="Continente" style="visibility:hidden;" >
                    <select id="NomeContinente" name="Continente" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Continente=' + this.form.NomeContinente.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlCont)) {
                            ?>
                            <option value="<?php echo($row['nome_continente']) ?>"><?php echo($row['nome_continente']) ?> </option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaStato();" value="Stato" />
                <?php echo $filtroStato ?></td>
            <td  bgcolor="#FFFFFF"><div id="Stato" style="visibility:hidden;" >
                    <select id="NomeStato" name="Stato" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Stato=' + this.form.NomeStato.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlSt)) {
                            ?>
                            <option value="<?php echo($row['nome_stato']) ?>"><?php echo($row['nome_stato']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaRegione();" value="Regione" />
                <?php echo $filtroRegione ?></td>
            <td  bgcolor="#FFFFFF"><div id="Regione" style="visibility:hidden;">
                    <select id="NomeRegione" name="Regione" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Regione=' + this.form.NomeRegione.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlReg)) {
                            ?>
                            <option value="<?php echo($row['nome_regione']) ?>"><?php echo($row['nome_regione']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaProvincia();" value="Provincia" checked="checked"/>
                <?php echo $filtroProvincia ?></td>
            <td  bgcolor="#FFFFFF"><div id="Provincia" >
                    <select id="NomeProvincia" name="Provincia" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Provincia=' + this.form.NomeProvincia.value +
                                '&Submit=1', 'SettaVar');">
                        <option value="<?php echo $Geografico; ?>" selected><?php echo $Geografico; ?></option>
                        <?php
                        while ($row = mysql_fetch_array($sqlProv)) {
                            ?>
                            <option value="<?php echo($row['nome_provincia']) ?>"><?php echo($row['nome_provincia']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaComune();" value="Comune" />
                <?php echo $filtroComune ?></td>
            <td  bgcolor="#FFFFFF"><div id="Comune" style="visibility:hidden;">
                    <select id="NomeComune" name="Comune" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Comune=' + this.form.NomeComune.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlCom)) {
                            ?>
                            <option value="<?php echo($row['nome_comune']) ?>"><?php echo($row['nome_comune']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
    </table>
<?php } ?>
<?php if ($TipoRiferimento == 'Comune') { ?>
    <table width="100%">

        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" 					 										onclick="javascript:visualizzaMondo();" value="Mondo" > 
                <?php echo $filtroMondo ?></td>
            <td bgcolor="#FFFFFF">
                <div id="Mondo" style="visibility:hidden;">
                    <select id="Mondo" name="Mondo" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Mondo=' + this.form.Mondo.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 

                        <?php
                        while ($row = mysql_fetch_array($sqlMondo)) {
                            ?>
                            <option value="<?php echo($row['mondo']) ?>"><?php echo($row['mondo']) ?></option>
                        <?php } ?>
                    </select>
                </div>
            </td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick=	       		"javascript:visualizzaContinente();" value="Continente" />
                <?php echo $filtroContinente ?></td>
            <td bgcolor="#FFFFFF"><div id="Continente" style="visibility:hidden;" >
                    <select id="NomeContinente" name="Continente" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Continente=' + this.form.NomeContinente.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlCont)) {
                            ?>
                            <option value="<?php echo($row['nome_continente']) ?>"><?php echo($row['nome_continente']) ?> </option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaStato();" value="Stato" />
                <?php echo $filtroStato ?></td>
            <td  bgcolor="#FFFFFF"><div id="Stato" style="visibility:hidden;" >
                    <select id="NomeStato" name="Stato" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Stato=' + this.form.NomeStato.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlSt)) {
                            ?>
                            <option value="<?php echo($row['nome_stato']) ?>"><?php echo($row['nome_stato']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaRegione();" value="Regione" />
                <?php echo $filtroRegione ?></td>
            <td  bgcolor="#FFFFFF"><div id="Regione" style="visibility:hidden;">
                    <select id="NomeRegione" name="Regione" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Regione=' + this.form.NomeRegione.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlReg)) {
                            ?>
                            <option value="<?php echo($row['nome_regione']) ?>"><?php echo($row['nome_regione']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaProvincia();" value="Provincia" />
                <?php echo $filtroProvincia ?></td>
            <td  bgcolor="#FFFFFF"><div id="Provincia" style="visibility:hidden;" >
                    <select id="NomeProvincia" name="Provincia" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Provincia=' + this.form.NomeProvincia.value +
                                '&Submit=1', 'SettaVar');">
                        <option value=""><?php echo $labelOptionGeoDefault ?></option> 
                        <?php
                        while ($row = mysql_fetch_array($sqlProv)) {
                            ?>
                            <option value="<?php echo($row['nome_provincia']) ?>"><?php echo($row['nome_provincia']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
        <tr>
            <td  class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaComune();" value="Comune" checked="checked"/>
                <?php echo $filtroComune ?></td>
            <td  bgcolor="#FFFFFF"><div id="Comune" >
                    <select id="NomeComune" name="Comune" onChange="javascript:window.open('/CloudFab/produttivita/setta_var_produttivita.php?Data3=' + this.form.date3.value +
                                '&Data4=' + this.form.date4.value +
                                '&Stabilimento=' + this.form.Stabilimento.value +
                                '&OreDaEscludere=' + this.form.OreDaEscludere.value +
                                '&Inattivita=' + this.form.Inattivita.value +
                                '&Operatore=' + this.form.Operatore.value +
                                '&Prodotto=' + this.form.Prodotto.value +
                                '&Comune=' + this.form.NomeComune.value +
                                '&Submit=1', 'SettaVar');">
                        <option value="<?php echo $Geografico; ?>" selected><?php echo $Geografico; ?></option>
                        <?php
                        while ($row = mysql_fetch_array($sqlCom)) {
                            ?>
                            <option value="<?php echo($row['nome_comune']) ?>"><?php echo($row['nome_comune']) ?></option>
                        <?php } ?>
                    </select>
                </div></td>
        </tr>
    </table>
<?php } ?>
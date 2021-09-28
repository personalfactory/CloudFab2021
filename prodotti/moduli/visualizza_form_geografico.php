<?php 
begin();
$sqlCont = selectDistinctCampoByNome("continente","nome_continente");
$sqlSt = selectDistinctCampoByNome("stato","nome_stato");
$sqlReg = selectDistinctCampoByNome("regione","nome_regione");
$sqlProv = selectDistinctCampoByNome("provincia","nome_provincia");
$sqlCom = selectDistinctCampoByNome("comune","nome_comune");
commit();
?>

<table width="100%">
    <tr>
        <td class="cella3" colspan="2"><div id="MSG"><?php echo $labelOptionSelectRifGeo ?></div></td>
    </tr>
 
  <tr>
    <td  class="cella7">
        <input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaMondo();" value="Mondo" checked="checked"/> 
      <?php echo $filtroMondo ?></td>
    <td bgcolor="#FFFFFF"><div id="Mondo"><?php echo $filtroRiferMondo ?></div></td>
  </tr>
  <tr>
    <td class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaContinente();" value="Continente" />
      <?php echo $filtroContinente ?></td>
    <td bgcolor="#FFFFFF"><div id="Continente" style="visibility:hidden;">
        <select id="NomeContinente" name="Continente">
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
        <select id="NomeStato" name="Stato">
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
        <select id="NomeRegione" name="Regione">
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
        <select id="NomeProvincia" name="Provincia">
<?php       
while ($row = mysql_fetch_array($sqlProv)) {
  ?>
            <option value="<?php echo($row['nome_provincia']) ?>"><?php echo($row['nome_provincia']) ?></option>
          <?php } ?>
        </select>
      </div></td>
  </tr>
  <tr>
    <td  width="150" class="cella7"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaComune();" value="Comune" />
      <?php echo $filtroComune ?></td>
    <td  bgcolor="#FFFFFF"><div id="Comune" style="visibility:hidden;">
        <select id="NomeComune" name="Comune">
<?php     
while ($row = mysql_fetch_array($sqlCom)) {
  ?>
            <option value="<?php echo($row['nome_comune']) ?>"><?php echo($row['nome_comune']) ?></option>
          <?php } ?>
        </select>
      </div></td>
  </tr>
</table>
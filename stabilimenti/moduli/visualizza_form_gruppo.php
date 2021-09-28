<?php

begin();
$sqlLiv5 = selectCampoByNome("livello_5",$strUtAzGruppo);
$sqlLiv4 = selectCampoByNome("livello_4",$strUtAzGruppo);
$sqlLiv3 = selectCampoByNome("livello_3",$strUtAzGruppo);
$sqlLiv2 = selectCampoByNome("livello_2",$strUtAzGruppo);
$sqlLiv1 = selectCampoByNome("livello_1",$strUtAzGruppo);
commit();
?>	
<!--################################################################################-->
<!--########################### STABILIMENTI #######################################-->
<!--################################################################################-->	

  <table width="100%">
      <tr>
            <td colspan="2" class="cella3"><div id="MSG"><?php echo $labelOptionSelectGruppoAcq ?></div></td>
        </tr>
   <tr id="96">
        <td   class="cella7">
            <input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaSestoLivello();" value="SestoLivello" /><?php echo $filtroSestoLivello ?></td>
        <td bgcolor="#FFFFFF"><div id="SestoLivello" style="visibility:hidden;"><?php echo $filtroUniversale ?></div></td>
        </tr>   
    <tr>
       <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaQuintoLivello();" value="QuintoLivello" checked="checked"/><?php echo $filtroQuintoLivello ?></td>
      <td   bgcolor="#FFFFFF"><div id="LivelloCinque" >
          <select id="QuintoLivello" name="QuintoLivello">
            <?php
            while ($row = mysql_fetch_array($sqlLiv5)) {
              ?>
              <option value="<?php echo($row['livello_5']) ?>"><?php echo($row['livello_5']) ?></option>
            <?php } ?>
          </select>
        </div></td>
    </tr> 

    <tr>
       <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaQuartoLivello();" value="QuartoLivello" /><?php echo $filtroQuartoLivello ?></td>
      <td  bgcolor="#FFFFFF"><div id="LivelloQuattro" style="visibility:hidden;">
          <select id="QuartoLivello" name="QuartoLivello">
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
          <select id="TerzoLivello" name="TerzoLivello">
            <?php
            while ($row = mysql_fetch_array($sqlLiv3)) {
              ?>
              <option value="<?php echo($row['livello_3']) ?>"><?php echo($row['livello_3']) ?></option>
            <?php } ?>
          </select>
        </div></td>
    </tr>

    <tr>
       <td  class="cella7"><input type="radio" id="scegli_gruppo" name="scegli_gruppo" onclick="javascript:visualizzaSecondoLivello();" value="SecondoLivello" /><?php echo $filtroSecondoLivello ?></td>
      <td  bgcolor="#FFFFFF"><div id="LivelloDue" style="visibility:hidden;">
          <select id="SecondoLivello" name="SecondoLivello">
            <?php
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
          <select id="PrimoLivello" name="PrimoLivello">
            <?php
            while ($row = mysql_fetch_array($sqlLiv1)) {
              ?>
              <option value="<?php echo($row['livello_1']) ?>"><?php echo($row['livello_1']) ?> </option>
            <?php } ?>
          </select>
        </div></td>
    </tr>
  </table>
 

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
<?php include('../include/validator.php'); ?>
<head>
<?php include('../include/header.php'); ?>
</head>
    <script language="javascript">
        function disabilitaOperazioni() {
            document.getElementById('Salva').disabled = true;
        }
    </script>

<?php 
if($DEBUG) ini_set(display_errors, "1"); 
 //############### STRINGHE AZIENDE SCRIVIBILI ##############################
    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'lab_caratteristica');
    
    //############# STRINGA UTENTI - AZIENDE VIS ###############################
    $strUtentiAziendeVisNorm = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_normativa');      

include('../include/precisione.php');
include('../Connessioni/serverdb.php');
include('sql/script_lab_caratteristica.php');
include('sql/script_lab_normativa.php');
include('sql/script.php');

$IdCaratteristica=$_GET['IdCaratteristica'];

$sqlNorma = findAllNormativeVis($strUtentiAziendeVisNorm);
//Visualizzo il record che intendo modificare all'interno della form
$sql = findCaratteristicaById($IdCaratteristica);
       	while($row=mysql_fetch_array($sql))
	{
		
		$Descrizione=$row['descri_caratteristica'];
                $Caratteristica=$row['caratteristica'];
                $UnMisCar=$row['uni_mis_car'];
		$TipoDato=$row['tipo_dato'];
                $Dimensione=$row['dimensione'];
                $UnMisDim=$row['uni_mis_dim'];       
                $Metodologia=$row['metodologia']; 
                $Normativa=$row['normativa'];
		$Abilitato=$row['abilitato'];
		$Data=$row['dt_abilitato'];
                $IdAzienda = $row['id_azienda'];
                $IdUtenteProp = $row['id_utente'];
            }
            $NomeAzienda = getNomeAziendaById($_SESSION['objUtility'], $IdAzienda);
	 //######################################################################
        //#################### GESTIONE UTENTI #################################
        //######################################################################            
        //Si recupera il proprietario del parametro e si verifica se l'utente 
        //corrente ha il permesso di editare  i dati di quell'utente proprietario 
        //nelle tabella lab_parametro
        //Se non ha il permesso bisogna disabilitare i pulsanti di salvataggio...
        //############# VERIFICA PERMESSO DI SCRITTURA E MODIFICA ##############
        $actionOnLoad="";
        $arrayTabelleCoinvolte = array("lab_caratteristica");
        if ($IdUtenteProp != $_SESSION['id_utente']) {
            //Se il proprietario del dato è un utente diverso dall'utente 
            //corrente si verifica il permesso 3
            if ($DEBUG)
                echo "</br>Eseguita verifica permesso di tipo 3";
            $actionOnLoad = $actionOnLoad . verificaPermModifica3($_SESSION['objPermessiVis'], $arrayTabelleCoinvolte, $IdUtenteProp, $IdAzienda);
        }

        //######################################################################
        ?>
    <body onLoad="<?php echo $actionOnLoad ?>">
        <div id="labContainer">

            <?php
            include('../include/menu.php'); ?>

<div id="container" style="width:60%; margin:15px auto;">
<form id="ModificaCaratteristica" name="ModificaCaratteristica" method="post" action="modifica_lab_caratteristica2.php">
    <table style="width:100%;">
		<input type="hidden" name="IdCaratteristica" id="IdCaratteristica" value="<?php echo $IdCaratteristica;?>"></input>
	    <th class="cella3" colspan="2"><?php echo $titoloPaginaLabModificaCar ?></th>
       
            <tr>
            <td class="cella2"><?php echo $filtroLabDescri ?> </td>
            <td class="cella1"><textarea name="Descrizione" id="Descrizione" ROWS="2" COLS="48" value="<?php echo $Descrizione ?>"><?php echo $Descrizione;?></textarea></td>
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroLabCaratteristica ." ".$filtroLabOrdinata?> </td>
            <td class="cella1"><input type="text" name="Caratteristica" id="Caratteristica" size="48px" value="<?php echo $Caratteristica ?>" /></td>
        </tr>
            <tr>
                <td  class="cella2"><?php echo $filtroLabUnMisura ?></td>
                <td class="cella1"><input type="text" name="UniMisCar" id="UniMisCar" value="<?php echo $UnMisCar ?>"/></td>
            </tr>
        <tr>
              <td  class="cella2"><?php echo $filtroLabTipoDato?> </td>
               <td class="cella1">
                <select name="TipoDato" id="TipoDato">
                 <option value="<?php echo $TipoDato ;?>" selected><?php echo $TipoDato ;?></option>
                    <option value="<?php echo $valCarNum?>"><?php echo $filtroLabNumerico ?></option>
                    <option value="<?php echo $valCarTxt?>"><?php echo $filtroLabTesto ?></option>
                    </optgroup>
                  </select></td>
            </tr>
        </tr>
       
         <tr>
                <td  class="cella2"><?php echo $filtroLabDimensione ." ".$filtroLabAscissa ?></td>
                <td class="cella1"><input type="text" name="Dimensione" id="Dimensione" value="<?php echo $Dimensione ?>"/></td>
            </tr>
            <tr>
                <td  class="cella2"><?php echo $filtroLabUnMisura ." ".$filtroLabDimensione?></td>
                <td class="cella1"><input type="text" name="UniMisDim" id="UniMisDim" value="<?php echo $UnMisDim ?>"/></td>
            </tr>
            <tr>
                <td  class="cella2"><?php echo $filtroLabMetodologia ?></td>
                <td class="cella1"><input type="text" name="Metodologia" id="Metodologia" value="<?php echo $Metodologia ?>"/></td>
            </tr>
        <tr>
                <td  class="cella2"><?php echo $filtroLabNorma ?></td>
                <td class="cella1">
                <select name="Normativa" id="Normativa">
                    <option value="<?php echo $Normativa ?>" selected="<?php echo $Normativa ?>"><?php echo $Normativa ?></option>
                    <?php while ($rowNorma = mysql_fetch_array($sqlNorma)) { ?>
                        <option value="<?php echo $rowNorma['normativa']; ?>"><?php echo ($rowNorma['normativa']); ?></option>
                    <?php } ?>
                </select> 
            </td>
            </tr>
            <tr>
                <td class="cella2"><?php echo $filtroLabData ?></td>
                <td class="cella1"><?php echo $Data ?></td>
            </tr>
        <tr>
                                <td class="cella4"><?php echo $filtroAzienda ?></td>
                                <td class="cella1">
                                    <select name="Azienda" id="Azienda"> 
                                        <option value="<?php echo $IdAzienda . ';' . $NomeAzienda; ?>" selected=""><?php echo $NomeAzienda; ?></option>
                                        <?php
                                        //Si selezionano solo le aziende scrivibili dall'utente
                                        for ($a = 0; $a < count($arrayAziendeScrivibili); $a++) {
                                            $idAz = $arrayAziendeScrivibili[$a]->getIdAzienda();
                                            $nomeAz = $arrayAziendeScrivibili[$a]->getNomeAzienda();
                                            if ($idAz != $IdAzienda) {
                                                ?>
                                                <option value="<?php echo( $idAz . ';' . $nomeAz); ?>"><?php echo($nomeAz) ?></option>                                       
                                                <?php
                                            }
                                        }
                                        ?>
                                    </select> 
                                </td>
                            </tr>
       <?php include('../include/tr_reset_submit.php'); ?>
 	</table>
</form>
</div>
<div id="msgLog">
                        <?php
                        if ($DEBUG) {
                           
                           
                            echo "</br>Tabella lab_normativa : utenti e aziende vis : ".$strUtentiAziendeVisNorm;
                            echo "</br>Tabella lab_caratteristica: Aziende scrivibili: </br>";

                            for ($i = 0; $i < count($arrayAziendeScrivibili); $i++) {

                                echo $arrayAziendeScrivibili[$i]->getIdAzienda() . " " . $arrayAziendeScrivibili[$i]->getNomeAzienda() . "</br>";
                            }
                            
                        }
                        ?>
                    </div>
</div><!--mainContainer-->

</body>
</html>

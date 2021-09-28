<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?></head>

    <?php
    if ($DEBUG)
        ini_set("display_errors", "1");
    
    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'bs_cliente');

    //##########################################################################

    include_once('../Connessioni/serverdb.php');
    include_once('../sql/script_utente.php'); //E' già incluso nel validator
    include_once('../include/precisione.php');
    include_once('../include/gestione_date.php');
    include_once('../sql/script_bs_cliente.php');

//    $sqlUtenti = findAllUtenti("cognome");

    $ToDo = $_GET['ToDo'];
    
    $IdCliente="";
    $Nominativo = "";
    $Descrizione = "";
    $Note = "";
    $DefaultUtente = $labelOptionSelectUtenteInephos;
    $Data = dataCorrenteInserimento();

    if ($ToDo == "ModificaCliente" AND $_GET['IdCliente'] > 0) {

        $sql = findClienteBsById($_GET['IdCliente']);
        while ($row = mysql_fetch_array($sql)) {
            $IdCliente=$_GET['IdCliente'];
            $Nominativo = $row['nominativo'];
            $Descrizione = $row['descrizione'];
            $Note = $row['note'];
            $DefaultUtente = $row['nominativo'];//dalla tabella utente
            $Data = $row['dt_abilitato'];
        }
    }
    ?>
    <body>
        <div id="mainContainer">
<?php include('../include/menu.php'); ?>

            <div id="container" style="width:60%; margin:15px auto;">
                <form id="InserisciBsProdotto" name="InserisciBsProdotto" method="post" action="carica_cliente_bs2.php">
                    <table width="100%">
                        <tr>
                            <td class="cella3" colspan="2"><?php echo $titoloPaginaNuovoClienteInBs ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroNominativo ?></td>
                            <td class="cella1"><input type="text" name="Nominativo"  value="<?php echo $Nominativo ?>"/></td>
                        <!--</tr>-->  
                        <tr>
                            <td class="cella2"><?php echo $filtroDescrizione ?></td>
                            <td class="cella1"><input style="width:90%" type="text" name="Descrizione"  value="<?php echo $Descrizione ?>"/></td>
                        </tr> 
                        <tr>
                            <td class="cella2"><?php echo $filtroNote ?></td>
                            <td class="cella1"><textarea style="width:90%" type="text" name="Note"  value="<?php echo $Note ?>"><?php echo $Note ?></textarea></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDt ?></td>
                            <td class="cella1"><?php echo $Data ?></td>
                        </tr>
                        <tr>
                            <td class="cella4"><?php echo $filtroAzienda ?></td>
                            <td class="cella1">
                                <select name="Azienda" id="Azienda"> 
                                     <option value="<?php echo  "1;PersonalFactory"  ?>" selected="selected">PersonalFactory </option>
                                    <!--<option value="<?php // echo $_SESSION['id_azienda'] . ";" . $_SESSION['nome_azienda'] ?>" selected="selected"><?php echo $_SESSION['nome_azienda'] ?></option>-->
<?php
//Si selezionano solo le aziende che l'utente ha il permesso di editare
//for ($a = 0; $a < count($arrayAziendeScrivibili); $a++) {
//    $idAz = $arrayAziendeScrivibili[$a]->getIdAzienda();
//    $nomeAz = $arrayAziendeScrivibili[$a]->getNomeAzienda();
//    if ($idAz != $_SESSION['id_azienda']) {
//        ?>
                                            <!--<option value="//<?php // echo( $idAz . ';' . $nomeAz); ?>"><?php echo($nomeAz) ?></option>-->
                                        //<?php
//                                        }
//                                    }
                                    ?>
                                </select> 
                            </td>
                            
                        <input type="hidden" name="ToDo"  value="<?php echo $ToDo ?>"/>
                        <input type="hidden" name="IdCliente"  value="<?php echo $IdCliente ?>"/>
                        <tr>
                            <td class="cella2" style="text-align: right; " colspan="2">
                                <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                <input type="submit" value="<?php echo $valueButtonSalva ?>"/></td>
                        </tr>
                    </table>
                </form>
            </div>
            <!--            <div id="msgLog">
            <?php
//                if ($DEBUG) {
//                    echo "</br>Tabella utente: utenti e aziende visibili " . $strUtentiAziende;
//                }
            ?>
                        </div>-->
        </div><!--mainContainer-->

    </body>
</html>

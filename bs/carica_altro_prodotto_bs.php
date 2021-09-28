<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?></head>

    <?php
    if ($DEBUG)
        ini_set('display_errors', 1);
    //##########################################################################

    include('../Connessioni/serverdb.php');
    include('../sql/script_prodotto.php');
    include('../sql/script_bs_altri_prodotti.php');
    include('../include/precisione.php');
    include('../include/gestione_date.php');

    $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'prodotto');
    $arrayAziendeScrivibili = getAziendeScrivibili($_SESSION['objPermessiVis'], 'bs_prodotto'); 

    
    $ToDo = $_GET['ToDo'];
    
    $titolo=$titoloPaginaNuovoProdottoBs;
    $IdProdotto="";
    
    $DefaultProdotto = $labelOptionSelectProdottoBS;
    $Classificazione = "";
    $Rating="";
    $PresentazioneProd = "";
    $SchedaTecnica = "";
    $Features = "";
    $Corrispettivo1 = "";
    $Prezzo1 = 0;
    $Note1 = "";
    $Corrispettivo2 = "";
    $Prezzo2 = 0;
    $Note2 = "";
    $Corrispettivo3 = "";
    $Prezzo3 = 0;
    $Note3 = "";
    $DtAbilitato = dataCorrenteInserimento();
    $Costo=0;
    
    
    $CodProdotto = "";
    $NomeProdotto = "";

    if ($ToDo == "ModificaProdotto" AND $_GET['IdProdotto'] > 0) {
        $titolo=$titoloPaginaModificaProdottoBs;
        
        $sql = findBSAltroProdottoById($_GET['IdProdotto']);
        while ($row = mysql_fetch_array($sql)) {
            $IdProdotto=$_GET['IdProdotto'];
            $CodProdotto = $row['cod_prodotto'];
            $NomeProdotto = $row['nome_prodotto'];
            $DefaultProdotto=$CodProdotto." ".$NomeProdotto;
            $Classificazione = $row['classificazione'];
            $Rating=$row['rating'];
            $PresentazioneProd = $row['link_presentazione_prod'];
            $Features = $row['features'];
            $Corrispettivo1 = $row['corrispettivo_1'];
            $Prezzo1 = $row['prezzo_1'];
            $Note1 = $row['note_1'];
            $Corrispettivo2 = $row['corrispettivo_2'];
            $Prezzo2 = $row['prezzo_2'];
            $Note2 = $row['note_2'];
            $Corrispettivo3 = $row['corrispettivo_3'];
            $Prezzo3 = $row['prezzo_3'];
            $Note3 = $row['note_3'];
            $DtAbilitato = $row['dt_abilitato'];
            $Costo = $row['costo'];
            //TO DO : gestire l'azienda nella modifica
            $IdAzienda=$row['id_azienda'];
        }
    }
    ?>
    <body>
        <div id="mainContainer">

<?php include('../include/menu.php'); ?>

            <div id="container" style="width:70%; margin:15px auto;">
                <form id="InserisciBsProdotto" name="InserisciBsProdotto" method="post" action="carica_altro_prodotto_bs2.php" enctype="multipart/form-data">
                    <table width="100%">
                        <tr>
                            <td class="cella3" colspan="2"><?php echo $titolo ?></td>
                        </tr>                        
                         <tr>
                            <td class="cella2"><?php echo $filtroCodProdotto ?></td>
                            <td class="cella1"><input type="text" name="CodProdotto"  value="<?php echo $CodProdotto ?>"/></td>
                        </tr>
                        <input type="hidden" name="IdProdotto"  value="<?php echo $IdProdotto ?>"/>
                         <tr>
                            <td class="cella2"><?php echo $filtroNomeProdotto ?></td>
                            <td class="cella1"><input style="width:90%" type="text" name="NomeProdotto"  value="<?php echo $NomeProdotto ?>"/></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroClassificazione ?></td>
                            <td class="cella1"><input style="width:90%" type="text" name="Classificazione"  value="<?php echo $Classificazione ?>"/></td>
                        </tr> 
                        <tr>
                            <td class="cella2"><?php echo $filtroCostoProduzione ?></td>
                            <td class="cella1"><input style="width:90%" type="text" name="Costo" value="<?php echo $Costo ?>"/><?php echo $filtroEuroQuintale?></td>
                        </tr> 
                        <tr>
                            <td class="cella2"><?php echo $filtroRating ?></td>
                            <td class="cella1"><input type="text" name="Rating"  value="<?php echo $Rating ?>"/></td>
                        </tr>                        
                        <tr>
                            <td class="cella2"><?php echo $filtroFeatures ?></td>
                            <td class="cella1"><textarea style="width:90%" type="text" name="Features"  value="<?php echo $Features ?>"><?php echo $Features ?></textarea></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroCorrispettivo1 ?></td>
                            <td class="cella1"><input style="width:90%" type="text" name="Corrispettivo1"  value="<?php echo $Corrispettivo1 ?>"/></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroPrezzo1 ?></td>
                            <td class="cella1"><input type="text" name="Prezzo1"  value="<?php echo $Prezzo1 ?>"/><?php echo $filtroEuro?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroNote1 ?></td>
                            <td class="cella1"><textarea style="width:90%" type="text" name="Note1"  value="<?php echo $Note1 ?>"><?php echo $Note1 ?></textarea></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroCorrispettivo2 ?></td>
                            <td class="cella1" ><input style="width:90%" type="text" name="Corrispettivo2"  value="<?php echo $Corrispettivo2 ?>"/></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroPrezzo2 ?></td>
                            <td class="cella1"><input type="text" name="Prezzo2"  value="<?php echo $Prezzo2 ?>"/><?php echo $filtroEuro?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroNote2 ?></td>
                            <td class="cella1"><textarea style="width:90%" type="text" name="Note2"  value="<?php echo $Note2 ?>"><?php echo $Note2 ?></textarea></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroCorrispettivo3 ?></td>
                            <td class="cella1"><input style="width:90%" type="text" name="Corrispettivo3"  value="<?php echo $Corrispettivo3 ?>"/></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroPrezzo3 ?></td>
                            <td class="cella1"><input type="text" name="Prezzo3"  value="<?php echo $Prezzo3 ?>"/><?php echo $filtroEuro?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroNote3 ?></td>
                            <td class="cella1"><textarea style="width:90%" type="text" name="Note3"  value="<?php echo $Note3 ?>"><?php echo $Note3 ?></textarea></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDtAbilitato ?></td>
                            <td class="cella1"><input type="text" name="DtAbilitato"  value="<?php echo $DtAbilitato ?>"/></td>
                        </tr>
                        <tr>
                                <td class="cella4"><?php echo $filtroAzienda ?></td>
                                <td class="cella1">
                                    <select name="Azienda" id="Azienda"> 
                                        <option value="<?php echo $_SESSION['id_azienda'] . ";" . $_SESSION['nome_azienda'] ?>" selected="selected"><?php echo $_SESSION['nome_azienda'] ?></option>
    <?php
    //Si selezionano solo le aziende che l'utente ha il permesso di editare
    for ($a = 0; $a < count($arrayAziendeScrivibili); $a++) {
        $idAz = $arrayAziendeScrivibili[$a]->getIdAzienda();
        $nomeAz = $arrayAziendeScrivibili[$a]->getNomeAzienda();
        if ($idAz != $_SESSION['id_azienda']) {
            ?>
                                                <option value="<?php echo( $idAz . ';' . $nomeAz); ?>"><?php echo($nomeAz) ?></option>
                                                <?php }
                                        }
                                        ?>
                                    </select> 
                                </td>
                            </tr>
                        
                        <?php if ($PresentazioneProd!="") { ?>
                        <tr>
                            <td class="cella2"><?php echo $filtroPresentazioneProd ?></td>     
                            
                            <td class="cella1"><a target="_blank" href="/CloudFab/bs/schede/presentazione/download/<?php echo $PresentazioneProd ?>"><?php echo $PresentazioneProd ?></a></td>
                                <input type="hidden" name="LinkPresentazioneProd"  value="<?php echo $PresentazioneProd ?>"/>
                        </tr> 
                        <?php } ?>
                        
                        
                        <tr>
                            <td class="cella2"><?php echo $filtroCaricaPresProd ?></td>
                            <td class="cella1"><input type="file" name="user_file" value=""/>
                            </td>
                        </tr>
                        <input type="hidden" name="ToDo"  value="<?php echo $ToDo ?>"/>
                        <tr>
                            <td class="cella2" style="text-align: right; " colspan="2">
                                <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                <input type="submit" value="<?php echo $valueButtonSalva ?>"/></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div id="msgLog">
<?php
if ($DEBUG) {
    echo "</br>Tabella bs_prodotto: utenti e aziende visibili " . $strUtentiAziende;
}
?>
            </div>
        </div><!--mainContainer-->

    </body>
</html>

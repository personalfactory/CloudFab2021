<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <?php
        include('../Connessioni/serverdb.php');
        include('../sql/script_colore.php');
        include('../sql/script_mazzetta.php');
        include('../sql/script_colore_base.php');
        include('../sql/script.php');
	 
        
        if($DEBUG) ini_set("display_errors", "1");
        
        //############# STRINGHE AZIENDE VISIBILI  #################################
        //Stringa contenente l'elenco degli id delle aziende visibili dall'utente loggato
        $strUtentiAziendeCol=getStrUtAzVisib($_SESSION['objPermessiVis'], 'colore');
        //############# STRINGA UTENTI - AZIENDE VIS ###############################
        $strUtentiAziendeColB = getStrUtAzVisib($_SESSION['objPermessiVis'], 'colore_base');
        $strUtentiAziendeCol = getStrUtAzVisib($_SESSION['objPermessiVis'], 'colore');
        $strUtentiAziendeMaz = getStrUtAzVisib($_SESSION['objPermessiVis'], 'mazzetta');
        
        //##########################################################################   
        begin();
        $sqlCol = findAllColoreVis($strUtentiAziendeCol, "nome_colore");
        $sqlMaz = findAllMazzettaVisDiverseDa("Non definita",$strUtentiAziendeMaz,"nome_mazzetta");
        $sqlColoreBase =findAllColoreBaseVis($strUtentiAziendeColB,"nome_colore_base");
        commit();
        ?>
        <div id="mainContainer">
            <?php include('../include/menu.php'); ?>
            <div id="container" style=" width:700px; margin:15px auto;">

                <form class="form" id="AssociaMazzetta" name="AssociaMazzetta" method="post" action="associa_mazzetta_colore2.php">
                    <table width="100%">
                        <tr>
                            <td class="cella3" colspan="3"><?php echo $titoloAssociaColoreMazzetta ?></td>
                        </tr>

                        <?php if (isset($_GET['IdMazzetta']) && $_GET['IdMazzetta'] != "" && isset($_GET['NomeMazzetta']) && $_GET['NomeMazzetta'] != "") {
                            ?>
                            <tr>
                                <td class="cella2"><?php echo $filtroMazzetta ?> </td>
                                <td class="cella1" colspan="2"><?php echo $_GET['NomeMazzetta'] ?></td>
                                <input type="hidden" name="IdMazzetta" id="IdMazzetta" value="<?php echo $_GET['IdMazzetta'] ?>"/>
                                <input type="hidden" name="NomeMazzetta" id="NomeMazzetta" value="<?php echo $_GET['NomeMazzetta'] ?>"/>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroColore ?></td>
                                <td class="cella1" colspan="2">
                                    <select name="Colore" id="Colore">
                                        <option value="" selected=""><?php echo $labelSelezionaColore ?></option>
                                        <?php
                                         while ($row = mysql_fetch_array($sqlCol)) {
                                            ?>
                                            <option value="<?php echo($row['id_colore']) ?>"><?php echo($row['nome_colore']) ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                        <?php } else { ?>
                            <tr>
                                <td class="cella2"><?php echo $filtroColore ?> </td>
                                <td class="cella1" colspan="2">
                                    <select name="Colore" id="Colore">
                                        <option value="" selected=""><?php echo $labelSelezionaColore ?></option>
                                        <?php
                                       while ($row = mysql_fetch_array($sqlCol)) {
                                            ?>
                                            <option value="<?php echo($row['id_colore']) ?>"><?php echo($row['nome_colore']) ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroMazzetta ?> </td>
                                <td class="cella1" colspan="2">
                                    <select name="IdMazzetta" id="IdMazzetta">
                                        <option value="" selected=""><?php echo $labelSelezionaMazzetta ?></option>
                                <?php
                                    while ($row = mysql_fetch_array($sqlMaz)) {
                                        ?>
                                            <option value="<?php echo($row['id_mazzetta']) ?>"><?php echo($row['cod_mazzetta']) ?></option>
                                        <?php } ?>
                                    </select>
                                </td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <tr>
                                <td class="cella3" colspan="3"><?php echo $labelComposizioneColore ?></td>
                            </tr>
                            <tr>
                                <td class="cella2" ><?php echo $filtroColoriBase ?></td>
                                <td class="cella2" ><?php echo $filtroCostoUnitario ?></td>
                                <td class="cella2" ><?php echo $filtroQuantita ?></td>
                            </tr>
                            <?php
                            //Visualizzo l'elenco dei colori presenti nella tabella colore_base
                            $NComp = 1;
                            while ($rowColoreBase = mysql_fetch_array($sqlColoreBase)) {
                                ?>
                                <tr>
                                    <td class="cella1"><?php echo($rowColoreBase['nome_colore_base']) ?></td>
                                    <td class="cella1"><?php echo($rowColoreBase['costo_colore_base']) ?>&nbsp;&euro;</td>
                                    <td class="cella1"><input type="text" name="Qta<?php echo($NComp); ?>" id="Qta<?php echo($NComp); ?>" value="0"/>&nbsp; g</td>

                                </tr>
                                <?php
                                $NComp++;
                            }
                            ?>
                        </tr>
                        <tr>
                            <td class="cella2" style="text-align: right " colspan="4">
                                <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                <input type="submit" value="<?php echo $valueButtonSalva ?>" />
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
 <div id="msgLog">
                <?php
                if ($DEBUG) {
                    echo "</br>Tabella colore : Utenti aziende  visibili: ".$strUtentiAziendeCol;
                    echo "</br>Tabella colore_base : Utenti visibili Aziende : " . $strUtentiAziendeColB ;
                    echo "</br>Tabella mazzetta : Utenti aziende visibili : " . $strUtentiAziendeMaz;
                    
                    
                }
                ?>
            </div>
        </div><!--mainContainer-->

    </body>
</html>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script.php');
            include('../sql/script_miscela.php');
            include('../sql/script_sacchetto_chimica.php');
            include('../sql/script_gaz_movmag.php');
            include('../sql/script_generazione_formula.php');

            $IdMiscela = $_GET['Miscela'];

//##################### QUERIES AL DB ######################
            begin();
            $sqlMiscela = findMiscelaById($IdMiscela);
            $sqlMov = findMatPrimeMiscela($IdMiscela);
            $sqlDdt = findBolleByMiscela($IdMiscela);
            $sqlLotti = findCodLottoByMiscela($IdMiscela);
            commit();

            while ($rowMiscela = mysql_fetch_array($sqlMiscela)) {

                $DataMiscela = $rowMiscela['dt_miscela'];
                $CodiceFormula = $rowMiscela['cod_formula'];
                $DescriFormula = $rowMiscela['descri_formula'];
                $Contenitore = $rowMiscela['cod_contenitore'];
                $PesoTot = $rowMiscela['peso_reale'];
                $NumLotti=$rowMiscela['num_lotti'];
                $NumKitPerLotto=$rowMiscela['num_sac_in_lotto'];
                $QtaKit=$rowMiscela['qta_sac'];
                $QtaLotto=$rowMiscela['qta_lotto'];
            }
            
            $NumKitTot=$NumLotti*$NumKitPerLotto;
            ?>

            <div id="container" style="width:1000px; margin:15px auto;">
                <table width="100%">
                    <th class="cella3" colspan="7"><?php echo $titoloPaginaDettaglioMiscela ?></th>
                    <tr>
                        <td class="cella2"><?php echo $filtroId ?></td>
                        <td class="cella1"><?php echo $IdMiscela; ?></td>
                    </tr>
                    <tr>
                        <td class="cella2"><?php echo $filtroDtMiscela ?></td>
                        <td class="cella1"><?php echo $DataMiscela; ?></td>
                    </tr>
                    <tr>
                        <td class="cella2"><?php echo $filtroProdotto ?></td>
                        <td class="cella1"><?php echo $CodiceFormula . " - " . $DescriFormula; ?></td>
                    </tr>
                    <tr>
                        <td class="cella2"><?php echo $filtroContenitore ?></td>
                        <td class="cella1"><?php echo $Contenitore; ?></td>
                    </tr>        
                    <tr>
                        <td class="cella2"><?php echo $filtroPesoTotale." ".$filtroMiscela ?></td>
                        <td class="cella1"><?php echo $PesoTot . " " . $filtrogBreve ?></td>
                    </tr>
                    <tr>
                        <td class="cella2"><?php echo $filtroPesoLotto ?></td>
                        <td class="cella1"><?php echo $QtaLotto . " " . $filtrogBreve ?></td>
                    </tr>
                     <tr>
                        <td class="cella2"><?php echo $filtroNumLotti ?></td>
                        <td class="cella1"><?php echo $NumLotti . " " . $filtroPz ?></td>
                    </tr>
                    
                     <tr>
                        <td class="cella2"><?php echo $filtroNumKitPerLotto ?></td>
                        <td class="cella1"><?php echo $NumKitPerLotto . " " . $filtroPz ?></td>
                    </tr>
                </table>
                <?php
                //##############################################################
                //#################### MOVIMENTI MAGAZZINO #####################
                //##############################################################

                if (mysql_num_rows($sqlMov) > 0) {
                    ?>
                    <table width="100%">   
                        <tr>
                            <td class="cella3" colspan="2" ><?php echo $filtroMateriaPrima ?></td>
                            <td class="cella3" ><?php echo $filtroMovimento ?></td>
                            <td class="cella3" ><?php echo $filtroQtaTeoKit?></td>                            
                            <td class="cella3" ><?php echo $filtroQtaRealeKit ?></td>
                            <td class="cella3" ><?php echo $filtroQtaPerMiscela. " ".$filtroReale ?></td>
                        </tr>
                        <?php
                        $pesoTotCalcolato = 0;
                        $qtaMatPerKit=0;
                        $pesoTotKitTeo=0;
                        $pesoTotKitReale=0;
                        $PesoRealeMis=0;
                        while ($rowMov = mysql_fetch_array($sqlMov)) {
                            $CodiceMovimento = $rowMov['cod_mov'];
                            list($MateriaPrima, $Movimento, $Data) = explode('.', $CodiceMovimento);

                            //Verifico se il movimento è di tipo 'PRO-MIX' in questo caso corrisponde ad una miscela
                            $sqlTipoMov = findMovimentoById($Movimento);
                            while ($rowTip = mysql_fetch_array($sqlTipoMov)) {

                                $tipDoc = $rowTip['tip_doc'];
                                $numDoc = $rowTip['num_doc']; //Corrisponde all'id della miscela
                            }



                            $Data = substr($Data, 6) . "-" . substr($Data, 4, -2) . "-" . substr($Data, 0, -4);
                            $PesoRealeMis = $rowMov['peso_reale_mat'];
                            
                            if($NumKitTot>0){
                            $qtaMatPerKit=$PesoRealeMis/$NumKitTot;
                            $pesoTotKitTeo=$pesoTotKitTeo+$qtaMatPerKit;
                             $qtaMatPerKit= number_format($qtaMatPerKit, 0, ',', '');
                            }
                            
                            $CodMat = $rowMov['cod_mat'];
                            //Trovo il peso teorico del kit
                            $sqlTeo=findMatPrimaByFormulaAndCod($CodiceFormula,$CodMat);
                            while($row = mysql_fetch_array($sqlTeo)){
                                
                                $qtaKitTeo=$row['qta_kit'];
//                                $qtaMisTeo=$row['quantita'];
                                $pesoTotKitReale=$pesoTotKitReale+$qtaKitTeo;
                                
                            }
                            
                            $DescriMat = $rowMov['descri_mat'];
                            $pesoTotCalcolato = $pesoTotCalcolato + $PesoRealeMis;
                                                       
                            $PesoRealeMis=  number_format($PesoRealeMis, 0, ',', '');
                           
                            ?>			

                            <tr> <td class="cella2" >
                                <?php
        if ($tipDoc == $valTipDocProMix) {
            ?>
                                        <a href="dettaglio_miscela.php?Miscela=<?php echo($numDoc) ?>">
                                            <img src="/CloudFab/images/icone/lente_piccola.png"  alt="<?php echo $titleDettaglio ?>" title="<?php echo $titleDettaglio ?>"/></a>
        <?php } ?>
                               <a href="modifica_materia_prima.php?Codice=<?php echo $CodMat ?>"><?php echo $CodMat ?></a></td>
                                <td class="cella2" ><?php echo $DescriMat ?></td>
                                <td class="cella2" style="text-align: right"><a href="modifica_gaz_movmag.php?IdMov=<?php echo $Movimento ?>"><?php echo $Movimento ?></a></td>
                                <td class="cella2" style="text-align: right"><?php echo $qtaKitTeo . " " . $filtrogBreve ?></td>
                                <td class="cella2" style="text-align: right"><?php echo $qtaMatPerKit . " " . $filtrogBreve ?></td>
                                <td class="cella2" style="text-align: right"><?php echo $PesoRealeMis . " " . $filtrogBreve ?></td>
         </tr>
    <?php }//while mov
} 

$pesoTotCalcolato=number_format($pesoTotCalcolato, 0, ',', '');
$pesoTotKitTeo=number_format($pesoTotKitTeo, 0, ',', '');
?>
                        <tr>
                            <td class="cella2" colspan="3"> <?php echo $filtroTotali ?></td>
                            <td class="cella2" style="text-align: right"><?php echo $pesoTotKitReale . " " . $filtrogBreve ?></td>
                            <td class="cella2" style="text-align: right"><?php echo $pesoTotKitTeo . " " . $filtrogBreve ?></td>
                            <td class="cella2" style="text-align: right"><?php echo $pesoTotCalcolato . " " . $filtrogBreve ?></td>
                        </tr>
                </table>


<?php
//##############################################################
//#################### LOTTI DI CHIMICA  #######################
//##############################################################
if (mysql_num_rows($sqlLotti) > 0) {
    ?>
                    <table width="100%"> 
                        <tr>
                            <td class="cella3" ><?php echo $filtroCodLotto ?></td>
                            <td class="cella3" colspan="2"><?php echo $filtroDtProd ?></td>
                        </tr>
    <?php while ($rowLot = mysql_fetch_array($sqlLotti)) { ?>
                            <tr>
                                <td class="cella1center" ><?php echo($rowLot['cod_lotto']) ?></td>
                                <td class="cella1center" ><?php echo $rowLot['dt_abilitato'] ?></td>
                                <td class="cella1center"> <a href="dettaglio_lotto.php?Lotto=<?php echo($rowLot['cod_lotto']) ?>">
                                        <img src="/CloudFab/images/pittogrammi/lente-G.png" class="icone" title="<?php echo $titleViewDetails ?>"/>            
                                        </tr>          
        <?php
    }
}
?>
                                </table>

                                <?php
                                //##############################################################
                                //#################### DOC DI TRASPORTO  #######################
                                //##############################################################
                                if (mysql_num_rows($sqlDdt) > 0) {
                                    ?>
                                    <table width="100%"> 
                                        <tr>
                                            <td class="cella3" ><?php echo $filtroStabilimento ?></td>
                                            <td class="cella3" ><?php echo $filtroDdt ?></td>
                                            <td class="cella3" colspan="2"><?php echo $filtroDtDdt ?></td>
                                        </tr>
    <?php while ($rowKit = mysql_fetch_array($sqlDdt)) { ?>
                                            <tr>
                                                <td class="cella1center" ><?php echo($rowKit['descri_stab']) ?></td>
                                                <td class="cella1center" ><?php echo($rowKit['num_bolla']) ?></td>
                                                <td class="cella1center" ><?php echo $rowKit['dt_bolla'] ?></td>
                                                <td class="cella1center"> <a href="dettaglio_bolla.php?NumBolla=<?php echo($rowKit['num_bolla']) ?>&DtBolla=<?php echo($rowKit['dt_bolla']) ?>">
                                                        <img src="/CloudFab/images/pittogrammi/lente-G.png" class="icone" title="<?php echo $titleViewDetails ?>"/>            
                                                        </tr>          
        <?php
    }
}
?>
                                                </table>

                                                <table width="100%"> 
                                                    <tr>
                                                        <td class="cella2" ><input type="reset" onClick="javascript:history.back();" value="<?php echo $valueButtonIndietro ?>"/></td>
                                                    </tr>
                                                </table>

                                                </div><!--mainContainer-->
                                                </div>
                                                </body>
                                                </html>

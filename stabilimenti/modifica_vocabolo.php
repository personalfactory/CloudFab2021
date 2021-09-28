<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>    
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
       
    </head>
    <script type="text/javascript" src="../js/visualizza_elementi.js"></script>
    <body>
        <div id="mainContainer">

            <script language="javascript">
                function Salva(){
                    document.forms["ModificaVocabolo"].action = "modifica_vocabolo2.php";
                    document.forms["ModificaVocabolo"].submit();
                }
            </script>

            <?php
            $IdDizionario = $_GET['IdDizionario'];                           

//Seleziono le informazioni del record selezionato
            include('../Connessioni/serverdb.php');
            include('../sql/script_dizionario.php');
            
            $sqlDiz = selectDizionarioByIdDiz($IdDizionario);
            
            while ($row = mysql_fetch_array($sqlDiz)) {
                $IdLingua = $row['id_lingua'];
                $IdVocabolo = $row['id_vocabolo'];
                $Lingua = $row['lingua'];
                $IdDizTipo = $row['id_diz_tipo'];
                $DizionarioTipo = $row['dizionario_tipo'];
                $Vocabolo = $row['vocabolo'];
                $Data = $row['dt_abilitato'];
            }
            ?>

            <div id="container" style=" width:600px;">
                <form id="ModificaVocabolo" name="ModificaVocabolo" method="post" >
                    <table  width="600px">
                        <tr>
                            <td  colspan="2" class="cella3"> <?php echo $filtroModVocabolo. $IdVocabolo; ?></td>
                        </tr>
                        <input type="hidden" name="IdDizionario" id="IdDizionario" value="<?php echo $IdDizionario; ?>" />
                        <tr>
                            <td class="cella2"><?php echo $Lingua ?></td>
                            <td class="cella1">
                                <textarea  name="Vocabolo" id="Vocabolo" ROWS="4" COLS="30" value=<?php echo $Vocabolo; ?>><?php echo $Vocabolo; ?></textarea>
                            </td>
                        </tr>

                        <?php
                        //Visualizzo l'elenco delle lingue presenti nella tabella dizionario per il vocabolo selezionato
                        $NLin = 1;
                        $sqlLingua = selectLingueFromDizionario($IdLingua,$IdVocabolo,$IdDizTipo);
                        while ($rowLingua = mysql_fetch_array($sqlLingua)) {
                            $Traduzione = $rowLingua['vocabolo'];
                            ?>
                            <tr>
                                <td class="cella4"><?php echo($rowLingua['lingua']) ?></td>
                                <td class="cella1">
                                    <textarea  name="Traduzione<?php echo($NLin); ?>" id="Traduzione<?php echo($NLin); ?>" ROWS="4" COLS="30" value="<?php echo($Traduzione); ?>"><?php echo $Traduzione; ?></textarea>
                                </td>
                            </tr>
                            <?php
                            $NLin++;
                        }//Fine lingue
                        ?>

                        <tr>
                            <td class="cella2" style="text-align: right " colspan="2">
                                <input type="button" value="<?php echo $valueButtonChiudi ?>" onClick="window.opener.location.reload();window.close();" />
                                <input type="button" onClick="javascript:Salva();" value="<?php echo $valueButtonSalva ?>"/></td>
                        </tr>


                    </table>

                </form>  
            </div>

        </div><!--mainContainer-->

    </body>
</html>

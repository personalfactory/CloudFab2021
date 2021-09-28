<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        

        <div id="mainContainer">

            <?php include('../include/menu.php'); ?>
            <?php include('../Connessioni/serverdb.php');
            	  include('../sql/script_parametro_sacchetto.php');
            	  include('../sql/script_categoria.php');
            	  include('../sql/script_num_sacchetto.php');
            	   ?>

            <script language="javascript">
                function Carica(){
                    document.forms["AssociaParametro"].action = "associa_parametro_sac_categorie2.php";
                    document.forms["AssociaParametro"].submit();
                }
                function Aggiorna(){
                    document.forms["AssociaParametro"].action = "associa_parametro_sac_categorie.php";
                    document.forms["AssociaParametro"].submit();
                }
            </script>

            <?php
//Se il parametro prodotto non � stato settato o � vuoto allora viene visualizzata la form di inserimento vuota
            if (!isset($_POST['Parametro']) || trim($_POST['Parametro']) == "") {
                ?>

                <div id="container" style=" width:700px; margin:15px auto;">

                    <form class="form" id="AssociaParametro" name="AssociaParametro" method="post" >
                        <table width="100%">
                            <tr>
                                <td class="cella3" colspan="2"><?php echo $msgAssociaParACategorie?></td>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroPar ?></td>
                                <td class="cella1">
                                    <select name="Parametro" id="Parametro" onchange="Aggiorna()">
                                        <option  value="" selected="" ><?php echo $labelOptionParDefault?></option>
                                        <?php
                                        /*
                                        $sqlPar = mysql_query("SELECT * FROM parametro_sacchetto  
                                                               ORDER BY descri_variabile")
                                                or die("Errore 112: " . mysql_error());
										*/
										$sqlPar = findAllParSacchettoOrderByDescri();

                                        while ($rowPar = mysql_fetch_array($sqlPar)) {
                                            ?>
                                            <option 
                                                value="<?php echo($rowPar['id_par_sac']) . ";" . ($rowPar['nome_variabile']) . ";" . ($rowPar['valore_base']); ?>"><?php echo($rowPar['nome_variabile']); ?></option>
                                            <?php } ?>
                                    </select>
                            </tr>
                            <tr>
                                <td class="cella2" style="text-align: right " colspan="2">
                                    <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                </td>
                            </tr>  
                        </table> 
                    </form>
                    </td>
                </div>
                <?php
            } else {
                
                ///////////////////AGGIORNAMENTO/////////////////////////////////////////////////////////// 
                list($IdParametro, $NomeParametro, $ValoreBase) = explode(';', $_POST['Parametro']);
                ?>
                <div id="container" style=" width:700px; margin:15px auto;">  
                    <form class="form" id="AssociaParametro" name="AssociaParametro" method="post" >
                        <table width="100%">
                            <tr>
                                <td class="cella3" colspan="2"><?php echo $msgAssociaParACategorie?></td>
                            </tr>
                            <tr>
                                <td class="cella2"width="213"><?php echo $filtroPar ?> </td>
                                <td width="100" class="cella1">
                                    <select name="Parametro" id="Parametro"  onchange="Aggiorna()" >
                                        <option   value="<?php echo $_POST['Parametro']; ?>" selected=""><?php echo $NomeParametro; ?></option>
                                        <?php
                                       
					$sqlPar = findAllParSacchettoOrderByNome();
										
                                        while ($rowPar = mysql_fetch_array($sqlPar)) {
                                            ?>
                                            <option value="<?php echo($rowPar['id_par_sac']) . ";" . ($rowPar['nome_variabile']) . ";" . ($rowPar['valore_base']); ?>"><?php echo($rowPar['nome_variabile']); ?></option>
                                        <?php } ?>
                                    </select>
                            </tr>
                            <tr>
                                <td class="cella2"><?php echo $filtroValoreBase ?></td>
                                <td class="cella1"><?php echo $ValoreBase; ?></td>
                            </tr>

                            <tr>
                                <td class="cella3"><?php echo $filtroCategoria ?> </td>
                                <td class="cella3"><?php echo $filtroNumSacchi ?></td>
                            </tr> 

                            <?php
                            //Visualizzo l'elenco delle categorie presenti nella tabella categoria 

                            $NCat = 1;
                            /*
                            $sqlCategoria = mysql_query("SELECT *
                                                            FROM categoria 
                                                            ORDER BY nome_categoria")
                                    or die("Errore 113: " . mysql_error());
							*/
			$sqlCategoria = findAllCategoriaOrderByNome();
                            while ($rowCategoria = mysql_fetch_array($sqlCategoria)) {
                                ?>

                                <tr>
                                    <td  class="cella2"><?php echo($rowCategoria['nome_categoria']) ?></td>

                                    <?php
                                    $NSac = 1;
                                    /*
                                    $sqlSac = mysql_query("SELECT num_sacchetti	
                                                                FROM 
                                                                        num_sacchetto 
                                                                WHERE  	
                                                                        id_cat='" . $rowCategoria['id_cat'] . "'
                                                                ORDER BY num_sacchetti")
                                            or die("Errore 113: " . mysql_error());
									*/
									$sqlSac = findNumSaccByIdCat($rowCategoria['id_cat']);
									
                                    ?>
                                    <td>
                                        <table width="100%">
                                            <?php while ($rowSac = mysql_fetch_array($sqlSac)) { ?>
                                                <tr>
                                                    <td  class="cella1" width="150"><?php echo($rowSac['num_sacchetti']) ?></td>
                                                    <?php
                                                    $NSac++;
                                                }//fine while sacchetti
                                                ?> 
                                            </tr>
                                        </table> 

                                        <?php
                                        $NCat++;
                                    }
                                    ?>
                            </tr>
                            <tr>
                                <td class="cella2" style="text-align: right " colspan="2">
                                    <input type="reset" value="<?php echo $valueButtonAnnulla?>" onClick="javascript:history.back();"/>
                                    <input type="button" value="<?php echo $valueButtonSalva ?>" onclick="javascript:Carica();" />
                                </td>
                            </tr>  
                        </table> 
                    </form>
                </div>
                 
                <?php
            }//end aggiornamento
            ?> 

        </div><!--mainContainer-->

    </body>
</html>

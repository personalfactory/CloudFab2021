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

$IdParametro=$_GET['IdParametro'];

//Visualizzo all'interno della form il record selezionato che intendo modificare 
//Estraggo i dati dalla tabella valore_par_prod
include('../Connessioni/serverdb.php');
include('../sql/script_valore_par_prod.php');
/*
$sqlValore= mysql_query("SELECT
                            valore_par_prod.id_par_prod,
                            parametro_prodotto.nome_variabile,
                            parametro_prodotto.descri_variabile,
                            parametro_prodotto.valore_base,
                            categoria.id_cat,
                            categoria.nome_categoria,
                            valore_par_prod.valore_variabile,
                            valore_par_prod.dt_abilitato,
                            parametro_prodotto.dt_abilitato AS data
                        FROM
                            serverdb.valore_par_prod
                        INNER JOIN 
                            serverdb.parametro_prodotto 
                        ON 
                            valore_par_prod.id_par_prod = parametro_prodotto.id_par_prod
                        INNER JOIN 
                            serverdb.categoria 
                        ON 
                            valore_par_prod.id_cat = categoria.id_cat
                        WHERE 
                            valore_par_prod.id_par_prod=".$IdParametro) 					
			or die("ERRORE 1 SELECT FROM serverdb.valore_par_prod: " . mysql_error());
*/
$sqlValore = selectValoreParByIdPar($IdParametro);
			
	while($rowValore=mysql_fetch_array($sqlValore))
	{
		$IdParametro=$rowValore['id_par_prod'];
		$NomeParametro=$rowValore['nome_variabile'];
                $DescriVariabile=$rowValore['descri_variabile'];
                $IdCategoria=$rowValore['id_cat'];
		$NomeCategoria=$rowValore['nome_categoria'];
		$ValoreBase=$rowValore['valore_base'];
		$ValoreVariabile=$rowValore['valore_variabile'];
		$Data=$rowValore['data'];
	}	
?>

<div id="container" style=" width:800px; margin:15px auto;">
	<form class="form" id="AssociaParametroCat" name="AssociaParametroCat" method="post" action="modifica_valore_par_prod2.php">
    <table width="100%">
        <tr>
          <td class="cella3" colspan="2"><?php echo $titoloPaginaModParProdotto ?></td>
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroId;?> </td>
            <td class="cella1"><?php echo $IdParametro;?></td>
            <input type="hidden" name="IdParametro" id="IdParametro" value=<?php echo $IdParametro;?>></input>
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroPar;?></td>
            <td class="cella1"><?php echo $NomeParametro;?></td>
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroDescrizione;?></td>
            <td class="cella1"><?php echo $DescriVariabile;?></td>
        </tr>
        <tr>
            <td class="cella2"><?php echo $filtroValoreBase;?></td>
            <td class="cella1"><?php echo $ValoreBase;?></td>
        </tr>
        <tr>
             <td class="cella2"><?php echo $filtroDt;?></td>
             <td class="cella1"><?php echo $Data;?></td>
        </tr>
    </table>
    <table width="100%">
        <tr>
          <td class="cella3" ><?php echo $filtroId;?></td>
          <td class="cella3" ><?php echo $filtroCategoria;?></td>
          <td class="cella3" ><?php echo $filtroValore;?></td>
          <td class="cella3" ><?php echo $filtroDtAbilitato;?></td>
        </tr>
        <tr>
	<?php 
        //Visualizzo l'elenco delle Categorie presenti nella tabella [valore_par_prod] associate al parametro selezionato
        $NCat = 1;
        /*
        $sqlCategoria = mysql_query("SELECT 
            	    	                    categoria.id_cat,
                                            categoria.nome_categoria,
                                            categoria.descri_categoria,
                                            valore_par_prod.valore_variabile,
                                            valore_par_prod.dt_abilitato 
                                       FROM
                                            serverdb.valore_par_prod
                                       INNER JOIN 
                                            serverdb.categoria 
                                          ON 
                                            valore_par_prod.id_cat = categoria.id_cat
                                       INNER JOIN 
                                            serverdb.parametro_prodotto 
                                          ON 
                                            valore_par_prod.id_par_prod = parametro_prodotto.id_par_prod
                                       WHERE 
                                            valore_par_prod.id_par_prod=".$IdParametro."
                                       ORDER BY 
                                            nome_categoria")
                         or die("Errore 81 : " . mysql_error());
		*/
		$sqlCategoria = selectCategoriaValoreByIdPar($IdParametro);
        
        while($rowCategoria=mysql_fetch_array($sqlCategoria)){
        ?>
            <tr>
                <td class="cella4"><?php echo($rowCategoria['id_cat'])?></td>
                <td class="cella4" title="<?php echo($rowCategoria['descri_categoria'])?>"><?php echo($rowCategoria['nome_categoria'])?></td>
                <td class="cella1"><input type="text" name="Valore<?php echo($NCat);?>" id="Valore<?php echo($NCat);?>" value="<?php echo($rowCategoria['valore_variabile']);?>"/></td>
                <td class="cella4"><?php echo($rowCategoria['dt_abilitato'])?></td>
            </tr>
                        
            <?php 
            $NCat++;
	}?>
    	</tr>
    	<tr>
  <td class="cella2" style="text-align: right " colspan="4">
    <input type="reset" value="<?php echo $valueButtonAnnulla;?>" onClick="javascript:history.back();"/>
    <input type="submit" value="<?php echo $valueButtonSalva;?>" /></td>
</tr>
    </table>
    </form>
 </div>
 
</div><!--mainContainer-->
 
 
</body>
</html>

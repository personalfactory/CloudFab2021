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
    include('../include/gestione_date.php'); 
    include('../Connessioni/serverdb.php');
    include('../sql/script_valore_ripristino.php');
    
            //######################## RICERCA #################################
            //Inizializzo la variabile che viene utilizzata per memorizzare
            //la parola da cercare nel db
            $_SESSION['key']="";
            //##################################################################
                       
            
            //##################### ORDINAMENTO ################################
            //Variabile usata per memorizzare il nome del campo 
            //in base al quale viene ordinata la select
            $FiltroOrdinamento="id_valore_ripristino";
            
            if(isSet($_GET['NomeCampo']) && $_GET['NomeCampo']!="" ){
                
                $FiltroOrdinamento = $_GET['NomeCampo'];
            }    
            //##################################################################
/*    
    $sql = mysql_query("SELECT
                            valore_ripristino.id_valore_ripristino,
                            parametro_ripristino.id_par_ripristino,
                            parametro_ripristino.nome_variabile,
                            parametro_ripristino.descri_variabile,
                            macchina.cod_stab,
                            macchina.id_macchina,
                            macchina.descri_stab,
                            valore_ripristino.id_pro_corso,
                            valore_ripristino.valore_variabile,
                            valore_ripristino.dt_registrato,
                            valore_ripristino.abilitato,
                            valore_ripristino.dt_abilitato,
                            valore_ripristino.dt_agg_mac
                        FROM
                            serverdb.valore_ripristino
                        LEFT JOIN serverdb.macchina 
                        ON 
                            valore_ripristino.id_macchina = macchina.id_macchina
                        LEFT JOIN serverdb.parametro_ripristino 
                        ON 
                            valore_ripristino.id_par_ripristino = parametro_ripristino.id_par_ripristino
                        ORDER BY 
                            ".$FiltroOrdinamento)
            or die("ERRORE SELECT VALORE RIPRISTINO : " . mysql_error());
 */           
     $sql = selectValoreRipristinoOrderByFiltro($FiltroOrdinamento);
    
    include('./moduli/visualizza_valori_ripristino.php'); ?> 

</div>
</body>
</html>

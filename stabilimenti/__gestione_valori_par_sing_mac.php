<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
<!--    <body link="#FFFFFF" vlink="#FFFFFF" alink="#FFFFFF">-->
<body>
        

        <div id="mainContainer">

            <?php
            include('../include/menu.php');
            include('../include/gestione_date.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script_valore_par_sing_mac.php');
            
            //######################## RICERCA #################################
            //Inizializzo la variabile che viene utilizzata per memorizzare
            //la parola da cercare nel db
            $_SESSION['key']="";
            //##################################################################
                       
            
            //##################### ORDINAMENTO ################################
            //Variabile usata per memorizzare il nome del campo 
            //in base al quale viene ordinata la select
            $FiltroOrdinamento="id_val_par_sm";
            
            if(isSet($_GET['NomeCampo']) && $_GET['NomeCampo']!="" ){
                
                $FiltroOrdinamento = $_GET['NomeCampo'];
            }    
            //##################################################################
 /*               
            $sql = mysql_query("SELECT
                                valore_par_sing_mac.id_val_par_sm,
                                valore_par_sing_mac.id_par_sm,
                                parametro_sing_mac.nome_variabile,
                                parametro_sing_mac.descri_variabile,
                                macchina.cod_stab,
                                macchina.descri_stab,
                                macchina.id_macchina,
                                valore_par_sing_mac.valore_variabile,
                                valore_par_sing_mac.dt_abilitato
                            FROM
                                valore_par_sing_mac
                            INNER JOIN macchina 
                            ON 
                                valore_par_sing_mac.id_macchina = macchina.id_macchina
                            INNER JOIN parametro_sing_mac 
                            ON 
                                valore_par_sing_mac.id_par_sm = parametro_sing_mac.id_par_sm
                            GROUP BY
                               macchina.id_macchina
                            ORDER BY 
                            ".$FiltroOrdinamento) 
            or die("ERRORE SELECT FROM valore_par_sing_mac: " . mysql_error());
   */         
            $sql = selectValoreParSMGroupByIdMacchinaOrderByFiltro($FiltroOrdinamento);
                                   
            include('./moduli/visualizza_valori_par_sing_mac.php');
            ?> 
            
        </div>
    </body>
</html>

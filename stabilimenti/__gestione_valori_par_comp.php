<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>       

        <div id="mainContainer" width="300px">

            <?php
            include('../include/menu.php');
            include('../Connessioni/serverdb.php');
            include('../sql/script_valore_par_comp.php');
            //######################## RICERCA #################################
            //Inizializzo la variabile che viene utilizzata per memorizzare
            //la parola da cercare nel db
            $_SESSION['key'] = "";
            //##################################################################
            //##################### ORDINAMENTO ################################
            //Variabile usata per memorizzare il nome del campo 
            //in base al quale viene ordinata la select
            $FiltroOrdinamento = "id_val_comp";

            if (isSet($_GET['NomeCampo']) && $_GET['NomeCampo'] != "") {

                $FiltroOrdinamento = $_GET['NomeCampo'];
            }
            //##################################################################
/*
            $sql = mysql_query("SELECT
                            valore_par_comp.id_val_comp,
                            parametro_comp_prod.id_par_comp,
                            parametro_comp_prod.nome_variabile,
                            parametro_comp_prod.descri_variabile,
                            macchina.cod_stab,
                            macchina.id_macchina,
                            macchina.descri_stab,
                            componente.descri_componente,
                            valore_par_comp.valore_variabile,
                            valore_par_comp.dt_abilitato                            
                        FROM
                            serverdb.valore_par_comp
                        INNER JOIN macchina 
                        ON 
                            valore_par_comp.id_macchina = macchina.id_macchina
                        INNER JOIN parametro_comp_prod 
                        ON 
                            valore_par_comp.id_par_comp = parametro_comp_prod.id_par_comp
                        INNER JOIN componente 
                        ON 
                            valore_par_comp.id_comp = componente.id_comp
                        GROUP BY
                            id_macchina                            
                        ORDER BY 
                            ".$FiltroOrdinamento)
                    or die("ERRORE SELECT valore_par_comp: " . mysql_error());
 */                   
             $sql = selectValoreParCompGropyByIdMaccOrderByFiltro($FiltroOrdinamento);

            include('./moduli/visualizza_valori_par_comp.php');
            ?> 

        </div>

    </body>
</html>
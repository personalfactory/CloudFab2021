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
            include('../Connessioni/serverdb.php');
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

//            select * from serverdb.valore_par_comp group by id_comp,id_macchina having count(*) >5;
            
             $sqlNumParComp = mysql_query("SELECT COUNT(*) AS num_par FROM parametro_comp_prod")
             or die("ERRORE SELECT COUNT(*) FROM parametro_comp_prod: " . mysql_error());
             
             while($rowNumPar=  mysql_fetch_array($sqlNumParComp)){
               $NumParComp=$rowNumPar['num_par'];
             }
             
            
            $sql = mysql_query("SELECT
                            valore_par_comp.id_val_comp,
                            parametro_comp_prod.id_par_comp,
                            parametro_comp_prod.nome_variabile,
                            parametro_comp_prod.descri_variabile,
                            macchina.cod_stab,
                            macchina.id_macchina,
                            componente.descri_componente,
                            valore_par_comp.valore_variabile,
                            valore_par_comp.dt_abilitato                            
                        FROM
                            valore_par_comp
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
                          valore_par_comp.id_comp,
                          valore_par_comp.id_macchina
                        HAVING COUNT(*)>".$NumParComp."
                        ORDER BY 
                            ".$FiltroOrdinamento)
                    or die("ERRORE SELECT valore_par_comp: " . mysql_error());

            include('./moduli/visualizza_valori_par_comp.php');
            ?> 

        </div>

    </body>
</html>
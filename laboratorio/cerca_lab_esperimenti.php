<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        
        <?php include('../include/menu.php'); ?>
        <div id="labContainer">
            <?php include('../Connessioni/serverdb.php'); ?>

            <table>
                <?php
                if ($_POST['key'] == "") {
                    echo 'Nessun risultato! <a href="gestione_lab_esperimenti.php">Torna agli esperimenti</a>';
                }
                if (isset($_POST['key']) && ($_POST['key'] != "")/* &&(preg_match("/^[a-z0-9]+$/i", $_POST['key'])) */) {
                    $key = trim($_POST['key']);
                    
                 //Se l'utente che effettua la ricerca appartiene al gruppo Amministrazione ha accesso a tutte le formule
            if($_SESSION['nome_gruppo_utente']=='Amministrazione'){   
                    $query = "SELECT
				lab_esperimento.id_esperimento,
				lab_esperimento.cod_lab_formula,
				lab_esperimento.num_prova,
				lab_esperimento.cod_barre,
				lab_esperimento.dt_prova,
				lab_esperimento.ora_prova,
				lab_formula.utente,
				lab_formula.gruppo_lavoro,
				lab_materie_prime.descri_materia
				
			FROM
				lab_esperimento
			INNER JOIN lab_formula ON lab_esperimento.cod_lab_formula = lab_formula.cod_lab_formula
			INNER JOIN lab_matpri_teoria ON lab_formula.cod_lab_formula = lab_matpri_teoria.cod_lab_formula
			INNER JOIN lab_materie_prime ON lab_materie_prime.id_mat = lab_matpri_teoria.id_mat
			

			WHERE 
					(lab_esperimento.cod_lab_formula 			LIKE '%" . $key . "%') 
				OR 	(lab_esperimento.num_prova				LIKE '%" . $key . "%')
				OR 	(lab_esperimento.cod_barre				LIKE '%" . $key . "%')
				OR 	(lab_materie_prime.descri_materia			LIKE '%" . $key . "%')
				OR 	(lab_formula.utente					LIKE '%" . $key . "%')
				OR 	(lab_formula.gruppo_lavoro				LIKE '%" . $key . "%')
				OR 	(lab_esperimento.dt_prova				LIKE '%" . $key . "%')
				
			GROUP BY 
					cod_lab_formula,num_prova		
			ORDER BY 
					cod_lab_formula,num_prova";
}else{
//Se l'utente che effettua la ricerca NON appartiene al gruppo Amministrazione 
//ha accesso a solo alle proprie formule	
     $query = "SELECT
				lab_esperimento.id_esperimento,
				lab_esperimento.cod_lab_formula,
				lab_esperimento.num_prova,
				lab_esperimento.cod_barre,
				lab_esperimento.dt_prova,
				lab_esperimento.ora_prova,
				lab_formula.utente,
				lab_formula.gruppo_lavoro,
				lab_materie_prime.descri_materia
				
			FROM
				lab_esperimento
			INNER JOIN lab_formula ON lab_esperimento.cod_lab_formula = lab_formula.cod_lab_formula
			INNER JOIN lab_matpri_teoria ON lab_formula.cod_lab_formula = lab_matpri_teoria.cod_lab_formula
			INNER JOIN lab_materie_prime ON lab_materie_prime.id_mat = lab_matpri_teoria.id_mat
			

			WHERE 
				(
                                (lab_esperimento.cod_lab_formula 			LIKE '%" . $key . "%') 
				OR 	(lab_esperimento.num_prova				LIKE '%" . $key . "%')
				OR 	(lab_esperimento.cod_barre				LIKE '%" . $key . "%')
				OR 	(lab_materie_prime.descri_materia			LIKE '%" . $key . "%')
				OR 	(lab_formula.utente					LIKE '%" . $key . "%')
				OR 	(lab_formula.gruppo_lavoro				LIKE '%" . $key . "%')
				OR 	(lab_esperimento.dt_prova				LIKE '%" . $key . "%')
				)
                         AND
				(utente='".$_SESSION['username']."' OR gruppo_lavoro='".$_SESSION['nome_gruppo_utente']."')
			GROUP BY 
					cod_lab_formula,num_prova		
			ORDER BY 
					cod_lab_formula,num_prova";
}
                    
                    
                    
                    $sql = mysql_query($query, $connessione) or die(mysql_error($connessione));
                    $trovati = mysql_num_rows($sql);
                    if ($trovati > 0) {
                        echo "Trovate $trovati voci per il termine <b> " . stripslashes($key) . " </b><br/> ";
                        ?>
                        <a href="gestione_lab_formula.php">Torna alle Prove di Laboratorio</a>
                        <?php include('moduli/visualizza_lab_esperimenti.php'); ?>
                    </table>


        <?php
    } else {
        // Notifica in caso di mancanza di risultati
        echo 'Nessun risultato! <a href="gestione_lab_esperimenti.php">Torna alle Prove</a>';
    }
}
?>

        </div>
    </body>
</html>

<?php
/**
 * Seleziona i risultati di una caratteristica di una data materia prima 
 * dalla tabella lab_matpri_car
 * @param type $idMat
 * @param type $idCar
 * @return type
 */
function findRisulatiCarMtByIdMatAndIdCar($idMat,$idCar){

    $sql = mysql_query("SELECT valore_caratteristica AS y, valore_dimensione AS x 
                        FROM 
                            serverdb.lab_matpri_car 
                        WHERE 
                            id_mat=" . $idMat . " AND id_carat=" . $idCar."
                        ORDER BY 
                            valore_dimensione ASC") 
            or die("ERROR IN script_lab_matpri_car - FUNCTION findRisulatiCarMtByIdMatAndIdCar - SELECT FROM lab_matpri_car : " . mysql_error());

return $sql;
}

/**
 * Associa una caratteristica ad una materia prima, 
 * inserendo un record nella tabella lab_matpri_car
 * @param type $idMateria
 * @param type $idCar
 * @param type $valoreCar
 * @param type $valDimensione
 * @return type
 */
function inserisciCaratteristica($idMateria,$idCar,$valoreCar,$valDimensione,$note){
    $sql=mysql_query("INSERT INTO serverdb.lab_matpri_car 
                            (id_mat,
                             id_carat,
                             valore_caratteristica,
                             valore_dimensione,
                             note) 
                            VALUES(    " . $idMateria . ",
                                       " . $idCar . ",
                                       '".$valoreCar."',
                                       ".$valDimensione.",
                                           '".$note."')")
                or die("ERROR IN script_lab_matpri_car - FUNCTION inserisciCaratteristica - INSERT INTO lab_matpri_car : " . mysql_error());
    return $sql;
}

/**
 * Seleziona le caratteristiche di una data materia prima
 * @param type $idMateria
 * @return type
 */
function findCaratteristicheByIdMat($idMateria){
    
    $sql=  mysql_query("SELECT
                        m.id,
                        m.id_carat,
                        c.caratteristica,
                        m.valore_caratteristica,
                        c.uni_mis_car,
                        c.uni_mis_dim,
                        c.dimensione,
                        m.valore_dimensione,
                        m.dt_registrazione,
                        m.note
                FROM serverdb.lab_matpri_car m 
                INNER JOIN 
                    serverdb.lab_caratteristica_mt c
                ON 
                    m.id_carat=c.id_carat                            
                WHERE 
                    m.id_mat=".$idMateria."
                ORDER BY 
                    c.caratteristica;")
   or die("ERROR IN script_lab_matpri_car - FUNCTION findCaratteristicaByIdMat - SELECT FROM  lab_matpri_car" . mysql_error());
   return $sql;
    
}
?>

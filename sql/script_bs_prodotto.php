<?php

function findBSProdotti($strUtentiAziende) {
    $stringSql = "SELECT * FROM
                         serverdb.bs_prodotto b JOIN serverdb.prodotto p
                            ON b.id_prodotto=p.id_prodotto
                        WHERE
                            (b.id_utente,b.id_azienda) IN " . $strUtentiAziende . "
                        ORDER BY 
                            rating";
    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_prodotto- findBSProdotti- " . $stringSql . " : " . mysql_error());

    return $sql;
}

function findBSProdottiUnion($strUtentiAziende) {
    $stringSql = "SELECT * FROM (SELECT p.id_prodotto AS id_prodotto,cod_prodotto,nome_prodotto,classificazione,0 AS costo, link_presentazione_prod,link_scheda_tecnica,
        features, corrispettivo_1,prezzo_1,note_1,corrispettivo_2,prezzo_2,note_2,corrispettivo_3,prezzo_3,note_3,b.dt_abilitato AS dt_abilitato,rating,b.tipo FROM
                         serverdb.bs_prodotto b JOIN serverdb.prodotto p
                            ON b.id_prodotto=p.id_prodotto
                        WHERE
                            (b.id_utente,b.id_azienda) IN " . $strUtentiAziende . "
                       
                  UNION ALL
                        SELECT id_prodotto,cod_prodotto,nome_prodotto,classificazione, costo,link_presentazione_prod,'' AS link_scheda_tecnica,features, 
                        corrispettivo_1,prezzo_1,note_1,corrispettivo_2,prezzo_2,note_2,corrispettivo_3,prezzo_3,note_3,p.dt_abilitato AS dt_abilitato,rating,p.tipo
                        FROM serverdb.bs_altri_prodotti p
                        WHERE (p.id_utente,p.id_azienda) IN " . $strUtentiAziende . " 
                        ) derivedTable ORDER BY rating";
    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_prodotto - findBSProdottiUnion - " . $stringSql . " : " . mysql_error());

    return $sql;
}

function findProdottiBsVisByFiltriUnion($campoGroupBy, $filtroOrdinamento, $codProdotto, $nomeProdotto, $classificazione, $listinoLotto, $numKit, $listinoKit, $rating, $strUtentiAziende) {
    $sqlString = "(SELECT p.id_prodotto AS id_prodotto,cod_prodotto,nome_prodotto,classificazione,num_sac_in_lotto,num_lotti,
        listino, rating, link_scheda_tecnica,link_presentazione_prod,b.tipo
        FROM serverdb.bs_prodotto b
                            JOIN serverdb.prodotto p ON b.id_prodotto=p.id_prodotto 
                            JOIN serverdb.lotto_artico a ON a.codice=CONCAT('L',p.cod_prodotto)
                            JOIN serverdb.formula f ON f.cod_formula=CONCAT('K',p.cod_prodotto) 
                        WHERE 
                            p.cod_prodotto LIKE '%" . $codProdotto . "%'
                        AND 
                            p.nome_prodotto LIKE '%" . $nomeProdotto . "%'
                        AND 
                            classificazione LIKE '%" . $classificazione . "%'
                        AND 
                            listino LIKE '%" . $listinoLotto . "%'
                        AND 
                            num_sac_in_lotto LIKE '%" . $numKit . "%'
                        AND 
                            ROUND(listino/num_sac_in_lotto,2) LIKE '%" . $listinoKit . "%'
                        AND 
                            rating LIKE '%" . $rating . "%'
                        AND
                            (b.id_utente,b.id_azienda) IN " . $strUtentiAziende . "
                                GROUP BY " . $campoGroupBy . "
                                 )
               UNION 
                        (SELECT id_prodotto,cod_prodotto,nome_prodotto,classificazione,'' AS num_sac_in_lotto,'' AS num_lotti, '' AS listino, rating,
                        '' AS link_scheda_tecnica, link_presentazione_prod,p.tipo FROM serverdb.bs_altri_prodotti p
                        WHERE (p.id_utente,p.id_azienda) IN " . $strUtentiAziende . " 
                        GROUP BY " . $campoGroupBy . "
                         )
                         ORDER BY " . $filtroOrdinamento;



    $sql = mysql_query($sqlString)
            or die("ERROR IN script_bs_prodotto.php - FUNCTION findProdottiBsVisByFiltriUnion - " . $sqlString . " " . mysql_error());
    return $sql;
}

function findProdottiBsVisByFiltri($campoGroupBy, $filtroOrdinamento, $codProdotto, $nomeProdotto, $classificazione, $listinoLotto, $numKit, $listinoKit, $rating, $strUtentiAziende) {
    $sqlString = "SELECT * FROM serverdb.bs_prodotto b
                            JOIN serverdb.prodotto p ON b.id_prodotto=p.id_prodotto 
                            JOIN serverdb.lotto_artico a ON a.codice=CONCAT('L',p.cod_prodotto)
                            JOIN serverdb.formula f ON f.cod_formula=CONCAT('K',p.cod_prodotto) 
                        WHERE 
                            p.cod_prodotto LIKE '%" . $codProdotto . "%'
                        AND 
                            p.nome_prodotto LIKE '%" . $nomeProdotto . "%'
                        AND 
                            classificazione LIKE '%" . $classificazione . "%'
                        AND 
                            listino LIKE '%" . $listinoLotto . "%'
                        AND 
                            num_sac_in_lotto LIKE '%" . $numKit . "%'
                        AND 
                            ROUND(listino/num_sac_in_lotto,2) LIKE '%" . $listinoKit . "%'
                        AND 
                            rating LIKE '%" . $rating . "%'
                        AND
                            (b.id_utente,b.id_azienda) IN " . $strUtentiAziende . "
                        GROUP BY " . $campoGroupBy . "                            
                        ORDER BY " . $filtroOrdinamento;

    $sql = mysql_query($sqlString)
            or die("ERROR IN script_bs_prodotto.php - FUNCTION findProdottiBsVisByFiltri - " . $sqlString . " " . mysql_error());
    return $sql;
}

function findProdottiBsNew($strUtentiAziende) {
    $stringSql = "SELECT * FROM 
                             serverdb.prodotto p                            
                        WHERE
                            id_prodotto NOT IN (SELECT id_prodotto FROM serverdb.bs_prodotto)
                        AND
                            (p.id_utente,p.id_azienda) IN " . $strUtentiAziende . "
                        ORDER BY 
                            cod_prodotto";
    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_prodotto.php - findProdottiBsNew - " . $stringSql . " : " . mysql_error());

    return $sql;
}

function insertNewProdottoBs($idProdotto, $classificazione, $rating, $linkPresentazioneProd, $linkSchedaTecnica, $features, $corrispettivo1, $prezzo1, $note1, $corrispettivo2, $prezzo2, $note2, $corrispettivo3, $prezzo3, $note3, $tipo, $idUtente, $idAzienda) {

    $stringSql = "INSERT INTO serverdb.bs_prodotto (id_prodotto,classificazione,rating,link_presentazione_prod,
            link_scheda_tecnica,features,corrispettivo_1,prezzo_1,note_1,corrispettivo_2,prezzo_2,note_2,
            corrispettivo_3,prezzo_3,note_3,tipo,id_utente,id_azienda)
                            VALUES
                            (" . $idProdotto . ",
                                '" . $classificazione . "',
                                    '" . $rating . "',
                                    '" . $linkPresentazioneProd . "',
                                        '" . $linkSchedaTecnica . "',
                                            '" . $features . "',
                                                '" . $corrispettivo1 . "',
                                                    " . $prezzo1 . ",
                                                        '" . $note1 . "',
                                                            '" . $corrispettivo2 . "',
                                                                " . $prezzo2 . ",
                                                                    '" . $note2 . "',
                                                                        '" . $corrispettivo3 . "',
                                                                            " . $prezzo3 . ",
                                                                                '" . $note3 . "',
                                                                                  '" . $tipo . "',
                                                                                    " . $idUtente . ",
                                                                                        " . $idAzienda . ")";
    $sql = mysql_query($stringSql) or die("ERROR IN " . $stringSql . " : " . mysql_error());

    return $sql;
}

function findBSProdottoById($idProdotto) {
    $stringSql = "SELECT * FROM 
                            serverdb.bs_prodotto b JOIN serverdb.prodotto p
                            ON b.id_prodotto=p.id_prodotto
                        WHERE
                            b.id_prodotto=" . $idProdotto;

    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_prodotto - findBSProdottoById - " . $stringSql . " : " . mysql_error());

    return $sql;
}

function updateBSProdottoById($idProdotto, $classificazione, $rating, $linkPresentazioneProd, $linkSchedaTecnica, $features, $corrispettivo1, $prezzo1, $note1, $corrispettivo2, $prezzo2, $note2, $corrispettivo3, $prezzo3, $note3, $idAzienda) {
    $stringSql = "UPDATE serverdb.bs_prodotto b SET classificazione='" . $classificazione . "',
                    rating='" . $rating . "',
                    link_presentazione_prod='" . $linkPresentazioneProd . "',
                    link_scheda_tecnica='" . $linkSchedaTecnica . "',
                    features='" . $features . "',
                    corrispettivo_1='" . $corrispettivo1 . "',
                    prezzo_1=" . $prezzo1 . ",
                    note_1='" . $note1 . "',
                    corrispettivo_2='" . $corrispettivo2 . "',
                    prezzo_2=" . $prezzo2 . ",
                    note_2='" . $note2 . "',
                    corrispettivo_3='" . $corrispettivo3 . "',
                    prezzo_3=" . $prezzo3 . ",
                    note_3='" . $note3 . "',
                    id_azienda='" . $idAzienda . "'    
              WHERE
                    b.id_prodotto=" . $idProdotto;

    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_prodotto - updateBSProdottoById " . $stringSql . " : " . mysql_error());

    return $sql;
}

function selectProdottiCatalogoMarie() {


    $stringSql = "SELECT 
p.id_prodotto AS id_product,
cod_prodotto AS product_code,
nome_prodotto AS product_name,
num_sac_in_lotto AS n_kit,
num_lotti AS n_box,
qta_sac AS weight_kit,
num_sac AS num_kit_tot,
listino/num_sac_in_lotto AS price_list
FROM
serverdb.bs_prodotto b 
JOIN serverdb.prodotto p
ON b.id_prodotto=p.id_prodotto
JOIN serverdb.formula f
JOIN serverdb.lotto_artico l
WHERE f.cod_formula=concat('K',p.cod_prodotto)
AND l.codice=concat('L',p.cod_prodotto)
ORDER BY rating";

    $sql = mysql_query($stringSql) or die("ERROR IN script_bs_prodotto - FUNCTION selectProdottiCatalogoMarie : " . $stringSql . " : " . mysql_error());

    return $sql;
}

?>

<?php

/**
 * Description of ChimicaGiacenza
 *
 * @author marilisa
 */
class ChimicaGiacenza {

    //Put your code here
    private $artico;          //  varchar 
    private $descri_artico;   // varchar 
    private $inventario;      // double 
    private $dt_inventario; // data
    private $giacenzaIni;   // data
    private $consumi;       // double 
    private $acquisti;      // double 
    private $giacenzaFin;   // double 
    private $prezzo;        // double 
    private $valorizzazione;  // double

    function __construct($artico, $descri_artico, $inventario, $dt_inventario, $giacenzaIni, $consumi, $acquisti, $giacenzaFin, $prezzo, $valorizzazione) {
        $this->artico = $artico;
        $this->descri_artico = $descri_artico;
        $this->inventario = $inventario;
        $this->dt_inventario = $dt_inventario;
        $this->giacenzaIni = $giacenzaIni;
        $this->consumi = $consumi;
        $this->acquisti = $acquisti;
        $this->giacenzaFin = $giacenzaFin;
        $this->prezzo = $prezzo;
        $this->valorizzazione = $valorizzazione;
    }

    function toString() {

        $output = "</br>objChimicaGiacenza [Codice:" . $this->artico .
                "; MateriaPrima:" . $this->descri_artico .
                "; Inventario:" . $this->inventario .
                "; Consumi:" . $this->consumi .
                "; Acquisti:" . $this->acquisti .
                "; Giacenza:" . $this->giacenza .
                "; Valorizzazione:" . $this->valorizzazione . "]</br>";

        return $output;
    }
    
    /**
     * Funzione che prende un result set di materie prime, calcola consumi e restituisce un array
     * @param type $sqlMat
     * @return \ChimicaGiacenza
     */
    function CalcolaConsumi($sqlMat) {
        $chimicaGiacenza=array();
        $i = 0;
        while ($row = mysql_fetch_array($sqlMat)) {

            $artico = $row['cod_mat'];
            $descri_artico = $row['descri_mat'];

            //Inventario
            $inventario = $row['inventario'];
            $dtInventario = $row['dt_inventario'];
            $prezzo = $row['pre_acq'];

            //Acquisti
            $sqlAcquisti = sommaMovimentiTotMat($artico, $dataInf, $dataSup, "2", "1");
            while ($rowA = mysql_fetch_array($sqlAcquisti)) {

                $acquisti = $rowA['somma_mov'];
            }

            //Consumi
            $sqlConsumi = sommaMovimentiTotMat($artico, $dataInf, $dataSup, "2", "-1");
            while ($rowC = mysql_fetch_array($sqlConsumi)) {

                $consumi = $rowC['somma_mov'];
            }
            $giacenza = 0;
            $valorizzazione = 0;

            $giacenza = $inventario + $acquisti - $consumi;
            $valorizzazione = $giacenza * $prezzo;


            $chimicaGiacenza[$i] = new ChimicaGiacenza($artico, $descri_artico, $inventario, $dtInventario, $consumi, $acquisti, $giacenza, $prezzo, $valorizzazione);

            $i++;
        }
        return $chimicaGiacenza;
    }

    function getDt_inventario() {
        return $this->dt_inventario;
    }

    function getPrezzo() {
        return $this->prezzo;
    }

    function setDt_inventario($dt_inventario) {
        $this->dt_inventario = $dt_inventario;
    }

    function setPrezzo($prezzo) {
        $this->prezzo = $prezzo;
    }

    function getConsumi() {
        return $this->consumi;
    }

    function getAcquisti() {
        return $this->acquisti;
    }

    function setConsumi($consumi) {
        $this->consumi = $consumi;
    }

    function setAcquisti($acquisti) {
        $this->acquisti = $acquisti;
    }

    function getArtico() {
        return $this->artico;
    }

    function getDescri_artico() {
        return $this->descri_artico;
    }

    function getInventario() {
        return $this->inventario;
    }

    

    function getValorizzazione() {
        return $this->valorizzazione;
    }

    function setArtico($artico) {
        $this->artico = $artico;
    }

    function setDescri_artico($descri_artico) {
        $this->descri_artico = $descri_artico;
    }

    function setInventario($inventario) {
        $this->inventario = $inventario;
    }

    

    function setValorizzazione($valorizzazione) {
        $this->valorizzazione = $valorizzazione;
    }
    
    function getGiacenzaIni() {
        return $this->giacenzaIni;
    }

    function getGiacenzaFin() {
        return $this->giacenzaFin;
    }

    function setGiacenzaIni($giacenzaIni) {
        $this->giacenzaIni = $giacenzaIni;
    }

    function setGiacenzaFin($giacenzaFin) {
        $this->giacenzaFin = $giacenzaFin;
    }



}

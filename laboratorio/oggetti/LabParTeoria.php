<?php

/**
 * Description of LabMatpriTeoria
 *
 * @author marilisa
 */
class LabParTeoria {

    //put your code here
    private $codLabFormula; //varchar(50) 
    private $nomePar; //varchar
//    private $descriPar; //varchar
    private $idPar; //int  
    private $uniMis; //varchar
    private $tipo; //varchar(45)
    private $valoreTeo; //int
    private $valoreTeoPerc; //float
    private $dtInser; //date

    function __construct($codLabFormula, $nomePar, $idPar, $uniMis, $tipo, $valoreTeo,$valoreTeoPerc) {
        $this->codLabFormula = $codLabFormula;
        $this->nomePar = $nomePar;
        $this->uniMis = $uniMis;
        $this->idPar = $idPar;
        $this->tipo = $tipo; //PercentualeSI o PercentualeNO
        $this->valoreTeo = $valoreTeo;
        $this->valoreTeoPerc = $valoreTeoPerc;
        
    }

    
    function comparaNomePar($a, $b) {

        if ($a->nomePar == $b->nomePar) {

            return 0;
        }

        return ($a->nomePar < $b->nomePar) ? -1 : 1;
    }
    
    
    public function __destruct() {
        
    }

    public function toString() {

        $output = "</br>objLabParTeoria [codLabFormula:" . $this->codLabFormula .
                "; idPar:" . $this->idPar .
                "; nomePar:" . $this->nomePar .
                "; uniMis:" . $this->uniMis .
                "; tipo:" . $this->tipo .
                "; valoreTeo:" . $this->valoreTeo .
                "; valoreTeoPerc:" . $this->valoreTeoPerc .
                "; dtInser:" . $this->dtInser . "]</br>";

        echo $output;
    }

    function getCodLabFormula() {
        return $this->codLabFormula;
    }

    function getNomePar() {
        return $this->nomePar;
    }

    function getIdPar() {
        return $this->idPar;
    }

    function getUniMis() {
        return $this->uniMis;
    }

    function getTipo() {
        return $this->tipo;
    }

    function getValoreTeo() {
        return $this->valoreTeo;
    }

    function getValoreTeoPerc() {
        return $this->valoreTeoPerc;
    }

    function getDtInser() {
        return $this->dtInser;
    }

    function setCodLabFormula($codLabFormula) {
        $this->codLabFormula = $codLabFormula;
    }

    function setNomePar($nomePar) {
        $this->nomePar = $nomePar;
    }

    function setIdPar($idPar) {
        $this->idPar = $idPar;
    }

    function setUniMis($uniMis) {
        $this->uniMis = $uniMis;
    }

    function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    function setValoreTeo($valoreTeo) {
        $this->valoreTeo = $valoreTeo;
    }

    function setValoreTeoPerc($valoreTeoPerc) {
        $this->valoreTeoPerc = $valoreTeoPerc;
    }

    function setDtInser($dtInser) {
        $this->dtInser = $dtInser;
    }


}



?>

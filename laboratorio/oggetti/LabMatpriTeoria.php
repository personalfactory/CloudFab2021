<?php

/**
 * Description of LabMatpriTeoria
 *
 * @author marilisa
 */
class LabMatpriTeoria {

    //put your code here
    private $codLabFormula; //varchar(50) 
    private $codMat; //varchar
    private $descriMat; //varchar
    private $idMat; //int  
    private $uniMis; //varchar
    private $costoUnit; //double
    private $costo; //double
    private $costoPerc; //double
    private $tipo; //varchar(45)
    private $macroTipo; //varchar (compound o drymix)
    private $qtaTeo; //int
    private $qtaTeoPerc; //float
    private $dtInser; //date

    function __construct($codLabFormula, $codMat, $idMat, $tipo, $qtaTeo, $qtaTeoPerc) {
        $this->codLabFormula = $codLabFormula;
        $this->codMat = $codMat;
        $this->idMat = $idMat;
        $this->tipo = $tipo; //Var o FIX
        $this->qtaTeo = $qtaTeo;
        $this->qtaTeoPerc = $qtaTeoPerc;
    }

    function comparaCodMat($a, $b) {

        if ($a->codMat == $b->codMat) {

            return 0;
        }

        return ($a->codMat < $b->codMat) ? -1 : 1;
    }

    public function __destruct() {
        
    }

    public function toString() {

        $output = "</br>objLabMatpriTeoria [codLabFormula:" . $this->codLabFormula .
                "; idMat:" . $this->idMat .
                "; tipo:" . $this->tipo .
                "; qtaTeo:" . $this->qtaTeo .
                "; qtaTeoPerc:" . $this->qtaTeoPerc .
                "; dtInser:" . $this->dtInser . "]</br>";

        echo $output;
    }

    public function getMacroTipo() {
        return $this->macroTipo;
    }

    public function setMacroTipo($macroTipo) {
        $this->macroTipo = $macroTipo;
    }

    public function getCodMat() {
        return $this->codMat;
    }

    public function setCodMat($codMat) {
        $this->codMat = $codMat;
    }

    public function getDescriMat() {
        return $this->descriMat;
    }

    public function setDescriMat($descriMat) {
        $this->descriMat = $descriMat;
    }

    public function getUniMis() {
        return $this->uniMis;
    }

    public function setUniMis($uniMis) {
        $this->uniMis = $uniMis;
    }

    public function getCostoUnit() {
        return $this->costoUnit;
    }

    public function setCostoUnit($costoUnit) {
        $this->costoUnit = $costoUnit;
    }

    public function getCosto() {
        return $this->costo;
    }

    public function setCosto($costo) {
        $this->costo = $costo;
    }

    public function getCostoPerc() {
        return $this->costoPerc;
    }

    public function setCostoPerc($costoPerc) {
        $this->costoPerc = $costoPerc;
    }

    public function getCodLabFormula() {
        return $this->codLabFormula;
    }

    public function setCodLabFormula($codLabFormula) {
        $this->codLabFormula = $codLabFormula;
    }

    public function getIdMat() {
        return $this->idMat;
    }

    public function setIdMat($idMat) {
        $this->idMat = $idMat;
    }

    public function getTipo() {
        return $this->tipo;
    }

    public function setTipo($tipo) {
        $this->tipo = $tipo;
    }

    public function getQtaTeo() {
        return $this->qtaTeo;
    }

    public function setQtaTeo($qtaTeo) {
        $this->qtaTeo = $qtaTeo;
    }

    public function getQtaTeoPerc() {
        return $this->qtaTeoPerc;
    }

    public function setQtaTeoPerc($qtaTeoPerc) {
        $this->qtaTeoPerc = $qtaTeoPerc;
    }

    public function getDtInser() {
        return $this->dtInser;
    }

    public function setDtInser($dtInser) {
        $this->dtInser = $dtInser;
    }

}

?>

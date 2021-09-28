<?php

/**
 * Description of OrdineOri
 *
 * @author marilisa
 */
class OrdineOri {

    //put your code here
    private $codProdotto; //varchar(50) 
    private $nomeProdotto; //varchar
    private $idProdotto; //int  
    private $numPezzi; //int
    private $pezzoKg; // int
    private $moltiplicatore; // int
    private $dtOrdine; //
    private $tipoChimica;// sfusa o kit
    private $descriTipoChimica;
    private $tipoConfezione;// sacco o secchio
    private $descriTipoConfezione;
    private $ribalta;
    private $descriRibalta;
    private $cliente;
    private $cambioCemento;
    private $descriCambioCemento;
    private $colorato;
    private $descriColorato;
    private $prodottoConAdditivo;
    private $descriAdditivo;
    private $idRicettaColore;
    private $idRicettaAdditivo;
    private $nomeRicettaColore;
    private $nomeRicettaAdditivo;
    private $cambioBilancia;
    private $descriCambioBilancia;
    private $ordineProduzione;
    private $stringaComponenti;
    private $stringaDescriComponenti;
    
    

    function __construct($idProdotto,$codProdotto,$nomeProdotto,$numPezzi,$pezzoKg,$moltiplicatore, $dtOrdine) {
        $this->idProdotto = $idProdotto;
        $this->codProdotto = $codProdotto;
        $this->nomeProdotto = $nomeProdotto;         
        $this->numPezzi = $numPezzi;
        $this->pezzoKg = $pezzoKg;
        $this->moltiplicatore = $moltiplicatore;
        $this->dtOrdine = $dtOrdine;
        
    }

    function comparaCodProdotto($a, $b) {

        if ($a->codProdotto == $b->codProdotto) {

            return 0;
        }

        return ($a->codProdotto < $b->codProdotto) ? -1 : 1;
    }

    public function __destruct() {
        
    }

    public function toString() {

        $output = "</br>objOrdineOri [codProdotto:" . $this->codProdotto .
                "; idProdotto:" . $this->idProdotto .
                "; nomeProdotto:" . $this->nomeProdotto .
                "; numPezzi:" . $this->numPezzi .
                "; pezzoKg:" . $this->pezzoKg .
                
                "; dtOrdine:" . $this->dtOrdine . "]</br>";

        echo $output;
    }

    public function getCodProdotto() {
        return $this->codProdotto;
    }

    public function setCodProdotto($codProdotto) {
        $this->codProdotto = $codProdotto;
    }

    public function getIdProdotto() {
        return $this->idProdotto;
    }

    public function setIdProdotto($idProdotto) {
        $this->idProdotto = $idProdotto;
    }

    public function getNomeProdotto() {
        return $this->nomeProdotto;
    }

    public function setNomeProdotto($nomeProdotto) {
        $this->nomeProdotto = $nomeProdotto;
    }

   
   

    public function getNumPezzi() {
        return $this->numPezzi;
    }

    public function setNumPezzi($numPezzi) {
        $this->numPezzi = $numPezzi;
    }

    public function getDtOrdine() {
        return $this->dtOrdine;
    }

    public function setDtOrdine($dtOrdine) {
        $this->dtOrdine = $dtOrdine;
    }

    function getPezzoKg() {
        return $this->pezzoKg;
    }

    function setPezzoKg($pezzoKg) {
        $this->pezzoKg = $pezzoKg;
    }

    function getMoltiplicatore() {
        return $this->moltiplicatore;
    }

    function setMoltiplicatore($moltiplicatore) {
        $this->moltiplicatore = $moltiplicatore;
    }

    function getTipoChimica() {
        return $this->tipoChimica;
    }
    

    function getTipoConfezione() {
        return $this->tipoConfezione;
        
    }
      

    function getRibalta() {
        return $this->ribalta;
    }

    function getCliente() {
        return $this->cliente;
    }

    function getCambioCemento() {
        return $this->cambioCemento;
    }

    

    function getCambioBilancia() {
        return $this->cambioBilancia;
    }

    function setTipoChimica($tipoChimica) {
        $this->tipoChimica = $tipoChimica;
    }

    function setTipoConfezione($tipoConfezione) {
        $this->tipoConfezione = $tipoConfezione;
    }

    function setRibalta($ribalta) {
        $this->ribalta = $ribalta;
    }

    function setCliente($cliente) {
        $this->cliente = $cliente;
    }

    function setCambioCemento($cambioCemento) {
        $this->cambioCemento = $cambioCemento;
    }

    function setColorato($colorato) {
        $this->colorato = $colorato;
    }
    function setDescriColorato($descriColorato) {
        $this->descriColorato = $descriColorato;
    }

    function setCambioBilancia($cambioBilancia) {
        $this->cambioBilancia = $cambioBilancia;
    }
    function getDescriTipoChimica() {
        return $this->descriTipoChimica;
    }

    function getDescriTipoConfezione() {
        return $this->descriTipoConfezione;
    }

    function getDescriRibalta() {
        return $this->descriRibalta;
    }

    function getDescriCambioCemento() {
        return $this->descriCambioCemento;
    }

    

    function getDescriCambioBilancia() {
        return $this->descriCambioBilancia;
    }

    function setDescriTipoChimica($descriTipoChimica) {
        $this->descriTipoChimica = $descriTipoChimica;
    }

    function setDescriTipoConfezione($descriTipoConfezione) {
        $this->descriTipoConfezione = $descriTipoConfezione;
    }

    function setDescriRibalta($descriRibalta) {
        $this->descriRibalta = $descriRibalta;
    }

    function setDescriCambioCemento($descriCambioCemento) {
        $this->descriCambioCemento = $descriCambioCemento;
    }

    

    function setDescriCambioBilancia($descriCambioBilancia) {
        $this->descriCambioBilancia = $descriCambioBilancia;
    }

    function getIdRicettaColore() {
        return $this->idRicettaColore;
    }

    function getIdRicettaAdditivo() {
        return $this->idRicettaAdditivo;
    }

    function setIdRicettaColore($idRicettaColore) {
        $this->idRicettaColore = $idRicettaColore;
    }

    function setIdRicettaAdditivo($idRicettaAdditivo) {
        $this->idRicettaAdditivo = $idRicettaAdditivo;
    }

    function getNomeRicettaColore() {
        return $this->nomeRicettaColore;
    }

    function getNomeRicettaAdditivo() {
        return $this->nomeRicettaAdditivo;
    }

    function setNomeRicettaColore($nomeRicettaColore) {
        $this->nomeRicettaColore = $nomeRicettaColore;
    }

    function setNomeRicettaAdditivo($nomeRicettaAdditivo) {
        $this->nomeRicettaAdditivo = $nomeRicettaAdditivo;
    }

    function getProdottoConAdditivo() {
        return $this->prodottoConAdditivo;
    }

    function setProdottoConAdditivo($prodottoConAdditivo) {
        $this->prodottoConAdditivo = $prodottoConAdditivo;
    }

    function getDescriAdditivo() {
        return $this->descriAdditivo;
    }

    function setDescriAdditivo($descriAdditivo) {
        $this->descriAdditivo = $descriAdditivo;
    }
    function getOrdineProduzione() {
        return $this->ordineProduzione;
    }

    function setOrdineProduzione($ordineProduzione) {
        $this->ordineProduzione = $ordineProduzione;
    }

    function getStringaComponenti() {
        return $this->stringaComponenti;
    }

    function setStringaComponenti($stringaComponenti) {
        $this->stringaComponenti = $stringaComponenti;
    }

    function getStringaDescriComponenti() {
        return $this->stringaDescriComponenti;
    }

    function setStringaDescriComponenti($stringaDescriComponenti) {
        $this->stringaDescriComponenti = $stringaDescriComponenti;
    }




}

?>

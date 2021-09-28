<?php
/**
 * Description of Produttivita
 *
 * @author marilisa
 */
class Produttivita {

  //put your code here
  private $dt_prec; //timestamp 
  private $dt_att; //timestamp 
  private $diff; //	bigint(20) 
  private $gruppo; //	varchar(255) 
  private $geografico; //varchar(255) 
  private $id_macchina; //	int(11) 
  private $id_processo; //	int(11) 
  private $giorni; //	bigint(20) 
  private $ore; //	int(11) 
  private $minuti; //	int(11) 
  private $secondi; //	int(11) 
  private $in_servizio; //	int(11) 
  private $attivo; //	int(11) 
  private $cod_prodotto; //	varchar(45) 
  private $cod_chimica; //	varchar(45) 
  private $cod_sacco; //	varchar(45) 
  private $cod_operatore; //	varchar(45) 

  function __construct($dt_prec, $dt_att, $id_macchina, $id_processo, $cod_prodotto, $cod_chimica, $cod_sacco, $cod_operatore) {
    $this->dt_prec = $dt_prec;
    $this->dt_att = $dt_att;
    $this->id_macchina = $id_macchina;
    $this->id_processo = $id_processo;
    $this->cod_prodotto = $cod_prodotto;
    $this->cod_chimica = $cod_chimica;
    $this->cod_sacco = $cod_sacco;
    $this->cod_operatore = $cod_operatore;
 }
 
// function __construct($id_processo, $cod_chimica, $diff){
//   
//    $this->id_processo = $id_processo;
//    $this->cod_chimica = $cod_chimica;
//    $this->diff = $diff;
//    
// }
 
 function toString(){
        
    $output= "</br>objProduttivita [IdMac:".$this->id_macchina.
        "; DtPrec:".$this->dt_prec.
        "; DtAtt:".$this->dt_att.
        "; IdProd:".$this->id_processo.
        "; CodProd:".$this->cod_prodotto.
        "; CodChim:".$this->cod_chimica.
        "; CodSac:".$this->cod_sacco.
        "; CodOper:".$this->cod_operatore."]</br>";

  return $output;    
    
}
  
  /**
   * CALCOLA ORE MINUTI SECONDI TOTALI
   * giorni=FLOOR(diff/86400);
   * ore=FLOOR(diff/3600);
   * minuti=FLOOR(diff/60);
   * 
   * 
   */
  public function setTime() {

    //Calcolo dei giorni,ore,minuti
    $this->giorni = FLOOR($this->diff / 86400);
    $this->ore = FLOOR($this->diff / 3600);
    $this->minuti = FLOOR($this->diff / 60);
  
  }

  /**
   * ore=ore-giorni*24;
   * minuti=minuti-giorni*1440-ore*60;
   * secondi=secondi-giorni*86400-ore*3600-minuti*60;
   * tot_ore=(giorni*24)+ore+(minuti/60)+(secondi/3600);
   * tot_minuti=giorni*1440+ore*60+minuti+secondi/60;
   * @param type $giorni
   * @param type $ore
   * @param type $minuti
   */
  public function setTimeTot($giorni,$ore,$minuti,$secondi){
    
    $this->ore = FLOOR($ore - $giorni*24);
    $this->minuti = FLOOR($minuti - ($giorni * 1440) - ($this->ore * 60));
    $this->secondi = FLOOR($secondi-($giorni*86400)-($this->ore*3600)-($this->minuti*60)); 
  
  } 
 
  
  public function getDt_prec() {
    return $this->dt_prec;
  }

  public function setDt_prec($dt_prec) {
    $this->dt_prec = $dt_prec;
  }

  public function getDt_att() {
    return $this->dt_att;
  }

  public function setDt_att($dt_att) {
    $this->dt_att = $dt_att;
  }

  public function getDiff() {
    return $this->diff;
  }

  public function setDiff($diff) {
    $this->diff = $diff;
  }
  
  public function getGruppo() {
    return $this->gruppo;
  }

  public function setGruppo($gruppo) {
    $this->gruppo = $gruppo;
  }

  public function getGeografico() {
    return $this->geografico;
  }

  public function setGeografico($geografico) {
    $this->geografico = $geografico;
  }

  public function getId_macchina() {
    return $this->id_macchina;
  }

  public function setId_macchina($id_macchina) {
    $this->id_macchina = $id_macchina;
  }

  public function getId_processo() {
    return $this->id_processo;
  }

  public function setId_processo($id_processo) {
    $this->id_processo = $id_processo;
  }

  public function getGiorni() {
    return $this->giorni;
  }

  public function setGiorni($giorni) {
    $this->giorni = $giorni;
  }

  public function getOre() {
    return $this->ore;
  }

  public function setOre($ore) {
    $this->ore = $ore;
  }

  public function getMinuti() {
    return $this->minuti;
  }

  public function setMinuti($minuti) {
    $this->minuti = $minuti;
  }

  public function getSecondi() {
    return $this->secondi;
  }

  public function setSecondi($secondi) {
    $this->secondi = $secondi;
  }

  public function getTot_ore() {
    return $this->tot_ore;
  }

  public function setTot_ore($tot_ore) {
    $this->tot_ore = $tot_ore;
  }

  public function getTot_minuti() {
    return $this->tot_minuti;
  }

  public function setTot_minuti($tot_minuti) {
    $this->tot_minuti = $tot_minuti;
  }

  public function getIn_servizio() {
    return $this->in_servizio;
  }

  public function setIn_servizio($in_servizio) {
    $this->in_servizio = $in_servizio;
  }

  public function getAttivo() {
    return $this->attivo;
  }

  public function setAttivo($attivo) {
    $this->attivo = $attivo;
  }

  public function getCod_prodotto() {
    return $this->cod_prodotto;
  }

  public function setCod_prodotto($cod_prodotto) {
    $this->cod_prodotto = $cod_prodotto;
  }

  public function getCod_chimica() {
    return $this->cod_chimica;
  }

  public function setCod_chimica($cod_chimica) {
    $this->cod_chimica = $cod_chimica;
  }

  public function getCod_sacco() {
    return $this->cod_sacco;
  }

  public function setCod_sacco($cod_sacco) {
    $this->cod_sacco = $cod_sacco;
  }

  public function getCod_operatore() {
    return $this->cod_operatore;
  }

  public function setCod_operatore($cod_operatore) {
    $this->cod_operatore = $cod_operatore;
  }

}

?>

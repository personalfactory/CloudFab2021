<?php


#######################################################################################################################
///////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
//////////////////////////////////////////////////AREA MENU////////////////////////////////////////////////////////////

//La classe menù conterrà un inseieme di moduli che un utente(utente loggato) può visualizzre
class Menu
{
    private $idUtente;
    private $nomeUtente;

    private $arrayModuli=array();
    private $indexArrayModuli;

    function __construct($idUt, $nUt)
    {
        $this->idUtente = $idUt;
        $this->nomeUtente = $nUt;

        $this->indexArrayModuli=0;
    }


    //Metodo che aggiunge un modulo all'array moduli
    public function addModuloObject( $objModulo )
    {
        $this->arrayModuli[$this->indexArrayModuli]=$objModulo;
        $this->indexArrayModuli++;
    }

    public function getArrayModuli()
    {
        return $this->arrayModuli;
    }

    public function getIdUtente(){  return $this->idUtente; }
    public function getNomeUtente(){  return $this->nomeUtente;  }

    //Metodo che stampa moduli voci e sottovoci del menu
    public function printMenu()
    {
        $arrayModuliTemp=$this->arrayModuli;
        for($i=0; $i<count($arrayModuliTemp); $i++)
        {
            $moduloCorrente=$arrayModuliTemp[$i];

            echo $moduloCorrente->getNomeModulo()."<br><br>";

            $arrayDiVociTemp=$moduloCorrente->getArrayVoci();
            for($j=0; $j<count($arrayDiVociTemp); $j++)
            {
                $voceCorrente=$arrayDiVociTemp[$j];

                echo "&nbsp; &nbsp;".$voceCorrente->getNomeVoce()."<br>";

                if($voceCorrente->sottovoce())
                {
                    $arraDiSottovociTemp=$voceCorrente->getArraySottovoci();
                    for($k=0; $k<count($arraDiSottovociTemp); $k++)
                    {
                        $sottovoceCorrente=$arraDiSottovociTemp[$k];

                        echo "&nbsp;&nbsp;&nbsp;&nbsp;-> ".$sottovoceCorrente->getNomeSottoVoce()."<br>";
                    }
                }

            }//for 2
            echo "<br>";

        }//for
    }
}



//Modulo contiene l'informazione sul modulo e sull'elenco di voci che lo compongono
//L'elenco di voci sarà sempre pieno se modulo è attivo
class Modulo
{
    private $idModulo;
    private $modulo;
    private $variabileModuloLingue;

    private $arrayVoci=array();
    private $indexArrayVoci;

    function __construct($idMod, $mod,$varModuloLingue)
    {
        $this->idModulo = $idMod;
        $this->modulo = $mod;
        $this->variabileModuloLingue=$varModuloLingue;
        $this->indexArrayVoci=0;


    }

    public function setVariabileModuloLingua( $varModuloLingue )
    {

        $this->variabileModuloLingue=$varModuloLingue;
    }

    //Metodo che aggiunge una voce all'array voci
    public function addVoceObject( $objVoce )
    {
        $this->arrayVoci[$this->indexArrayVoci]=$objVoce;
        $this->indexArrayVoci++;
    }


    public function getIdModulo(){ return $this->idModulo; }
    public function getNomeModulo(){ return $this->modulo; }
    public function getArrayVoci(){ return $this->arrayVoci; }

    //Metodo che restituisce il nome della variabile da cui andremo
    //poi a ricavare il nome del modulo
    public function getNomeVariabileLingua()
    {
        return $this->variabileModuloLingue;
    }

}


//Voce contiene l'informazione sulla voce e sull'elenco di sottovoci che possono o non possono comporlo
//L'elenco di sottovoci potrà essere pieno o vuoto indifferentemente anche se la voce è attiva
class Voce
{
    private $idVoce;
    private $voce;
    private $link_voce;
    private $variabileVoceLingue;

    private $arraySottoVoci=array();
    private $indexArraySottoVoci;


    function __construct($idVoc, $voc, $linkV, $varVoceLingue)
    {
        $this->idVoce = $idVoc;
        $this->voce = $voc;
        $this->link_voce = $linkV;
        $this->variabileVoceLingue=$varVoceLingue;
        $this->indexArraySottoVoci=0;
    }

    public function setVariabileVoceLingua( $varVoceLingue )
    {
        $this->variabileVoceLingue=$varVoceLingue;
    }

    //Metodo che aggiunge all'array di sottovoci un nuovo oggetto sottovoce
    public function addSottoVoceObject($sottoVoceObj)
    {
       $this->arraySottoVoci[$this->indexArraySottoVoci]=$sottoVoceObj;
       $this->indexArraySottoVoci++;

    }

    public function getIdVoce(){ return $this->idVoce; }
    public function getNomeVoce(){ return $this->voce; }
    public function getLinkVoce(){ return $this->link_voce; }
    public function getArraySottoVoci(){ return $this->arraySottoVoci; }

    //Metodo che restituisce il nome della variabile da cui andremo
    //poi a ricavare il nome della voce
    public function getNomeVariabileLingua()
    {
        return $this->variabileVoceLingue;
    }


    //Metodo che restituisce true se c'è almeno una sottovoce per questa voce
    //e false altrimenti
    public function sottovoce()
    {
       if(!isset($this->arraySottoVoci))
       {
          return false;
       }

        if(  count($this->arraySottoVoci)==0 )
        {
           return false;
        }
        else
        {
           return true;
        }
    }
}


class SottoVoce
{
    private $idSottoVoce;
    private $sottoVoce;
    private $link_sotto_voce;
    private $variabileSottoVoceLingue;

    function __construct($idSottVoc, $sottoVoc, $linkSottoV, $varSottoVoceLingue )
    {
        $this->idSottoVoce = $idSottVoc;
        $this->sottoVoce = $sottoVoc;
        $this->link_sotto_voce = $linkSottoV;
        $this->variabileSottoVoceLingue=$varSottoVoceLingue;
    }


    public function setVariabileVoceLingua( $varSottoVoceLingue )
    {
        $this->variabileSottoVoceLingue=$varSottoVoceLingue;
    }

    public function getIdSottoVoce(){ return $this->idSottoVoce; }
    public function getNomeSottoVoce(){ return $this->sottoVoce; }

    public function getLinkSottoVoce(){ return $this->link_sotto_voce; }

    //Metodo che restituisce il nome della variabile da cui andremo
    //poi a ricavare il nome della sottovoce
    public function getNomeVariabileLingua()
    {
        return $this->variabileSottoVoceLingue;
    }


}




?>

	function visualizzaMondo(){
		document.getElementById("Mondo").style.visibility = "visible";
		document.getElementById("Continente").style.visibility = "hidden";
		document.getElementById("Stato").style.visibility = "hidden";
		document.getElementById("Regione").style.visibility = "hidden";
		document.getElementById("Provincia").style.visibility = "hidden";
		document.getElementById("Comune").style.visibility = "hidden";
		
	}
	function visualizzaContinente(){
		document.getElementById("Mondo").style.visibility = "hidden";
		document.getElementById("Continente").style.visibility = "visible";
		document.getElementById("Stato").style.visibility = "hidden";
		document.getElementById("Regione").style.visibility = "hidden";
		document.getElementById("Provincia").style.visibility = "hidden";
		document.getElementById("Comune").style.visibility = "hidden";
		
	}
	
	function visualizzaStato(){
		document.getElementById("Mondo").style.visibility = "hidden";
		document.getElementById("Continente").style.visibility = "hidden";
		document.getElementById("Stato").style.visibility = "visible";
		document.getElementById("Regione").style.visibility = "hidden";
		document.getElementById("Provincia").style.visibility = "hidden";
		document.getElementById("Comune").style.visibility = "hidden";
		
	}
	function visualizzaRegione(){
		document.getElementById("Mondo").style.visibility = "hidden";
		document.getElementById("Continente").style.visibility = "hidden";
		document.getElementById("Stato").style.visibility = "hidden";
		document.getElementById("Regione").style.visibility = "visible";
		document.getElementById("Provincia").style.visibility = "hidden";
		document.getElementById("Comune").style.visibility = "hidden";
		
	}
	function visualizzaProvincia(){
		document.getElementById("Mondo").style.visibility = "hidden";
		document.getElementById("Continente").style.visibility = "hidden";
		document.getElementById("Stato").style.visibility = "hidden";
		document.getElementById("Regione").style.visibility = "hidden";
		document.getElementById("Provincia").style.visibility = "visible";
		document.getElementById("Comune").style.visibility = "hidden";
		
	}
	function visualizzaComune(){
		document.getElementById("Mondo").style.visibility = "hidden";
		document.getElementById("Continente").style.visibility = "hidden";
		document.getElementById("Stato").style.visibility = "hidden";
		document.getElementById("Regione").style.visibility = "hidden";
		document.getElementById("Provincia").style.visibility = "hidden";
		document.getElementById("Comune").style.visibility = "visible";
		
	}
	
	//inizio funzioni per la visualizzazione dei gruppi
	
		function visualizzaSestoLivello(){
		document.getElementById("PrimoLivello").style.visibility = "hidden";
		document.getElementById("SecondoLivello").style.visibility = "hidden";
		document.getElementById("TerzoLivello").style.visibility = "hidden";
		document.getElementById("QuartoLivello").style.visibility = "hidden";
		document.getElementById("QuintoLivello").style.visibility = "hidden";
		document.getElementById("SestoLivello").style.visibility = "visible";
		}
		function visualizzaQuintoLivello(){
		document.getElementById("PrimoLivello").style.visibility = "hidden";
		document.getElementById("SecondoLivello").style.visibility = "hidden";
		document.getElementById("TerzoLivello").style.visibility = "hidden";
		document.getElementById("QuartoLivello").style.visibility = "hidden";
		document.getElementById("QuintoLivello").style.visibility = "visible";
		document.getElementById("SestoLivello").style.visibility = "hidden";
		}
		function visualizzaQuartoLivello(){
		document.getElementById("PrimoLivello").style.visibility = "hidden";
		document.getElementById("SecondoLivello").style.visibility = "hidden";
		document.getElementById("TerzoLivello").style.visibility = "hidden";
		document.getElementById("QuartoLivello").style.visibility = "visible";
		document.getElementById("QuintoLivello").style.visibility = "hidden";
		document.getElementById("SestoLivello").style.visibility = "hidden";
		}
		function visualizzaTerzoLivello(){
		document.getElementById("PrimoLivello").style.visibility = "hidden";
		document.getElementById("SecondoLivello").style.visibility = "hidden";
		document.getElementById("TerzoLivello").style.visibility = "visible";
		document.getElementById("QuartoLivello").style.visibility = "hidden";
		document.getElementById("QuintoLivello").style.visibility = "hidden";
		document.getElementById("SestoLivello").style.visibility = "hidden";
		}
		function visualizzaSecondoLivello(){
		document.getElementById("PrimoLivello").style.visibility = "hidden";
		document.getElementById("SecondoLivello").style.visibility = "visible";
		document.getElementById("TerzoLivello").style.visibility = "hidden";
		document.getElementById("QuartoLivello").style.visibility = "hidden";
		document.getElementById("QuintoLivello").style.visibility = "hidden";
		document.getElementById("SestoLivello").style.visibility = "hidden";
		}
		function visualizzaPrimoLivello(){
		document.getElementById("PrimoLivello").style.visibility = "visible";
		document.getElementById("SecondoLivello").style.visibility = "hidden";
		document.getElementById("TerzoLivello").style.visibility = "hidden";
		document.getElementById("QuartoLivello").style.visibility = "hidden";
		document.getElementById("QuintoLivello").style.visibility = "hidden";
		document.getElementById("SestoLivello").style.visibility = "hidden";
		}
		
		//funzioni per la visualizzazione dei dizionari
		
		function visualizzaCodiceProdotto(){
		document.getElementById("CodiceProdotto").style.visibility = "visible";
		document.getElementById("DescrizioneCodice").style.visibility = "hidden";
		document.getElementById("NomeColoreBase").style.visibility = "hidden";
		document.getElementById("NomeComponente").style.visibility = "hidden";
		document.getElementById("MessaggioMacchina").style.visibility = "hidden";		
		}
		function visualizzaDescriCodice(){
		document.getElementById("CodiceProdotto").style.visibility = "hidden";
		document.getElementById("DescrizioneCodice").style.visibility = "visible";
		document.getElementById("NomeColoreBase").style.visibility = "hidden";
		document.getElementById("NomeComponente").style.visibility = "hidden";
		document.getElementById("MessaggioMacchina").style.visibility = "hidden";
		
		}
		function visualizzaNomeColoreBase(){
		document.getElementById("CodiceProdotto").style.visibility = "hidden";
		document.getElementById("DescrizioneCodice").style.visibility = "hidden";
		document.getElementById("NomeColoreBase").style.visibility = "visible";
		document.getElementById("NomeComponente").style.visibility = "hidden";
		document.getElementById("MessaggioMacchina").style.visibility = "hidden";
		
		}
		function visualizzaNomeComponente(){
		document.getElementById("CodiceProdotto").style.visibility = "hidden";
		document.getElementById("DescrizioneCodice").style.visibility = "hidden";
		document.getElementById("NomeColoreBase").style.visibility = "hidden";
		document.getElementById("NomeComponente").style.visibility = "visible";
		document.getElementById("MessaggioMacchina").style.visibility = "hidden";
		
		}
		function visualizzaMessaggioMacchina(){
		document.getElementById("CodiceProdotto").style.visibility = "hidden";
		document.getElementById("DescrizioneCodice").style.visibility = "hidden";
		document.getElementById("NomeColoreBase").style.visibility = "hidden";
		document.getElementById("NomeComponente").style.visibility = "hidden";
		document.getElementById("MessaggioMacchina").style.visibility = "visible";
		
		}


//Funzioni per la visualizzazione del form relativo alla qta di miscela
        function visualizzaFormNumLotti() {

            document.getElementById("NumeroKitSacchetti").style.visibility = "visible";
            document.getElementById("NumeroLotti").style.visibility = "visible";

            document.getElementById("QtaMiscelaInserita").style.visibility = "hidden";
            document.getElementById("PesoLotto").style.visibility = "hidden";

//            document.getElementById("QtaMiscelaInserita").value = "0";
//            document.getElementById("PesoLotto").value = "0";

            document.getElementById("A").style.backgroundColor = "#ACA59D"; //grigio scuro
            document.getElementById("B").style.backgroundColor = "#ACA59D"; //grigio scuro

            document.getElementById("C").style.color = "#FFFFFF"; // bianco
            document.getElementById("D").style.color = "#FFFFFF"; // bianco            
            document.getElementById("C").style.backgroundColor = "#E1E1E1"; //grigio chiaro
            document.getElementById("D").style.backgroundColor = "#E1E1E1"; //grigio chiaro
            
            //checkbox
            document.getElementById("E").style.backgroundColor = "#ACA59D"; //grigio scuro
            document.getElementById("F").style.backgroundColor = "#E1E1E1"; //grigio chiaro
            document.getElementById("MetodoCalcolo[LottiKit]").checked = true;
            document.getElementById("MetodoCalcolo[MiscelaTot]").checked = false;
            
            document.getElementById("A").style.color = "#000000"; // nero
            document.getElementById("B").style.color = "#000000"; // nero

        }
        function visualizzaFormQtaMiscelaTot() {
            document.getElementById("QtaMiscelaInserita").style.visibility = "visible";
            document.getElementById("PesoLotto").style.visibility = "visible";

            document.getElementById("NumeroKitSacchetti").style.visibility = "hidden";
            document.getElementById("NumeroLotti").style.visibility = "hidden";

//            document.getElementById("NumeroKitSacchetti").value = "0";
//            document.getElementById("NumeroLotti").value = "0";

            document.getElementById("C").style.backgroundColor = "#ACA59D"; //grigio scuro
            document.getElementById("D").style.backgroundColor = "#ACA59D"; //grigio scuro

            document.getElementById("A").style.color = "#FFFFFF"; // bianco
            document.getElementById("B").style.color = "#FFFFFF"; // bianco
            document.getElementById("A").style.backgroundColor = "#E1E1E1"; //grigio chiaro
            document.getElementById("B").style.backgroundColor = "#E1E1E1"; //grigio chiaro
                        
            //checkbox
            document.getElementById("F").style.backgroundColor = "#ACA59D"; //grigio scuro
            document.getElementById("MetodoCalcolo[MiscelaTot]").checked = true;
            document.getElementById("MetodoCalcolo[LottiKit]").checked = false;
            document.getElementById("E").style.backgroundColor = "#E1E1E1"; //grigio chiaro
            
            document.getElementById("C").style.color = "#000000"; // nero
            document.getElementById("D").style.color = "#000000"; // nero
        }


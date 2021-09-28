<?php
/* Calcola il costo di un lotto di chimica per una data formula */
function calcolaCostoLotto($cod_formula)
{
  
   $costoForm=floatval(0);
   $form['totale']=floatval(0);
   $form["cod_formula"]=$cod_formula;
        
   //Costo miscela di chimica
   $query_MatPr="SELECT g.cod_mat,quantita,descri_mat,pre_acq FROM serverdb.generazione_formula g
       INNER JOIN serverdb.materia_prima m ON g.cod_mat=m.cod_mat 
       WHERE cod_formula='".$form["cod_formula"]."'";

   $risultatoMatPr=mysql_query($query_MatPr) or die(mysql_error());
   $rigoMatPr=mysql_fetch_assoc($risultatoMatPr);

   do
   {
      $costoMatPr=floatval(($rigoMatPr["quantita"])/1000)*floatval ($rigoMatPr["pre_acq"]);
	  $costoForm+=round($costoMatPr,2);
   }while($rigoMatPr=mysql_fetch_assoc($risultatoMatPr));
   mysql_free_result($risultatoMatPr);

   //Numero sacchetti per ogni lotto di chimica
   $query_Form="SELECT num_sac FROM serverdb.formula WHERE cod_formula='".$form["cod_formula"]."'";
   $risultatoForm=mysql_query($query_Form) or die(mysql_error());
   $rigoForm=mysql_fetch_assoc($risultatoForm);
   mysql_free_result($risultatoForm);
   
   //Quantita di sacchetti per mischela di chimica
   $query_SacCh="SELECT quantita FROM serverdb.accessorio_formula  WHERE cod_formula='".$form["cod_formula"]."' AND accessorio='sacCh'";
   $risultatoSacCh=mysql_query($query_SacCh) or die(mysql_error());
   $rigoSacCh=mysql_fetch_assoc($risultatoSacCh);
   mysql_free_result($risultatoSacCh);
   $qntSacCh=$rigoSacCh["quantita"];
   
   //Costo sacchetto di chimica
   $query_FormAcc="SELECT accessorio,quantita,descri,pre_acq FROM serverdb.accessorio_formula f INNER JOIN serverdb.accessorio a  on f.accessorio=a.codice WHERE cod_formula='".$form["cod_formula"]."'";
   $risultatoAcc=mysql_query($query_FormAcc) or die(mysql_error());
   $rigoAcc=mysql_fetch_assoc($risultatoAcc);
   $row_num_risultatoAcc=mysql_num_rows($risultatoAcc);   
   
   $costoSac=floatval(0);
   do
   {
      $acces=$rigoAcc["accessorio"];
	  
	  if(strcasecmp($acces,"sacCh")==0)
	  {  
	    // Costo miscela di chimica per ogni sacchetto
	    if ($rigoAcc["quantita"] > 0)
		{
		   $qntSac=$rigoAcc["quantita"];
		   $costoSac=floatval($costoForm/$rigoAcc["quantita"]);
		}		
	  }
	 
	  if((strcasecmp($acces,"scatLot")==0) || (strcasecmp($acces,"eticLot")==0) ) 
      {
	     $form[$acces]=floatval ($rigoAcc["pre_acq"]/$rigoForm["num_sac"]);
	  }
	  else
	  {
	     if( strcasecmp($acces,"oper")==0 )
	        $form[$acces]=floatval($rigoAcc["quantita"]*$rigoAcc["pre_acq"]/$qntSacCh);
		 else
	        $form[$acces]=floatval($rigoAcc["pre_acq"]); 
	  }
	  $form["totale"]+=round($form[$acces],2);
   }while($rigoAcc=mysql_fetch_assoc($risultatoAcc));
   mysql_free_result($risultatoAcc);
   
   $form["totale"]+=round($costoSac,2);

   //Costo lotto di chimica
   $costoLot=floatval($form["totale"]*$rigoForm["num_sac"]);
   
   return $costoLot;
}

/* Trova il prezzo di vendita del lotto */
function prezzoLotto($cod_formula)
{
   
   
   $codLotto="L".substr($cod_formula,1);
  
   //Prezzo di vendita del lotto e costo del lotto
   $query_Lot="SELECT listino,costo FROM serverdb.lotto_artico WHERE codice='".$codLotto."' ";
   $risultatoLot=mysql_query($query_Lot) or die(mysql_error());
   $rigoLot=mysql_fetch_assoc($risultatoLot);
   $ris=array($rigoLot["listino"],$rigoLot["costo"]);
   return $ris;
}
 
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php
    include('../include/validator.php');
    ?>
    <head>
     
        <?php include('../include/header.php'); ?>
    </head>
    <body>
         <div id="InfoCont">
          <b>RICETTE DI ADDITIVI</b><br/><br/>
            Le ricette di additivi sono delle integrazioni che si possono aggiungere ai prodotti. 
            
            Ogni prodotto prevede una serie di additivi, in fase di produzione a bordo macchina è possibile selezionare uno o più additivi per ciascun prodotto.<br/><br/>
                     
            PROCEDURA PER LA CREAZIONE DI UNA NUOVA RICETTA ADDITIVO<br/><br/>
            
            1) <b>Creare una formula compound per l' additivo</b>, selezionando la famiglia "ADDITIVO - INTEGRAZIONE MACCHINA KADV vedi <a href="guida_nuova_formula_compound.php">Nuova formula compound</a>
            
            nella formulazine si utilizzano le materie prime di tipo "compound", precedentemente caricate nell' archivio di "laboratorio" vedi <a href="guida_nuova_matpri_laboratorio.php">Nuova materia prima di laboratorio</a> 
            
            e poi importate nell'archivio di "produzione compound" vedi <a href="guida_nuova_matpri_compound.php">Importa nuova materia prima in produzione compound </a> <br/><br/>
                
            2) <b>Creare una nuova materia prima drymix di tipo "ADDITVO"</b> vedi <a href="guida_nuova_matpri_drymix.php">Nuova materia prima drymix</a>
                assegnandogli lo stesso nome della formula compound creata per l'additivo (di cui al punto 1). (Ogni additivo deve essere associato ad una formula compound)<br/><br/>
                
            3) <b>Creare la "ricetta dell' additivo"</b>, vedi <a href="guida_nuova_ricetta_additivo.php">Nuova ricetta additivo</a>
            utilizzando gli additivi di cui al punto 2<br/><br/> 
        
            SCHEMA PER LA GESTIONE DEGLI ADDITIVI<br/><br/>
                                    
            <img src="/CloudFab/images/ImmAdd3.png" />
             
              SCHEMA TRACCIABILITA<br/><br/>
             Associando il codice del kit del "compound additivo" al movimento in ingresso dell'additivo, è possibile completare la tracciabilità 
                                                        
            e sapere con precisione, per ogni prodotto finito, tutti gli additivi che sono stati usati e la loro formulazione.<br/><br/> 
           
             
            <img src="/CloudFab/images/ImmAdd2.png" />
            
            
           
            
        </div>
    </body>
</html>

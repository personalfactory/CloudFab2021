	<table width="700">
	            <tr>
	              <td colspan="2"><div id="MSG">Selezionare una tipologia di Dizionario</div></td>
                </tr>
	            <tr>
	              <td style="background:#ACA59D"><input type="radio" id="scegli_dizionario" name="scegli_dizionario" onclick=	       		"javascript:visualizzaCodiceProdotto();" value="CodiceProdotto" />
	                Codice Prodotto</td>
	              <td bgcolor="#FFFFFF"><div id="Prodotto" style="visibility:hidden;">
	                <select id="CodiceProdotto" name="CodiceProdotto">
	                  <?php 
							include('../Connessioni/serverdb.php');
                        	$sql = mysql_query("SELECT  * FROM  prodotto 
														WHERE 		   																			         													cod_prodotto IS NOT NULL 
															AND 
															cod_prodotto<>'' 
														ORDER BY cod_prodotto") 
                                or die("Errore 101: " . mysql_error());
                        	while($row=mysql_fetch_array($sql))
                            	{
                            ?>
	                  <option value="<?php echo($row['id_prodotto'])?>"><?php echo($row['cod_prodotto'])?> </option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
                <tr>
	              <td  style="background:#ACA59D"><input type="radio" id="scegli_dizionario" name="scegli_dizionario" onclick="javascript:visualizzaDescriCodice();" value="DescriCodiceProdotto" />
	                Descrizione Codice</td>
	              <td  bgcolor="#FFFFFF"><div id="DescrizioneCodice" style="visibility:hidden;">
	                <select id="DescriCodiceProdotto" name="DescriCodiceProdotto">
	                  <?php
		                     $sql = mysql_query("SELECT *
													FROM 
														codice 
													WHERE 
														descrizione IS NOT NULL 
														AND 
														descrizione<>'' 
													ORDER BY descrizione") 
                                or die("Errore 102: " . mysql_error());
                        while($row=mysql_fetch_array($sql))
                            {
                            ?>
	                  <option value="<?php echo($row['id_codice'])?>"><?php echo($row['descrizione'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	            <tr>
	              <td  style="background:#ACA59D"><input type="radio" id="scegli_dizionario" name="scegli_dizionario" onclick="javascript:visualizzaNomeComponente();" value="NomeComponente" />
	                Nome Componente</td>
	              <td  bgcolor="#FFFFFF"><div id="Componente" style="visibility:hidden;">
	                <select id="NomeComponente" name="NomeComponente">
	                  <?php
		                     $sql = mysql_query("SELECT *
													FROM 
														parametro_comp_prod 
													WHERE 
														descri_comp IS NOT NULL 
														AND 
														descri_comp<>'' 
													ORDER BY descri_comp") 
                                or die("Errore 102: " . mysql_error());
                        while($row=mysql_fetch_array($sql))
                            {
                            ?>
	                  <option value="<?php echo($row['id_par_comp'])?>"><?php echo($row['descri_comp'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	            <tr>
	              <td  style="background:#ACA59D"><input type="radio" id="scegli_dizionario" name="scegli_dizionario" onclick="javascript:visualizzaNomeColoreBase();" value="NomeColoreBase"/>
	                Nome Colore Base</td>
	              <td  bgcolor="#FFFFFF"><div id="ColoreBase" style="visibility:hidden;">
	                <select id="NomeColoreBase" name="NomeColoreBase">
	                  <?php
                    $sql = mysql_query("SELECT *
												FROM 
													colore_base 
												WHERE 
													nome_colore_base IS NOT NULL 
													AND 
													nome_colore_base<>''
												ORDER BY 
													nome_colore_base") 
                            or die("Errore 103: " . mysql_error());
                    while($row=mysql_fetch_array($sql))
                        {
                        ?>
	                  <option value="<?php echo($row['id_colore_base'])?>"><?php echo($row['nome_colore_base'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	            <tr>
	              <td  style="background:#ACA59D"><input type="radio" id="scegli_dizionario" name="scegli_dizionario" onclick="javascript:visualizzaMessaggioMacchina();" value="MessaggioMacchina" />
	                Messaggio Macchina</td>
	              <td  bgcolor="#FFFFFF"><div id="Messaggio" style="visibility:hidden;">
	                <select id="MessaggioMacchina" name="MessaggioMacchina">
	                  <?php
                        $sql = mysql_query("SELECT *
													FROM 
														messaggio_macchina 
													WHERE 
														messaggio IS NOT NULL 
														AND 
														messaggio<>'' 
													ORDER BY 
														messaggio") 
                                or die("Errore 104: " . mysql_error());
                        while($row=mysql_fetch_array($sql))
                            {
                            ?>
	                  <option value="<?php echo($row['id_messaggio'])?>"><?php echo($row['messaggio'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	        </table>
<?php if ($TipoRiferimento=='Mondo'){?>
	<table width="100%">
	            <tr>
	              <td colspan="2"><div id="MSG">Seleziona una tipologia di riferimento geografico</div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC; "><input type="radio" id="scegli_geografico" name="scegli_geografico" 					 										onclick="javascript:visualizzaMondo();" value="Mondo" checked="checked"/> 
	                Mondo</td>
	              <td " bgcolor="#FFFFFF"><div id="Mondo">Riferimento MONDO</div></td>
                </tr>
	            <tr>
	              <td style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick=	       		"javascript:visualizzaContinente();" value="Continente" />
	                Continente</td>
	              <td bgcolor="#FFFFFF"><div id="Continente" style="visibility:hidden;">
	                <select id="NomeContinente" name="Continente">
	                  <?php 
							include('../Connessioni/serverdb.php');
                        	$sql = mysql_query("SELECT DISTINCT (continente) AS nome_continente 
														FROM 
															comune 
														WHERE 		   																			         													continente IS NOT NULL 
															AND 
															continente<>'' 
														ORDER BY continente") 
                                or die("Errore 101: " . mysql_error());
                        	while($row=mysql_fetch_array($sql))
                            	{
                            ?>
	                  <option value="<?php echo($row['nome_continente'])?>"><?php echo($row['nome_continente'])?> </option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaStato();" value="Stato" />
	                Stato</td>
	              <td  bgcolor="#FFFFFF"><div id="Stato" style="visibility:hidden;">
	                <select id="NomeStato" name="Stato">
	                 
					  <?php
                        $sql = mysql_query("SELECT DISTINCT(stato)AS nome_stato 
													FROM 
														comune 
													WHERE 
														stato IS NOT NULL 
														AND 
														stato<>'' 
													ORDER BY nome_stato") 
                                or die("Errore 102: " . mysql_error());
                        while($row=mysql_fetch_array($sql))
                            {
                            ?>
	                  <option value="<?php echo($row['nome_stato'])?>"><?php echo($row['nome_stato'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaRegione();" value="Regione"/>
	                Regione</td>
	              <td  bgcolor="#FFFFFF"><div id="Regione" style="visibility:hidden;">
	                <select id="NomeRegione" name="Regione">
	                  <?php
                    $sql = mysql_query("SELECT DISTINCT(regione)AS nome_regione 
												FROM 
													comune 
												WHERE 
													regione IS NOT NULL 
													AND 
													regione<>''
												ORDER BY 
													nome_regione") 
                            or die("Errore 103: " . mysql_error());
                    while($row=mysql_fetch_array($sql))
                        {
                        ?>
	                  <option value="<?php echo($row['nome_regione'])?>"><?php echo($row['nome_regione'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaProvincia();" value="Provincia" />
	                Provincia</td>
	              <td  bgcolor="#FFFFFF"><div id="Provincia" style="visibility:hidden;">
	                <select id="NomeProvincia" name="Provincia">
	                  <?php
                        $sql = mysql_query("SELECT DISTINCT(provincia)AS nome_provincia 
													FROM 
														comune 
													WHERE 
														provincia IS NOT NULL 
														AND 
														provincia<>'' 
													ORDER BY 
														nome_provincia") 
                                or die("Errore 104: " . mysql_error());
                        while($row=mysql_fetch_array($sql))
                            {
                            ?>
	                  <option value="<?php echo($row['nome_provincia'])?>"><?php echo($row['nome_provincia'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaComune();" value="Comune" />
	                Comune</td>
	              <td  bgcolor="#FFFFFF"><div id="Comune" style="visibility:hidden;">
	                <select id="NomeComune" name="Comune">
	                  <?php
                        $sql = mysql_query("SELECT DISTINCT(comune)AS nome_comune 
													FROM 
														comune 
													WHERE 
														comune IS NOT NULL 
														AND 
														comune<>'' 
													ORDER BY 
														nome_comune") 
                                or die("Errore 105: " . mysql_error());
                        while($row=mysql_fetch_array($sql))
                            {
                            ?>
	                  <option value="<?php echo($row['nome_comune'])?>"><?php echo($row['nome_comune'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
           </table>
           <?php }?>
           
<?php if ($TipoRiferimento=='Continente'){?>
	<table width="100%">
	            <tr>
	              <td colspan="2"><div id="MSG">Seleziona una tipologia di riferimento geografico</div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC; "><input type="radio" id="scegli_geografico" name="scegli_geografico" 					 										onclick="javascript:visualizzaMondo();" value="Mondo" /> 
	                Mondo</td>
	              <td " bgcolor="#FFFFFF"><div id="Mondo" style="visibility:hidden;">Riferimento MONDO</div></td>
                </tr>
	            <tr>
	              <td style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick=	       		"javascript:visualizzaContinente();" value="Continente" checked="checked"/>
	                Continente</td>
	              <td bgcolor="#FFFFFF"><div id="Continente" >
	                <select id="NomeContinente" name="Continente" >
	                 <option value="<?php echo $Geografico;?>" selected><?php echo $Geografico;?></option>
                      <?php 
							include('../Connessioni/serverdb.php');
                        	$sql = mysql_query("SELECT DISTINCT (continente) AS nome_continente 
														FROM 
															comune 
														WHERE 		   																			         													continente IS NOT NULL 
														AND 
															continente<>''
														AND continente<>'".$Geografico."'
														ORDER BY continente") 
                                or die("Errore 101: " . mysql_error());
                        	while($row=mysql_fetch_array($sql))
                            	{
                            ?>
	                  <option value="<?php echo($row['nome_continente'])?>"><?php echo($row['nome_continente'])?> </option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaStato();" value="Stato" />
	                Stato</td>
	              <td  bgcolor="#FFFFFF"><div id="Stato" style="visibility:hidden;">
	                <select id="NomeStato" name="Stato">
	                  <?php
                        $sql = mysql_query("SELECT DISTINCT(stato)AS nome_stato 
													FROM 
														comune 
													WHERE 
														stato IS NOT NULL 
														AND 
														stato<>'' 
													ORDER BY nome_stato") 
                                or die("Errore 102: " . mysql_error());
                        while($row=mysql_fetch_array($sql))
                            {
                            ?>
	                  <option value="<?php echo($row['nome_stato'])?>"><?php echo($row['nome_stato'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaRegione();" value="Regione"/>
	                Regione</td>
	              <td  bgcolor="#FFFFFF"><div id="Regione" style="visibility:hidden;">
	                <select id="NomeRegione" name="Regione">
	                  <?php
                    $sql = mysql_query("SELECT DISTINCT(regione)AS nome_regione 
												FROM 
													comune 
												WHERE 
													regione IS NOT NULL 
													AND 
													regione<>''
												ORDER BY 
													nome_regione") 
                            or die("Errore 103: " . mysql_error());
                    while($row=mysql_fetch_array($sql))
                        {
                        ?>
	                  <option value="<?php echo($row['nome_regione'])?>"><?php echo($row['nome_regione'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaProvincia();" value="Provincia" />
	                Provincia</td>
	              <td  bgcolor="#FFFFFF"><div id="Provincia" style="visibility:hidden;">
	                <select id="NomeProvincia" name="Provincia">
	                  <?php
                        $sql = mysql_query("SELECT DISTINCT(provincia)AS nome_provincia 
													FROM 
														comune 
													WHERE 
														provincia IS NOT NULL 
														AND 
														provincia<>'' 
													ORDER BY 
														nome_provincia") 
                                or die("Errore 104: " . mysql_error());
                        while($row=mysql_fetch_array($sql))
                            {
                            ?>
	                  <option value="<?php echo($row['nome_provincia'])?>"><?php echo($row['nome_provincia'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaComune();" value="Comune" />
	                Comune</td>
	              <td  bgcolor="#FFFFFF"><div id="Comune" style="visibility:hidden;">
	                <select id="NomeComune" name="Comune">
	                  <?php
                        $sql = mysql_query("SELECT DISTINCT(comune)AS nome_comune 
													FROM 
														comune 
													WHERE 
														comune IS NOT NULL 
														AND 
														comune<>'' 
													ORDER BY 
														nome_comune") 
                                or die("Errore 105: " . mysql_error());
                        while($row=mysql_fetch_array($sql))
                            {
                            ?>
	                  <option value="<?php echo($row['nome_comune'])?>"><?php echo($row['nome_comune'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
           </table>
           <?php }?>

<?php if ($TipoRiferimento=='Stato'){?>
	<table width="100%">
	            <tr>
	              <td colspan="2"><div id="MSG">Seleziona una tipologia di riferimento geografico</div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC; "><input type="radio" id="scegli_geografico" name="scegli_geografico" 					 										onclick="javascript:visualizzaMondo();" value="Mondo" > 
	                Mondo</td>
	              <td " bgcolor="#FFFFFF"><div id="Mondo" style="visibility:hidden;">Riferimento MONDO</div></td>
                </tr>
	            <tr>
	              <td style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick=	       		"javascript:visualizzaContinente();" value="Continente" />
	                Continente</td>
	              <td bgcolor="#FFFFFF"><div id="Continente" style="visibility:hidden;" >
	                <select id="NomeContinente" name="Continente" >
	                   	<?php 
							include('../Connessioni/serverdb.php');
                        	$sql = mysql_query("SELECT DISTINCT (continente) AS nome_continente 
														FROM 
															comune 
														WHERE 		   																			         													continente IS NOT NULL 
															AND 
															continente<>'' 
														ORDER BY continente") 
                                or die("Errore 101: " . mysql_error());
                        	while($row=mysql_fetch_array($sql))
                            	{
                            ?>
	                  <option value="<?php echo($row['nome_continente'])?>"><?php echo($row['nome_continente'])?> </option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaStato();" value="Stato" checked="checked"/>
	                Stato</td>
	              <td  bgcolor="#FFFFFF"><div id="Stato" >
	                <select id="NomeStato" name="Stato">
	                 <option value="<?php echo $Geografico;?>" selected><?php echo $Geografico;?></option> 
					 <?php
                        $sql = mysql_query("SELECT DISTINCT(stato)AS nome_stato 
													FROM 
														comune 
													WHERE 
														stato IS NOT NULL 
													AND 
														stato<>'' 
													AND
														stato<>'".$Geografico."'
													ORDER BY nome_stato") 
                                or die("Errore 102: " . mysql_error());
                        while($row=mysql_fetch_array($sql))
                            {
                            ?>
	                  <option value="<?php echo($row['nome_stato'])?>"><?php echo($row['nome_stato'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaRegione();" value="Regione"/>
	                Regione</td>
	              <td  bgcolor="#FFFFFF"><div id="Regione" style="visibility:hidden;">
	                <select id="NomeRegione" name="Regione">
	                  <?php
                    $sql = mysql_query("SELECT DISTINCT(regione)AS nome_regione 
												FROM 
													comune 
												WHERE 
													regione IS NOT NULL 
													AND 
													regione<>''
												ORDER BY 
													nome_regione") 
                            or die("Errore 103: " . mysql_error());
                    while($row=mysql_fetch_array($sql))
                        {
                        ?>
	                  <option value="<?php echo($row['nome_regione'])?>"><?php echo($row['nome_regione'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaProvincia();" value="Provincia" />
	                Provincia</td>
	              <td  bgcolor="#FFFFFF"><div id="Provincia" style="visibility:hidden;">
	                <select id="NomeProvincia" name="Provincia">
	                  <?php
                        $sql = mysql_query("SELECT DISTINCT(provincia)AS nome_provincia 
													FROM 
														comune 
													WHERE 
														provincia IS NOT NULL 
														AND 
														provincia<>'' 
													ORDER BY 
														nome_provincia") 
                                or die("Errore 104: " . mysql_error());
                        while($row=mysql_fetch_array($sql))
                            {
                            ?>
	                  <option value="<?php echo($row['nome_provincia'])?>"><?php echo($row['nome_provincia'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaComune();" value="Comune" />
	                Comune</td>
	              <td  bgcolor="#FFFFFF"><div id="Comune" style="visibility:hidden;">
	                <select id="NomeComune" name="Comune">
	                  <?php
                        $sql = mysql_query("SELECT DISTINCT(comune)AS nome_comune 
													FROM 
														comune 
													WHERE 
														comune IS NOT NULL 
														AND 
														comune<>'' 
													ORDER BY 
														nome_comune") 
                                or die("Errore 105: " . mysql_error());
                        while($row=mysql_fetch_array($sql))
                            {
                            ?>
	                  <option value="<?php echo($row['nome_comune'])?>"><?php echo($row['nome_comune'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
           </table>
           <?php }?>

<?php if ($TipoRiferimento=='Regione'){?>
	<table width="100%">
	            <tr>
	              <td colspan="2"><div id="MSG">Seleziona una tipologia di riferimento geografico</div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC; "><input type="radio" id="scegli_geografico" name="scegli_geografico" 					 										onclick="javascript:visualizzaMondo();" value="Mondo" > 
	                Mondo</td>
	              <td " bgcolor="#FFFFFF"><div id="Mondo" style="visibility:hidden;">Riferimento MONDO</div></td>
                </tr>
	            <tr>
	              <td style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick=	       		"javascript:visualizzaContinente();" value="Continente" />
	                Continente</td>
	              <td bgcolor="#FFFFFF"><div id="Continente" style="visibility:hidden;" >
	                <select id="NomeContinente" name="Continente" >
	                  <?php 
							include('../Connessioni/serverdb.php');
                        	$sql = mysql_query("SELECT DISTINCT (continente) AS nome_continente 
														FROM 
															comune 
														WHERE 		   																			         													continente IS NOT NULL 
															AND 
															continente<>'' 
														ORDER BY continente") 
                                or die("Errore 101: " . mysql_error());
                        	while($row=mysql_fetch_array($sql))
                            	{
                            ?>
	                  <option value="<?php echo($row['nome_continente'])?>"><?php echo($row['nome_continente'])?> </option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaStato();" value="Stato" />
	                Stato</td>
	              <td  bgcolor="#FFFFFF"><div id="Stato" style="visibility:hidden;" >
	                <select id="NomeStato" name="Stato">
	                  <?php
                        $sql = mysql_query("SELECT DISTINCT(stato)AS nome_stato 
													FROM 
														comune 
													WHERE 
														stato IS NOT NULL 
														AND 
														stato<>'' 
													ORDER BY nome_stato") 
                                or die("Errore 102: " . mysql_error());
                        while($row=mysql_fetch_array($sql))
                            {
                            ?>
	                  <option value="<?php echo($row['nome_stato'])?>"><?php echo($row['nome_stato'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaRegione();" value="Regione" checked="checked"/>
	                Regione</td>
	              <td  bgcolor="#FFFFFF"><div id="Regione" >
	                <select id="NomeRegione" name="Regione">
	                  <option value="<?php echo $Geografico;?>" selected><?php echo $Geografico;?></option>
					  <?php
                    $sql = mysql_query("SELECT DISTINCT(regione)AS nome_regione 
												FROM 
													comune 
												WHERE 
													regione IS NOT NULL 
												AND 
													regione<>''
												AND 
													regione<>'".$Geografico."'
												ORDER BY 
													nome_regione") 
                            or die("Errore 103: " . mysql_error());
                    while($row=mysql_fetch_array($sql))
                        {
                        ?>
	                  <option value="<?php echo($row['nome_regione'])?>"><?php echo($row['nome_regione'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaProvincia();" value="Provincia" />
	                Provincia</td>
	              <td  bgcolor="#FFFFFF"><div id="Provincia" style="visibility:hidden;">
	                <select id="NomeProvincia" name="Provincia">
	                  <?php
                        $sql = mysql_query("SELECT DISTINCT(provincia)AS nome_provincia 
													FROM 
														comune 
													WHERE 
														provincia IS NOT NULL 
														AND 
														provincia<>'' 
													ORDER BY 
														nome_provincia") 
                                or die("Errore 104: " . mysql_error());
                        while($row=mysql_fetch_array($sql))
                            {
                            ?>
	                  <option value="<?php echo($row['nome_provincia'])?>"><?php echo($row['nome_provincia'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaComune();" value="Comune" />
	                Comune</td>
	              <td  bgcolor="#FFFFFF"><div id="Comune" style="visibility:hidden;">
	                <select id="NomeComune" name="Comune">
	                  <?php
                        $sql = mysql_query("SELECT DISTINCT(comune)AS nome_comune 
													FROM 
														comune 
													WHERE 
														comune IS NOT NULL 
														AND 
														comune<>'' 
													ORDER BY 
														nome_comune") 
                                or die("Errore 105: " . mysql_error());
                        while($row=mysql_fetch_array($sql))
                            {
                            ?>
	                  <option value="<?php echo($row['nome_comune'])?>"><?php echo($row['nome_comune'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
           </table>
           <?php }?>
<?php if ($TipoRiferimento=='Provincia'){?>
	<table width="100%">
	            <tr>
	              <td colspan="2"><div id="MSG">Seleziona una tipologia di riferimento geografico</div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC; "><input type="radio" id="scegli_geografico" name="scegli_geografico" 					 										onclick="javascript:visualizzaMondo();" value="Mondo" > 
	                Mondo</td>
	              <td " bgcolor="#FFFFFF"><div id="Mondo" style="visibility:hidden;">Riferimento MONDO</div></td>
                </tr>
	            <tr>
	              <td style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick=	       		"javascript:visualizzaContinente();" value="Continente" />
	                Continente</td>
	              <td bgcolor="#FFFFFF"><div id="Continente" style="visibility:hidden;" >
	                <select id="NomeContinente" name="Continente" >
	                  <?php 
							include('../Connessioni/serverdb.php');
                        	$sql = mysql_query("SELECT DISTINCT (continente) AS nome_continente 
														FROM 
															comune 
														WHERE 		   																			         													continente IS NOT NULL 
															AND 
															continente<>'' 
														ORDER BY continente") 
                                or die("Errore 101: " . mysql_error());
                        	while($row=mysql_fetch_array($sql))
                            	{
                            ?>
	                  <option value="<?php echo($row['nome_continente'])?>"><?php echo($row['nome_continente'])?> </option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaStato();" value="Stato" />
	                Stato</td>
	              <td  bgcolor="#FFFFFF"><div id="Stato" style="visibility:hidden;" >
	                <select id="NomeStato" name="Stato">
	                  <?php
                        $sql = mysql_query("SELECT DISTINCT(stato)AS nome_stato 
													FROM 
														comune 
													WHERE 
														stato IS NOT NULL 
														AND 
														stato<>'' 
													ORDER BY nome_stato") 
                                or die("Errore 102: " . mysql_error());
                        while($row=mysql_fetch_array($sql))
                            {
                            ?>
	                  <option value="<?php echo($row['nome_stato'])?>"><?php echo($row['nome_stato'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaRegione();" value="Regione" />
	                Regione</td>
	              <td  bgcolor="#FFFFFF"><div id="Regione" style="visibility:hidden;">
	                <select id="NomeRegione" name="Regione">
	                  <?php
                    $sql = mysql_query("SELECT DISTINCT(regione)AS nome_regione 
												FROM 
													comune 
												WHERE 
													regione IS NOT NULL 
													AND 
													regione<>''
												ORDER BY 
													nome_regione") 
                            or die("Errore 103: " . mysql_error());
                    while($row=mysql_fetch_array($sql))
                        {
                        ?>
	                  <option value="<?php echo($row['nome_regione'])?>"><?php echo($row['nome_regione'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaProvincia();" value="Provincia" checked="checked"/>
	                Provincia</td>
	              <td  bgcolor="#FFFFFF"><div id="Provincia" >
	                <select id="NomeProvincia" name="Provincia">
	                 <option value="<?php echo $Geografico;?>" selected><?php echo $Geografico;?></option>
                     <?php
                        $sql = mysql_query("SELECT DISTINCT(provincia)AS nome_provincia 
													FROM 
														comune 
													WHERE 
														provincia IS NOT NULL 
													AND 
														provincia<>'' 
													AND
														provincia<>'".$Geografico."'
													ORDER BY 
														nome_provincia") 
                                or die("Errore 104: " . mysql_error());
                        while($row=mysql_fetch_array($sql))
                            {
                            ?>
	                  <option value="<?php echo($row['nome_provincia'])?>"><?php echo($row['nome_provincia'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaComune();" value="Comune" />
	                Comune</td>
	              <td  bgcolor="#FFFFFF"><div id="Comune" style="visibility:hidden;">
	                <select id="NomeComune" name="Comune">
	                  <?php
                        $sql = mysql_query("SELECT DISTINCT(comune)AS nome_comune 
													FROM 
														comune 
													WHERE 
														comune IS NOT NULL 
														AND 
														comune<>'' 
													ORDER BY 
														nome_comune") 
                                or die("Errore 105: " . mysql_error());
                        while($row=mysql_fetch_array($sql))
                            {
                            ?>
	                  <option value="<?php echo($row['nome_comune'])?>"><?php echo($row['nome_comune'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
           </table>
           <?php }?>
<?php if ($TipoRiferimento=='Comune'){?>
	<table width="100%">
	            <tr>
	              <td colspan="2"><div id="MSG">Seleziona una tipologia di riferimento geografico</div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC; "><input type="radio" id="scegli_geografico" name="scegli_geografico" 					 										onclick="javascript:visualizzaMondo();" value="Mondo" > 
	                Mondo</td>
	              <td " bgcolor="#FFFFFF"><div id="Mondo" style="visibility:hidden;">Riferimento MONDO</div></td>
                </tr>
	            <tr>
	              <td style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick=	       		"javascript:visualizzaContinente();" value="Continente" />
	                Continente</td>
	              <td bgcolor="#FFFFFF"><div id="Continente" style="visibility:hidden;" >
	                <select id="NomeContinente" name="Continente" >
	                  <?php 
							include('../Connessioni/serverdb.php');
                        	$sql = mysql_query("SELECT DISTINCT (continente) AS nome_continente 
														FROM 
															comune 
														WHERE 		   																			         													continente IS NOT NULL 
															AND 
															continente<>'' 
														ORDER BY continente") 
                                or die("Errore 101: " . mysql_error());
                        	while($row=mysql_fetch_array($sql))
                            	{
                            ?>
	                  <option value="<?php echo($row['nome_continente'])?>"><?php echo($row['nome_continente'])?> </option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaStato();" value="Stato" />
	                Stato</td>
	              <td  bgcolor="#FFFFFF"><div id="Stato" style="visibility:hidden;" >
	                <select id="NomeStato" name="Stato">
	                  <?php
                        $sql = mysql_query("SELECT DISTINCT(stato)AS nome_stato 
													FROM 
														comune 
													WHERE 
														stato IS NOT NULL 
														AND 
														stato<>'' 
													ORDER BY nome_stato") 
                                or die("Errore 102: " . mysql_error());
                        while($row=mysql_fetch_array($sql))
                            {
                            ?>
	                  <option value="<?php echo($row['nome_stato'])?>"><?php echo($row['nome_stato'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaRegione();" value="Regione" />
	                Regione</td>
	              <td  bgcolor="#FFFFFF"><div id="Regione" style="visibility:hidden;">
	                <select id="NomeRegione" name="Regione">
	                  <?php
                    $sql = mysql_query("SELECT DISTINCT(regione)AS nome_regione 
												FROM 
													comune 
												WHERE 
													regione IS NOT NULL 
													AND 
													regione<>''
												ORDER BY 
													nome_regione") 
                            or die("Errore 103: " . mysql_error());
                    while($row=mysql_fetch_array($sql))
                        {
                        ?>
	                  <option value="<?php echo($row['nome_regione'])?>"><?php echo($row['nome_regione'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaProvincia();" value="Provincia" />
	                Provincia</td>
	              <td  bgcolor="#FFFFFF"><div id="Provincia" style="visibility:hidden;" >
	                <select id="NomeProvincia" name="Provincia">
	                  <?php
                        $sql = mysql_query("SELECT DISTINCT(provincia)AS nome_provincia 
													FROM 
														comune 
													WHERE 
														provincia IS NOT NULL 
														AND 
														provincia<>'' 
													ORDER BY 
														nome_provincia") 
                                or die("Errore 104: " . mysql_error());
                        while($row=mysql_fetch_array($sql))
                            {
                            ?>
	                  <option value="<?php echo($row['nome_provincia'])?>"><?php echo($row['nome_provincia'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
	            <tr>
	              <td  style="background:#99CCCC"><input type="radio" id="scegli_geografico" name="scegli_geografico" onclick="javascript:visualizzaComune();" value="Comune" checked="checked"/>
	                Comune</td>
	              <td  bgcolor="#FFFFFF"><div id="Comune" >
	                <select id="NomeComune" name="Comune">
	                  <option value="<?php echo $Geografico;?>" selected><?php echo $Geografico;?></option>
					  <?php
                        $sql = mysql_query("SELECT DISTINCT(comune)AS nome_comune 
													FROM 
														comune 
													WHERE 
														comune IS NOT NULL 
													AND 
														comune<>'' 
													AND
														comune<>'".$Geografico."'
													ORDER BY 
														nome_comune") 
                                or die("Errore 105: " . mysql_error());
                        while($row=mysql_fetch_array($sql))
                            {
                            ?>
	                  <option value="<?php echo($row['nome_comune'])?>"><?php echo($row['nome_comune'])?></option>
	                  <?php }?>
	                  </select>
	                </div></td>
                </tr>
           </table>
           <?php }?>

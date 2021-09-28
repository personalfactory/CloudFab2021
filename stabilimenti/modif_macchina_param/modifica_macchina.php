<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="mainContainer">
            <?php
            include('../include/menu.php');
            include('../js/visualizza_elementi.js');
            include('../Connessioni/serverdb.php');
            include('../sql/script_valore_par_comp.php');
            include('../sql/script_valore_par_sing_mac.php');
            include('../sql/script_macchina.php');
            include('../sql/script_lingua.php');
            ?>
            <script language="javascript">
                function Modifica() {
                    document.forms["ModificaMacchina"].action = "modifica_macchina2.php";
                    document.forms["ModificaMacchina"].submit();
                }
                function Duplica() {/*DISABILITATA*/
                    document.forms["ModificaMacchina"].action = "duplica_macchina2.php";
                    document.forms["ModificaMacchina"].submit();
                }
            </script>

            <?php
            ini_set(display_errors, "1");
            $pagina = "modifica_macchina";

            //INIZIALIZZAZIONE VARIABILI
            $TipoRiferimento = "";
            $LivelloGruppo = "";
            $CodiceStabilimento = "";
            $DescrizioneStabilimento = "";
            $IdClienteGaz = 0;
            $Ragso1 = "";
            $IdLingua = 0;
            $UserOrigami = "";
            $PassOrigami = "";
            $ConfermaPassOrigami = "";
            $UserServer = "";
            $PassServer = "";
            $ConfermaPassServer = "";
            $UserFtp = "";
            $PassFtp = "";
            $ConfermaPassFtp = "";
            $PassZip = "";
            $ConfermaPassZip = "";
            $Abilitato = "";

            $IdMacchina = $_GET['Macchina'];

//Visualizzo il record che intendo modificare all'interno della form
//Estraggo i dati dello Stabilimento da modificare dalle tabelle [macchina] e [anagrafe_macchina]



            /*
              $sqlMacchina = mysql_query("SELECT
              macchina.id_macchina,
              macchina.cod_stab,
              macchina.descri_stab,
              macchina.ragso1,
              anagrafe_macchina.id_cliente_gaz,
              anagrafe_macchina.geografico,
              anagrafe_macchina.tipo_riferimento,
              anagrafe_macchina.gruppo,
              anagrafe_macchina.livello_gruppo,
              anagrafe_macchina.id_lingua,
              lingua.lingua,
              macchina.user_origami,
              macchina.user_server,
              macchina.pass_origami,
              macchina.pass_server,
              macchina.ftp_user,
              macchina.ftp_password,
              macchina.zip_password,
              macchina.abilitato,
              macchina.dt_abilitato
              FROM
              macchina
              LEFT JOIN anagrafe_macchina
              ON
              macchina.id_macchina = anagrafe_macchina.id_macchina
              LEFT JOIN lingua
              ON
              anagrafe_macchina.id_lingua = lingua.id_lingua
              WHERE
              macchina.id_macchina=" . $IdMacchina)
              or die("Query 1fallita: " . mysql_error());
             */

            $sqlMacchina = selectMacchinaLeftJoinById($IdMacchina);

            while ($rowMacchina = mysql_fetch_array($sqlMacchina)) {
                $CodiceStab = $rowMacchina['cod_stab'];
                $DescriStab = $rowMacchina['descri_stab'];
                $Ragso1 = $rowMacchina['ragso1'];
                $IdClienteGaz = $rowMacchina['id_cliente_gaz'];
                $Geografico = $rowMacchina['geografico'];
                $TipoRiferimento = $rowMacchina['tipo_riferimento'];
                $Gruppo = $rowMacchina['gruppo'];
                $LivelloGruppo = $rowMacchina['livello_gruppo'];
                $IdLingua = $rowMacchina['id_lingua'];
                $Lingua = $rowMacchina['lingua'];
                $UserOrigami = $rowMacchina['user_origami'];
                $PassOrigami = $rowMacchina['pass_origami'];
                $UserServer = $rowMacchina['user_server'];
                $PassServer = $rowMacchina['pass_server'];
                $UserFtp = $rowMacchina['ftp_user'];
                $PassFtp = $rowMacchina['ftp_password'];
                $PassZip = $rowMacchina['zip_password'];
                $Abilitato = $rowMacchina['abilitato'];
                $Data = $rowMacchina['dt_abilitato'];
            }
            ?>

            <div id="container" style="width:768px; margin:15px auto;">
                <form id="ModificaMacchina" name="ModificaMacchina" method="post" >
                    <table width="768" >


                        <tr>
                            <td height="42" colspan="2" class="cella3"><?php echo $titoloPaginaModStab ?></td>
                        </tr>
                        <tr>
                            <td width="200" class="cella2"><?php echo $filtroIdMacchina ?></td>
                            <td width="529" class="cella1">
                                <input type="hidden" name="IdMacchina" id="IdMacchina" value="<?php echo $IdMacchina; ?>" ><?php echo $IdMacchina; ?></input></td>
                        </tr>
                        <tr>
                            <td width="200" class="cella2"><?php echo $filtroCodice ?></td>
                            <td width="529" class="cella1"><input name="CodiceStab" type="text" id="CodiceStab" minlength="8" value="<?php echo $CodiceStab; ?>"></input></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDescrizione ?></td>
                            <td class="cella1"><input type="text" name="DescriStab" id="DescriStab" value="<?php echo $DescriStab; ?>" size="50px" ></input></td>
                        </tr>
                        <tr>
                            <td width="200" class="cella2"><?php echo $filtroRagioneSociale ?></td>
                            <td width="529" class="cella1"><input type="text" name="Ragso1" id="Ragso1" size="50px" value="<?php echo $Ragso1; ?>"></input></td>
                        </tr>
                        <tr>
                            <td width="200" class="cella2"><?php echo $filtroIdClienteGazie ?></td>
                            <td width="529" class="cella1"><input type="text" name="IdClienteGaz" id="IdClienteGaz" value="<?php echo $IdClienteGaz; ?>"></input></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroLingua ?></td>
                            <td class="cella1">
                                <select name="Lingua" id="Lingua">
                                    <option value="<?php echo $IdLingua; ?>" selected=""><?php echo $Lingua; ?></option>
                                    <?php
                                    /*
                                      $sql = mysql_query("SELECT * FROM lingua WHERE
                                      lingua <>'" . $Lingua . "'ORDER BY lingua")
                                      or die("Errore 113: " . mysql_error());
                                     */
                                    $sql = findAltreLingue($Lingua);

                                    while ($row = mysql_fetch_array($sql)) {
                                        ?>
                                        <option value="<?php echo($row['id_lingua']) ?>"><?php echo($row['lingua']) ?></option>
<?php } ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroGeografico ?></td>
                            <td class="cella11"><?php include('./moduli/visualizza_form_modifica_geografico.php'); ?></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroGruppoAcquisto ?></td>
                            <td class="cella11"><?php include('./moduli/visualizza_form_modifica_gruppo.php'); ?></td>
                        </tr>

                        <tr>
                            <td class="cella2"><?php echo $filtroOrigamiDb ?></td>
                            <td class="cella1">
                                <table width="100%">
                                    <tr>
                                        <td class="cella11"><?php echo $filtroUserName ?></td>
                                        <td class="cella1"><input type="text" name="UserOrigami" id="UserOrigami" value="<?php echo $UserOrigami; ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="cella11"><?php echo $filtroPassword ?></td>
                                        <td class="cella1"><input type="password" name="PassOrigami" id="PassOrigami" value="<?php echo $PassOrigami; ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="cella11"><?php echo $filtroConferma . " " . $filtroPassword ?></td>
                                        <td class="cella1"><input type="password" name="ConfermaPassOrigami" id="ConfermaPassOrigami" value="<?php echo $PassOrigami; ?>" /></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroServerdb ?></td>
                            <td class="cella1">
                                <table width="100%">
                                    <tr>
                                        <td class="cella11"><?php echo $filtroUserName ?></td>
                                        <td class=" cella1"><input type="text" name="UserServer" id="UserServer" value="<?php echo $UserServer; ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="cella11"><?php echo $filtroPassword ?></td>
                                        <td class="cella1"><input type="password" name="PassServer" id="PassServer" value="<?php echo $PassServer; ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="cella11"><?php echo $filtroConferma . " " . $filtroPassword ?></td>
                                        <td class="cella1"><input type="password" name="ConfermaPassServer" id="ConfermaPassServer" value="<?php echo $PassServer; ?>"/></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroServerFtp ?></td>
                            <td class="cella1">
                                <table width="100%">
                                    <tr>
                                        <td class="cella11"><?php echo $filtroUserName ?></td>
                                        <td class=" cella1"><input type="text" name="UserFtp" id="UserFtp" value="<?php echo $UserFtp; ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="cella11"><?php echo $filtroPassword ?></td>
                                        <td class="cella1"><input type="password" name="PassFtp" id="PassFtp" value="<?php echo $PassFtp; ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="cella11"><?php echo $filtroConferma . " " . $filtroPassword ?></td>
                                        <td class="cella1"><input type="password" name="ConfermaPassFtp" id="ConfermaPassFtp" value="<?php echo $PassFtp; ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="cella11"><?php echo $filtroZipPassword ?></td>
                                        <td class="cella1"><input type="password" name="PassZip" id="PassZip" value="<?php echo $PassZip; ?>"/></td>
                                    </tr>
                                    <tr>
                                        <td class="cella11"><?php echo $filtroConferma . " " . $filtroPassword ?></td>
                                        <td class="cella1"><input type="password" name="ConfermaPassZip" id="ConfermaPassZip" value="<?php echo $PassZip; ?>"/></td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroAbilitato; ?></td>
                            <td class="cella1"><input type="text" name="Abilitato" id="Abilitato" value="<?php echo $Abilitato; ?>"/></td>
                        </tr>
                        <tr>
                            <td class="cella2"><?php echo $filtroDtAbilitato; ?></td>
                            <td class="cella1"><?php echo $Data; ?></td>
                        </tr>
                    </table> 

                    <?php
//Estraggo i dati dei parametri singola macchina da modificare dalla tab [valore_par_sing_macchina]
                    $NPar = 1;
                    /*
                      $sqlParametro = mysql_query("SELECT
                      valore_par_sing_mac.id_val_par_sm,
                      valore_par_sing_mac.id_par_sm,
                      parametro_sing_mac.nome_variabile,
                      parametro_sing_mac.descri_variabile,
                      valore_par_sing_mac.valore_variabile
                      FROM
                      valore_par_sing_mac
                      LEFT JOIN macchina
                      ON
                      valore_par_sing_mac.id_macchina = macchina.id_macchina
                      LEFT JOIN parametro_sing_mac
                      ON
                      valore_par_sing_mac.id_par_sm = parametro_sing_mac.id_par_sm
                      WHERE
                      valore_par_sing_mac.id_macchina=" . $IdMacchina . "
                      ORDER BY
                      parametro_sing_mac.id_par_sm")
                      or die("Query 2 fallita: " . mysql_error());
                     */
                    $sqlParametro = selectValoreParSMLeftJoinParamById($IdMacchina);

                    if (mysql_num_rows($sqlParametro) > 0) {
                        ?>

                        <table width="768" >  
                            <tr>
                                <td  colspan="4" class="cella3"><?php echo $titoloPaginaGestioneParSm ?></td>
                            </tr>
                            <tr>
                                <td   class="cella3"> <?php echo $filtroId; ?> </td>
                                <td   class="cella3"> <?php echo $filtroPar; ?> </td>
                                <td   class="cella3"> <?php echo $filtroValore; ?> </td>
                            </tr>	
                            <?php
                        }

                        while ($rowParametro = mysql_fetch_array($sqlParametro)) {
                            ?>

                            <tr>
                                <td class="cella4"><?php echo($rowParametro['id_par_sm']); ?></td>
                                <td class="cella4" title="<?php echo($rowParametro['descri_variabile']); ?>">
    <?php echo($rowParametro['nome_variabile']); ?></td>
                                <td class="cella1"><input type="text" name="Valore<?php echo($NPar); ?>" id="Valore<?php echo($NPar); ?>" 
                                                          value="<?php echo($rowParametro['valore_variabile']); ?>"/>
                                </td>
                            </tr>
                            <?php
                            $NPar++;
                        }//end while fine parametri
                        ?>

                    </table>

                    <?php
                    //######################################################################
                    //################### PARAMETRI COMPONENTI PROD  #######################
                    //######################################################################
                    //Estraggo, dalla tab parametro_comp_prod 
                    //l'elenco dei parametri da visualizzare con il loro valore base eventualmente da modificare 
                    $NParCp = 1;
                    $NComp = 1;
                    /*
                      $sqlParametroCp = mysql_query("SELECT
                      valore_par_comp.id_par_comp,
                      parametro_comp_prod.nome_variabile,
                      parametro_comp_prod.descri_variabile
                      FROM
                      serverdb.valore_par_comp
                      INNER JOIN serverdb.macchina
                      ON
                      valore_par_comp.id_macchina = macchina.id_macchina
                      INNER JOIN serverdb.parametro_comp_prod
                      ON
                      valore_par_comp.id_par_comp = parametro_comp_prod.id_par_comp
                      WHERE
                      valore_par_comp.id_macchina=" . $IdMacchina . "
                      GROUP BY
                      valore_par_comp.id_par_comp
                      ORDER BY
                      parametro_comp_prod.id_par_comp")
                      or die("ERRORE 3 : SELECT FROM serverdb.valore_par_comp  " . mysql_error());
                     */
                    $sqlParametroCp = selectValoreParCompInnerJoinParamById($IdMacchina);

                    if (mysql_num_rows($sqlParametroCp) > 0) {
                        ?>
                        <table width="768" >  
                            <tr>
                                <td  colspan="4" class="cella3"><?php echo $titoloPaginaModificaValParComp ?></td>
                            </tr>
                            <tr>
                                <td   class="cella3"> <?php echo $filtroId; ?> </td>
                                <td   class="cella3"> <?php echo $filtroPar; ?> </td>
                                <td   class="cella3"> <?php echo $filtroComponente; ?> </td>
                                <td   class="cella3"> <?php echo $filtroValore; ?> </td>
                            </tr>
                            <?php
                        }
                        while ($rowParametroCp = mysql_fetch_array($sqlParametroCp)) {
                            ?>
                            <input type="hidden" name="IdParComp<?php echo($NParCp); ?>" id="IdParComp<?php echo($NParCp); ?>" value="<?php echo($rowParametroCp['id_par_comp']); ?>"/>
                            <?php
                            //##################### CICLO COMPONENTI #########################
                            /*
                              $sqlComp = mysql_query("SELECT
                              componente.id_comp,
                              componente.descri_componente,
                              valore_par_comp.valore_variabile
                              FROM
                              serverdb.valore_par_comp
                              INNER JOIN serverdb.macchina
                              ON
                              valore_par_comp.id_macchina = macchina.id_macchina
                              INNER JOIN serverdb.componente
                              ON
                              valore_par_comp.id_comp = componente.id_comp
                              WHERE
                              valore_par_comp.id_macchina=" . $IdMacchina . "
                              AND
                              valore_par_comp.id_par_comp=" . $rowParametroCp['id_par_comp'] . "
                              ORDER BY
                              componente.descri_componente")
                              or die("ERRORE 4: SELECT FROM componente  " . mysql_error());
                             */
                            $sqlComp = selectValoreParCompInnerJoinComponenteById($IdMacchina, $rowParametroCp['id_par_comp']);

                            while ($rowComp = mysql_fetch_array($sqlComp)) {
                                ?>
                                <tr>
                                    <td class="cella4"><?php echo($rowParametroCp['id_par_comp']); ?></td> 
                                    <td class="cella4" title="<?php echo($rowParametroCp['descri_variabile']); ?>"><?php echo($rowParametroCp['nome_variabile']); ?></td>
                                    <td class="cella4"><?php echo($rowComp['descri_componente']); ?></td>
                                    <td class="cella1"><input type="text" name="ValoreComp<?php echo($NComp); ?>" id="ValoreComp<?php echo($NComp); ?>" value="<?php echo($rowComp['valore_variabile']); ?>"/></td>
                                </tr>
                                <?php
                                $NComp++;
                            }
                            $NParCp++;
                        }//end while fine parametri singola macchina 
                        ?>



                        <tr>
                            <!--FUNZIONE DISABILITATA MA FUNZIONANTE
                              <td><input type="button" name="Aggiungi" title="Aggiungi un Parametro" id="Aggiungi" value="Aggiungi un Parametro" onClick="location.href='aggiungi_parsm_macchina.php?IdMacchina=<?php echo $IdMacchina; ?>'"/></td>-->
                            <td class="cella2" style="text-align: right " colspan="4">

                                <input type="reset" value="<?php echo $valueButtonAnnulla ?>" onClick="javascript:history.back();"/>
                                <input type="button" onclick="javascript:Modifica();" value="<?php echo $valueButtonSalva ?>" />
                                <!--Funzione di duplicazione dello stabilimento DISABILITATA (DA RIVEDERE)
                                <input type="button" onclick="javascript:Duplica();" value="Duplica" />-->
                            </td>
                        </tr>
                    </table>
                </form>
            </div>

        </div><!--mainContainer-->

    </body>
</html>

<?php

//##############################################################################
//###################### MENU GENERATO DINAMICAMENTE ###########################
//##############################################################################

    ?>

    <div id="bar">
        <table  cellspacing="0" cellpadding="0" id="menu1" class="XulMenu">
     
            <tr>
                <td>
                    <a class="button" href="../index.php"><?php echo $labelMenuHome ?></a>
                </td>
              <?php
               //Recupero l'oggetto menù dalla sessione
               $objectMenu= $_SESSION['objectMenuUtente'];

               $arrayModuliMenu=array();
               $arrayModuliMenu=$objectMenu->getArrayModuli();
               
               
               ///Scorro i moduli
              for($i=0; $i<count($arrayModuliMenu); $i++)
               {
                   $moduloObject = $arrayModuliMenu[$i];
                   $nomeVariabileLinguaModulo=$moduloObject->getNomeVariabileLingua();
                   $nomeModulo="{${$nomeVariabileLinguaModulo}}";

                   ?>

                 <td>
                   <a class="button" href="javascript:void(0)"><?php echo $nomeModulo ?></a>

                   <div class="section" >

                     <?php

                     ////////////////////////////////////////////////////////////////////////
                     //Recupero del valore della varibile modulo, voce, sottovoce in lingua
                    /* $var ="labelMenuElencoProd";
                     $labelMenuElencoProd = "ELENCO DEI PRODOTTI";
                     echo "Il contenuto della variabile {$var} è {${$var}} ";*/
                     ////////////////////////////////////////////////////////////////////////

                     //Recupero array di voci per modulo e le scorro
                     $arrayDiVoci=$moduloObject->getArrayVoci();
                     for($j=0; $j<count($arrayDiVoci); $j++)
                     {

                         $voceObject=$arrayDiVoci[$j];
                         $linkVoce=$voceObject->getLinkVoce();
                         $nomeVariabileLinguaVoce=$voceObject->getNomeVariabileLingua();

                        $nomeVoce="{${$nomeVariabileLinguaVoce}}";
                     ?>

                         <a class="item" href=../<?php echo $linkVoce ?> ><?php echo $nomeVoce ?>
                             <?php if($voceObject->sottovoce())
                             {
                             ?>
                                 <img class="arrow" src="../images/arrow1.gif" width="4" height="7" title="" id="menu1-6-3-arrow">

                             <?php }   ?>
                         </a>

                         <!--
                         ////////////////////////////////////////////////////////////////////////
                         alternativamente posso usare questa sintassi:
                          <?php //echo '<a href="' . $folder_path . '"> $nomeVoce</a>'; ?>
                         ///////////////////////////////////////////////////////////////////////
                         -->
                         <?php

                         //Controllo che ci siano sottovoci
                         if($voceObject->sottovoce())
                         {
                          ?>
                             <div class="section" >

                                  <?php
                               //Recupero array di sottovoci per voce e le scorro
                               $arrayDiSottoVoci=$voceObject->getArraySottoVoci();

                               for($x=0; $x<count($arrayDiSottoVoci); $x++)
                               {
                                   $sottoVoceObject = $arrayDiSottoVoci[$x];
                                   $linkSottoVoce=$sottoVoceObject->getLinkSottoVoce();
                                   $nomeVariabileLinguaSottoVoce=$sottoVoceObject->getNomeVariabileLingua();

                                   $nomeSottoVoce="{${$nomeVariabileLinguaSottoVoce}}";
                                ?>

                                   <a class="item" href=../<?php echo $linkSottoVoce ?>><?php echo $nomeSottoVoce ?></a>

                                <?php
                                }//For sottovoci
                                ?>

                              </div>

                          <?php

                          }//if se ci sono sottovoci
                          ?>


                     <?php
                     }//For voci*/
                     ?>

                   </div>

                 </td>

               <?php
               }//For moduli
               ?>

                <td>
                    <a class="button" href="javascript:void(0)"><?php echo $labelMenuEsci ?></a>
                    <div class="section">
                        <a class="item" href="../logout.php"><?php echo $labelMenuLogout ?></a>
                    </div>
                </td>
            </tr>

        </table>

    </div>
    <script type="text/javascript">
        var menu1 = new XulMenu("menu1");
        menu1.init();
    </script>
<?php

?>


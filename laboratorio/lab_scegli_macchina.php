
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html>
    <?php include('../include/validator.php'); ?>
    <head>
        <?php include('../include/header.php'); ?>
    </head>
    <body>
        <div id="labContainer" >
            <?php
            ini_set("display_errors", "1");
            include('../include/menu.php');
            include('../include/precisione.php');
            include('../Connessioni/serverdb.php');
            include('sql/script.php');
            include('sql/script_lab_macchina.php');
            
            $Redirect='';
            if(isSet($_GET['Redirect'])){
            $Redirect = $_GET['Redirect'];            
            } 
            $strUtentiAziende = getStrUtAzVisib($_SESSION['objPermessiVis'], 'lab_macchina'); 
            $sqlLabMacchina = findAllRosetteByStato($valRosetLibera, "nome",$strUtentiAziende);

            if (!isset($_POST['Macchina']) OR $_POST['Macchina'] == "") {
                ?>
                <div style="width:500px;height:400px;margin: 100px auto">
                    <form id="ScegliLabMacchina" name="ScegliLabMacchina" method="post" action="lab_scegli_macchina.php">
                        <table class="table2">  
                            <input type='hidden' name='Redirect' value='<?php echo $Redirect ?>'/>
                            <tr>
                                <th class="cella3" ><?php echo $filtroLabSceltaBilance ?></th>
                            </tr>
                            <tr>

                                <td class="cella2" style="text-align: center ">
                                    <select style="width:400px" name="Macchina" id="Macchina">
                                        <option value="" selected="selected" ><?php echo $labelOptionSelectRosetta ?></option>
                                        <?php
                                        while ($rowLabMacchina = mysql_fetch_array($sqlLabMacchina)) {
                                            ?>
                                            <option value="<?php echo ($rowLabMacchina['id_lab_macchina']) ?>"><?php echo ($rowLabMacchina['nome']); ?></option>
                                            <?php
                                        }
                                        ?>
                                    </select> 
                                </td>
                            </tr> 
                            <tr >
                                <td class="cella2" style="text-align: right "><input type="submit" value="<?php echo $valueButtonConferma ?>" /></td>
                            </tr>
                        </table>
                    </form>
                </div>
                <?php
            } else {
                         
                $updateRosetta = true;
                $saveUser=true;                
                $Redirect = $_POST['Redirect'];       

                //Si rende impegnata la macchina che si vuole usare ponendo 
                //uguale a zero il campo disponibile 
                begin();
                $updateRosetta = modificaStatoRosetta($_POST['Macchina'], $valRosetImp);
                $saveUser=modificaUtenteMacchina($_POST['Macchina'],$_SESSION['username']);

                if (!$updateRosetta OR !$saveUser) {
                    
                    rollback();
                    echo "</br>" . $msgTransazioneFallita."! ". '<a href="gestione_lab_esperimenti.php"> '.$valueButtonIndietro.'</a>';
                
                } else {
                    //Si modifica la variabile di sessione che tiene memoria dell'id della rosetta
                    $_SESSION['lab_macchina'] = $_POST['Macchina'];
                    commit();
                    ?>
                    <script type="text/javascript">
                        location.href = "<?php echo $Redirect ?>";
                    </script>
                    <?php
                }
            }
            ?>



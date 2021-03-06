<?php

 /*************************************************************************
 ***  Systém pro TME/TH2E - TMEP                                        ***
 ***  (c) Michal Ševčík 2007-2014 - multi@tricker.cz                    ***
 *************************************************************************/

 //////////////////////////////////////////////////////////////////////////
 //// VLOZENI SOUBORU
 //////////////////////////////////////////////////////////////////////////

  require "./config.php";         // skript s nastavenim
  require "./scripts/db.php";        // skript s databazi
  require "./scripts/fce.php";       // skript s nekolika funkcemi

 //////////////////////////////////////////////////////////////////////////
 //// ZAPIS DO DATABAZE ANEB VLOZENI HODNOTY Z TME
 //////////////////////////////////////////////////////////////////////////

  // pokud stranku vola teplomer, ulozime hodnotu
  if(isset($_GET['temp']) OR isset($_GET[$GUID]) OR isset($_GET['tempV']))
  {

    // novejsi TME
    if(isset($_GET['temp']) && $_GET['temp'] != ""){ $teplota = $_GET['temp']; }

    // stary TME
    if(isset($_GET[$GUID]) && $_GET[$GUID] != ""){ $teplota = $_GET[$GUID]; }

    // TH2E
    if(isset($_GET['tempV']) AND $_GET['tempV'] != "")
    { $teplota = $_GET['tempV']; if(strlen($_GET['humV']) < 7){ $vlhkost = $_GET['humV']; } }

    // nahrazeni carky teckou
    $teplota = str_replace(",", ".", $teplota);
    $vlhkost = str_replace(",", ".", $vlhkost);

    if(is_numeric($teplota))
    {

      // vlhkost je null?
      if(!is_numeric($vlhkost)){ $vlhkost = "null"; }


      // kontrolujeme IP a sedi
      if(isset($ip) AND $ip != "" AND $ip == $_SERVER['REMOTE_ADDR'])
      {
        MySQLi_query($GLOBALS["DBC"], "INSERT INTO tme(kdy, teplota, vlhkost) VALUES(now(), '{$teplota}', {$vlhkost})");
      }
      // nekontrolujeme IP
      elseif($ip == "")
      {
        MySQLi_query($GLOBALS["DBC"], "INSERT INTO tme(kdy, teplota, vlhkost) VALUES(now(), '{$teplota}', {$vlhkost})");
        print mysqli_error($GLOBALS["DBC"]);
      }
      // problem? zrejme pozadavek z jine nez z povolene IP
      else
      {
        echo "Chyba! Error! Fehler!";
      }

    }
    else
    {
      echo "Teplota musí být číslo...";
    }

  }
  // nezapisujeme, tak zobrazime stranku
  else
  {

 //////////////////////////////////////////////////////////////////////////
 //// DOPOCITANI HODNOT PRO MINULE DNY
 //////////////////////////////////////////////////////////////////////////

  // inicializace promenne, abych vedel jestli zobrazovat info
  // o dopocitanych dnech pri primem zavolani skriptu
  $dopocitat = 1;
  include_once "./scripts/dopocitat.php";

 //////////////////////////////////////////////////////////////////////////
 //// JAZYK A JEDNOTKA
 //////////////////////////////////////////////////////////////////////////

  require_once "scripts/variableCheck.php";

 //////////////////////////////////////////////////////////////////////////
 //// NACTENI ZAKLADNICH HODNOT NEJEN PRO HLAVICKU
 //////////////////////////////////////////////////////////////////////////

  include_once "./scripts/initIndex.php";

 //////////////////////////////////////////////////////////////////////////
 //// STRANKA
 //////////////////////////////////////////////////////////////////////////

?>
<!DOCTYPE html>
<html>

  <head>
    <title><?php echo $lang['titulekstranky']; ?></title>
    <meta HTTP-EQUIV="content-type" CONTENT="text/html; charset=UTF-8">
    <link rel="stylesheet" href="css/css.css" type="text/css">
    <meta NAME="description" CONTENT="<?php echo $lang['popisstranky']; ?>">
    <?php if($obnoveniStranky != 0 and  is_numeric($obnoveniStranky)){ echo '    <meta http-equiv="refresh" content="'.$obnoveniStranky.'">'; } ?>
    <meta NAME="author" CONTENT="Michal Ševčík (http://multi.tricker.cz), František Ševčík (f.sevcik@seznam.cz)">
    <meta name="viewport" content="width=device-width, maximum-scale=1, initial-scale=1, user-scalable=0">
    <script src="scripts/js/jquery.tools.ui.timer.colorbox.tmep.highcharts.js" type="text/javascript"></script>
    <script type="text/javascript">
    $(document).ready(function(){
     // po urcitem case AJAXove nacteni hodnot
     $.timer(60000, function (timer) {
       $.get('scripts/ajax/teplota.php<?php echo "?ja={$l}&je={$u}"; ?>', function(data) { $('.ajaxrefresh').html(data); });
       $.get('scripts/ajax/pocet-mereni.php', function(data) { $('.pocetmereni').html(data); });
      });
     $.timer(120000, function (timer) {
       $.get('scripts/ajax/drive-touto-dobou.php<?php echo "?ja={$l}&je={$u}"; ?>', function(data) { $('.drivetoutodobouted').html(data); $('a.modal').colorbox({iframe:true, width: "890px", height: "80%"}); });
      });
     // jQuery UI - datepicker
     $("#jenden").datepicker($.datepicker.regional[ "<?php echo $l;  ?>" ]);
     $.datepicker.setDefaults({dateFormat: "yy-mm-dd", maxDate: -1, minDate: new Date(<?php echo substr($pocetMereni['kdy'], 0, 4).", ".(substr($pocetMereni['kdy'], 5, 2)-1).", ".substr($pocetMereni['kdy'], 8, 2); ?>), changeMonth: true, changeYear: true});
    });
    var loadingImage = '<p><img src="./images/loading.gif"></p>';
    function loadTab(tab){
      if($("#" + tab).html() == "")
      {
        $("#" + tab).html(loadingImage);
        $.get("scripts/tabs/" + tab + ".php<?php echo "?ja={$l}&je={$u}"; ?>", function(data) { $("#" + tab).html(data);});
      }
    }
    </script>
    <link rel="shortcut icon" href="images/favicon.ico">
  </head>

<body>

  <div id='hlavni' class="container">
    <?php

    // Hlavička
    require_once "./scripts/head.php";

    // Záložky
    echo "<div id=\"oblastzalozek\">
    <ul class=\"tabs\">
      <li><a href=\"#aktualne\">{$lang['aktualne']}</a></li>
      <li><a href=\"#denni\" onclick=\"loadTab('denni-statistiky');\">{$lang['dennistatistiky']}</a></li>
      <li><a href=\"#mesicni\" onclick=\"loadTab('mesicni-statistiky');\">{$lang['mesicnistatistiky']}</a></li>
      <li><a href=\"#rocni\" onclick=\"loadTab('rocni-statistiky');\">{$lang['rocnistatistiky']}</a></li>
      <li><a href=\"#historie\">{$lang['historie']}</a></li>
    </ul>

    <div class=\"panely\">";
      echo "<div id=\"aktualneTab\">"; require "scripts/tabs/aktualne.php"; echo "</div>";
      echo "<div id=\"denni-statistiky\"></div>";
      echo "<div id=\"mesicni-statistiky\"></div>";
      echo "<div id=\"rocni-statistiky\"></div>";
      echo "<div id=\"historieTab\">"; require "scripts/tabs/historie.php"; echo "</div>";
      echo "</div>
    </div>";

    // Patička
    echo "<div class='nohy'><p>{$lang['paticka']}</p></div>";

?>

  </div> <!-- konec hlavni -->

</body>
</html>
<?php
  } // konec pokud si stranku prohlizi uzivatel a nevola ji teplomer

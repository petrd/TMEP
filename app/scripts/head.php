<?php

  echo "<div class='hlava'"; if($zobrazitNastaveni == 0){ echo " style='height: 30px;'"; } echo "><h1>".$lang['hlavninadpis']."</h1>";

  if($zobrazitNastaveni == 1)
  {

  echo "<p>
          ".$lang['jazyk'].":
            <a href='{$_SERVER['PHP_SELF']}?ja=cz&amp;je={$_GET['je']}'><span class=\"vlajka\" title='CZ'></span></a>
            <a href='{$_SERVER['PHP_SELF']}?ja=sk&amp;je={$_GET['je']}'><span class=\"vlajka sk\" title='SK'></span></a>
            <a href='{$_SERVER['PHP_SELF']}?ja=en&amp;je={$_GET['je']}'><span class=\"vlajka en\" title='EN'></span></a>
            <a href='{$_SERVER['PHP_SELF']}?ja=de&amp;je={$_GET['je']}'><span class=\"vlajka de\" title='DE'></span></a>
            <a href='{$_SERVER['PHP_SELF']}?ja=ru&amp;je={$_GET['je']}'><span class=\"vlajka ru\" title='RU'></span></a>
            <a href='{$_SERVER['PHP_SELF']}?ja=pl&amp;je={$_GET['je']}'><span class=\"vlajka pl\" title='PL'></span></a>
            <a href='{$_SERVER['PHP_SELF']}?ja=fr&amp;je={$_GET['je']}'><span class=\"vlajka fr\" title='FR'></span></a>
            <a href='{$_SERVER['PHP_SELF']}?ja=fi&amp;je={$_GET['je']}'><span class=\"vlajka fi\" title='FI'></span></a>
            <a href='{$_SERVER['PHP_SELF']}?ja=sv&amp;je={$_GET['je']}'><span class=\"vlajka sv\" title='SV'></span></a> |
            {$lang['jednotka']}:
            <a href='{$_SERVER['PHP_SELF']}?je=C&amp;ja={$_GET['ja']}' title='Celsius'>Celsius</a>,
            <a href='{$_SERVER['PHP_SELF']}?je=F&amp;ja={$_GET['ja']}' title='Fahrenheit'>Fahrenheit</a>,
            <a href='{$_SERVER['PHP_SELF']}?je=K&amp;ja={$_GET['ja']}' title='Kelvin'>Kelvin</a>,
            <a href='{$_SERVER['PHP_SELF']}?je=R&amp;ja={$_GET['ja']}' title='Rankine'>Rankine</a>,
            <a href='{$_SERVER['PHP_SELF']}?je=D&amp;ja={$_GET['ja']}' title='Delisle'>Delisle</a>,
            <a href='{$_SERVER['PHP_SELF']}?je=N&amp;ja={$_GET['ja']}' title='Newton'>Newton</a>,
            <a href='{$_SERVER['PHP_SELF']}?je=Re&amp;ja={$_GET['ja']}' title='Reaumur'>Reaumur</a>,
            <a href='{$_SERVER['PHP_SELF']}?je=Ro&amp;ja={$_GET['ja']}' title='Romer'>Romer</a>
          </p>";

  }

  echo "</div>
  
        <div id='tri' class='row'>

        <div class='col-md-5 horniPrvni'>

          <table class='tabulkaVHlavicce'>
            <tr class='radek'>
              <td colspan='2'><b>{$lang['statistika']}</b></td>
            </tr>
            <tr>
              <td align='right'><b>{$lang['umisteni']}</b></td>
              <td>{$umisteni}</td>
            </tr>
            <tr>
              <td align='right'><a href='./scripts/modals/pocetMereni.php?je={$_GET['je']}&amp;ja={$_GET['ja']}' class='modal'><b>{$lang['pocetmereni']}</b> <img src='./images/nw.png' title='{$lang['pocetmereni']}'></a></td>
              <td><div class='pocetmereni'>".number_format($pocetMereni['pocet'], 0, "", " ")."</div></td>
            </tr>
            <tr>
              <td align='right'><b>{$lang['merenood']}:</b></td>
              <td>".formatData($pocetMereni['kdy'])."</td>
            </tr>
            <tr>
              <td align='right'><a href='./scripts/modals/nejTeploty.php?je={$_GET['je']}&amp;ja={$_GET['ja']}' class='modal'><b>{$lang['nejvyssiteplota']}: <img src='./images/nw.png' title='{$lang['nejvyssiteplota']}'></a></b></td>
              <td>".jednotkaTeploty($nejvyssi['teplota'], $u, 1)." - ".formatData($nejvyssi['kdy'])."</td>
            </tr>
            <tr>
              <td align='right'><a href='./scripts/modals/nejTeploty.php?je={$_GET['je']}&amp;ja={$_GET['ja']}' class='modal'><b>{$lang['nejnizsiteplota']}: <img src='./images/nw.png' title='{$lang['nejnizsiteplota']}'></a></b></td>
              <td>".jednotkaTeploty($nejnizsi['teplota'], $u, 1)." - ".formatData($nejnizsi['kdy'])."</td>
            </tr>
          </table>

        </div>

        <div class='col-md-3 horniDruhy'>

          <div class='drivetoutodobouted'>";
            require_once dirname(__FILE__)."/ajax/drive-touto-dobou.php";
          echo "</div>
         
        </div>

        <div class='col-md-3 horniTreti'>

        <div class='sloupekAktualne'>
        <div class='ajaxrefresh'>";
          require_once dirname(__FILE__)."/ajax/teplota.php";
        echo "</div>
              </div>
              </div>

        </div>";
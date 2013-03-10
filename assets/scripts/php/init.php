<?php
require_once('lib/rb.php');

R::setup('mysql:host=localhost;dbname=greenwaters', 'root', '');
$t = R::$toolbox;
$cachedOODB = new RedBean_Plugin_Cache($t->getWriter());
R::configureFacadeWithToolbox(new RedBean_Toolbox(
    $cachedOODB,
    $t->getDatabaseAdapter(),
    $t->getWriter()));
//R::freeze(true);

R::debug(false);

date_default_timezone_set('Europe/Lisbon');

session_start();

function using_ie()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $ub = False;
    if (preg_match('/MSIE/i', $u_agent)) {
        $ub = True;
    }

    return $ub;
}

function ie_box()
{
    if (using_ie()) {
        ?>
    <div class="chromeframe">
        Este site não foi desenhado para Intenet Explorer. Se quiser ver este site como é suposto, por favor utilize um
        browser que respeite as normas da Internet, tal como o <a href="http://www.google.com/chrome">Google Chrome</a>.
    </div>
    <?php
        return;
    }
}
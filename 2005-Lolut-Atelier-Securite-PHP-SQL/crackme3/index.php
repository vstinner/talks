<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Language" content="fr" />
  <link rel="stylesheet" type="text/css" media="screen" href="../style.css" />
  <title>Crackme #3</title>
</head>
<body>
<h1>Crackme #3</h1>
<?php
function ajoute_lien($prefix, $file)
{
    if ($prefix[0] == 'd') {
        $r = $GLOBALS['repertoire'];
        if ($file == '..')
            $r = ereg_replace('^(([^/]+/)+)[^/]+/?$', '\1', $r);
        else if ($file != '.')
            $r .= $file.'/';
        $url = 'index.php?r='.$r;
    } else {
        $url  = $GLOBALS['repertoire'];
        if ($url[strlen($url)-1] != '/') $url .= '/';
        $url .= rawurlencode($file);
    }
    return $prefix.'<a href="'.$url.'">'.$file.'</a>';
}

// Configure l'exercice
error_reporting(E_ALL);
$rootpath = '../';
$url_root = '../';
require_once($rootpath.'include/crackme_func.php');

// Lit le répertoire demandé, puis le vérifie
$repertoire = crackme_html_request('r');
if ($repertoire)
{
    // Interdit les repertoires parents
    if (!crackme_file_allowed($repertoire))
    {
        crackme_error("<p>Pas le droit au répertoire <em>$repertoire</em> (ou répertoire inexistant) !</p>");
        $repertoire = "./";
    }

    // Vérifie l'exploit :-)
    if (ereg("^([a-zA-Z0-9._/]+)( *(;+|&&|\|\|) *(.*))?$", $repertoire, $regs))
    {
        $exploit = $regs[4];
        $commande = $regs[4];
        if ($exploit != '')
        {
            if (!eregi("^uname( --?[a-z-]+)?$", $commande))
            {
                $msg  = "<p>Désolé, seule la commande <em>uname</em> est autorisée.</p>";
                $msg .= "<p>(commande détectée : «&nbsp;<em>$commande</em>&nbsp;»)</p>";
                crackme_error($msg);
                $repertoire = './';
            }
        }
    } else {
        $msg = "<p>Désolé mais le répertoire «&nbsp;<em>$repertoire</em>&nbsp;» ne semble pas valide.</p>";
        crackme_error($msg);
        $repertoire = './';
    }
} else {
    $repertoire = './';
}   

// Lit le contenu d'un repertoire
ob_start();
passthru("ls -lha 2>&1 $repertoire");
$ls = ob_get_contents();
ob_end_clean();

//---- Traite le résultat de ls ------

// Supprime "total ..."
$ls = explode("\n", $ls);
$out = "";
foreach ($ls as $ligne)
{
    if (ereg("^total", $ligne))
        continue;
    if ($repertoire == './' && ereg(" \.\.$", $ligne))
        continue;
    if (preg_match('/^(.*[0-9]{1,2} [0-9]{2}:[0-9]{2} )(.+)$/', $ligne, $regs))
        $ligne = ajoute_lien($regs[1], $regs[2]);
    $out .= $ligne."\n";        
}

echo "<h2>Contenu du repertoire \"".$repertoire."\" :</h2>";
echo '<div class="article"><pre>'.$out.'</pre></div>'."\n";
?>

<h2>But de l'exercice :</h2>

<p>Trouver des informations sur le système d'exploitation en utilisant la commande
<em>uname</em> (utilisez <em>--help</em> pour obtenir l'aide ;-))</p>

<h2>Aide :</h2>

<?php crackme_help(); ?>

<div id="aide" style="display: none;" class="article">
<p>Vous pouvez vous aider de 
<a href="http://www.haypocalc.com/wiki/Bash">mon article sur bash</a>.</p>
</div>
<?php
// Bas de page
include($rootpath.'include/crackme_options.php');
include($rootpath.'include/footer.php');
?>
</body>
</html>

<?php
// Configure l'exercice
error_reporting(E_ALL);
$rootpath = '../';
$url_root = '../';
$table = 'crackme4';
require_once($rootpath.'include/crackme_func.php');
crackme_set_magic_quotes(false);

$fichier = crackme_html_request('f');
if ($fichier != '') telecharge($fichier);
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Language" content="fr" />
  <link rel="stylesheet" type="text/css" media="screen" href="../style.css" />
  <title>Crackme #4</title>
</head>
<body>

<h1>Crackme #4</h1>

<?php
$motpasse = crackme_html_request('motpasse');
if ($motpasse)
{
    if ($motpasse == 'cetaitplusdurhein') {
        echo '<div class="article"><p>Mot de passe valide !</p></div>';
        // ... (normalement on fait plein de truc ici)
    } else {
        crackme_error('<p>Mot de passe incorrect.</p>');
    }
}
?>

<h2>Fichiers à télécharger :</h2>

<ul>
<?php

function lit_repertoire_mysql()
{
    $r = @mysql_query("SHOW GLOBAL VARIABLES like 'datadir'");
    if (!$r) die('echec mysql datadir');
    $row = @mysql_fetch_row($r);
    if (!$row) die('echec2 mysql datadir');
    return $row[1];
}

function telecharge($fichier)
{
    // Interdit des exploits trop vilains
    $allow = Array('INTO', 'LOAD_FILE', 'OUTFILE');
    if (!crackme_check_sql($fichier, $allow))
    {
       crackme_error('<p>Nom de fichier incorrect : «&nbsp;<em>'.$str.'</em>&nbsp;».');
       return;
    }

    // Vérifie les LOAD_FILE
    if (!crackme_check_loadfile($fichier)) return;

    // Vérifie les OUTFILE 
    if (preg_match_all('/OUTFILE +([^ ]+)/i', $fichier, $match))
    {
        foreach ($match[1] as $string)
        {
            $str = mysql2str($string);
            if (!$str)
            {
                crackme_error("<p>Chaîne non reconnue : «&nbsp;$string&nbsp;».");
                return;
            }
            
            if (strpos($str, '/') === false || !crackme_file_allowed($str))
            {
                crackme_error("<p>Pas le droit d'écrire dans le fichier «&nbsp;$str&nbsp;». Utilisez le répertoire couran(".realpath('.').") ...");
                return;
            }
        }
    }

    // Lit le compteur
    crackme_init_sql();
    $compteur = crackme_sql_query("SELECT compteur FROM crackme4 WHERE fichier='$fichier';");
    if (!$compteur)
    {
        crackme_error("<p>Erreur du compteur ...</p>");
        return;
    }

    // Interdit les fichiers autres que truc.txt 
    if (!ereg("^[a-zA-Z0-9]+\.txt$", $fichier))
    {
        crackme_error("<p>Seul les fichiers textes (.txt) du répertoire courant sont autorisés.</p>");
        return;        
    }

    // Mise à jour du compteur
    if (mysql_num_rows($compteur) == 1) {
        crackme_sql_query("UPDATE crackme4 SET compteur=compteur+1 WHERE fichier='$fichier';");
    } else {
        crackme_sql_query("INSERT INTO crackme4 (fichier, compteur) VALUES('".mysql_real_escape_string($fichier)."',1);");
    }

    // Lit la taille du fichier
    $size = filesize($fichier);
    if ($size === false || $size == 0)
    {
        crackme_error("<p>Impossible de lire la taille du fichier \"<em>$fichier</em>\", ou alors il est vide.</p>");
        return;
    }
    
    header("Content-Type: application/octet-stream");
    header("Content-Length: ".$size);
    header("Content-Disposition: attachment; filename=\"".basename($fichier)."\";");
    readfile($fichier);
    die();
}

function liste_txt()
{
    $dir = opendir('./');
    if (!$dir)
    {   
        crackme_error("<p>Impossible d'ouvrir le répertoire courant !?</p>");
        return;
    }
    while (($file = readdir($dir)) !== false)
    {
        if (eregi("^[a-zA-Z0-9]+\.txt$", $file))
        {
            echo '<li><a href="index.php?f='.$file;
            echo '">'.$file.'</a></li>'."\n";
        }
    }        
    closedir($dir);
}

liste_txt();
?>  
</ul>  

<h2>Administration :</h2>

<form action="index.php" method="post">
  <p>Mot de passe : <input type="text" name="motpasse" size="10" /></p>
  <p><input type="submit" value="Identification" />
</form>

<h2>But de l'exercice :</h2>

<p>S'authentifier avec le vrai mot de passe.</p>

<h2>Aide :</h2>

<?php crackme_help(); ?>

<div id="aide" class="article" style="display: none;">
<p>Utilisez <em>LOAD_FILE</em> et <em>OUTFILE</em> dans une injection SQL.</p>

<p>Vous pouvez vous aider de 
<a href="http://www.haypocalc.com/wiki/Injection_de_SQL">mon article sur l'injection de SQL</a>.</p>
</div>

<?php
// Bas de page
include($rootpath.'include/crackme_options.php');
include($rootpath.'include/footer.php');
?>
</body>
</html>

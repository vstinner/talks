<?php
// Configure l'exercice
error_reporting(E_ALL);
$rootpath = '../';
$url_root = '../';
$table = '';
require_once($rootpath.'include/crackme_func.php');
crackme_set_magic_quotes(false);
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Language" content="fr" />
  <link rel="stylesheet" type="text/css" media="screen" href="../style.css" />
  <title>Crackme #5</title>
</head>
<body>

<h1>Crackme #5</h1>

<?php
crackme_init_sql();

function login($pass)
{
    if (!crackme_check_sql($pass)) return;

    $r = crackme_sql_query("SELECT MD5('$pass')");
    if (!$r || !($row = @mysql_fetch_row($r)))
    {
	crackme_error('<p>Erreur SQL !?</p>');
	return;
    }
    
    if ($row[0] == '913850b6724b8461bdf6ba268294a605') {
        echo '<div class="article"><p>Mot de passe valide !</p></div>';
        // ... (normalement on fait plein de truc ici)
    } else {
        crackme_error('<p>Mot de passe incorrect.</p>');
    }
}

$motpasse = crackme_html_request('motpasse');
if ($motpasse) login($motpasse);

$source = crackme_html_request('source');
if ($source)
{
  echo '<div class="article"><pre>';
  highlight_file("index.php");
  echo "</pre></div>\n";
}
?>

<h2>S'authentifier :</h2>

<form action="index.php" method="post">
  <p>Mot de passe :
  <textarea name="motpasse" rows="2" cols="60"><?php echo htmlspecialchars($motpasse); ?></textarea></p>
  <p><input type="submit" value="Identification" />
</form>

<h2>But de l'exercice :</h2>

<p>S'authentifier sans utiliser la force brute.</p>

<h2>Aide :</h2>

<p><a href="index.php?source=1">Voir le code source</a></p>

<?php
// Bas de page
include($rootpath.'include/crackme_options.php');
include($rootpath.'include/footer.php');
?>
</body>
</html>

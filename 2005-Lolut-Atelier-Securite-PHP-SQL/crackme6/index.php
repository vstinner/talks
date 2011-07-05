<?php
// Configure l'exercice
error_reporting(E_ALL);
$rootpath = '../';
$url_root = '../';
$table = 'crackme6';
require_once($rootpath.'include/crackme_func.php');
crackme_set_magic_quotes(true);
?>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Language" content="fr" />
  <link rel="stylesheet" type="text/css" media="screen" href="../style.css" />
  <title>Crackme #6</title>
</head>
<body>

<h1>Crackme #6</h1>

<?php
crackme_init_sql();

function login($pass)
{
    if ($pass == 'injectionsql') {
        echo '<div class="article"><p>Mot de passe valide !</p></div>';
        crackme_sql_query('TRUNCATE crackme6');
    } else {
        crackme_error('<p>Mot de passe incorrect.</p>');
    }
}

$motpasse = crackme_html_request('motpasse');
if ($motpasse) login($motpasse);

function ajout($note, $texte)
{
  if (!crackme_check_sql($note, Array('LOAD_FILE'))) return;
  if (!crackme_check_loadfile($note)) return;

  $sql  = "INSERT INTO crackme6 (id, note, texte) ";
  $sql .= "SELECT MAX(id)+1, $note, ";
  $sql .= "'".mysql_real_escape_string($texte)."' FROM crackme6";
  $r = crackme_sql_query($sql);
  if (!$r)
	crackme_error("<p>Erreur à l'ajout du commentaire :-(</p>");
  else
	echo '<div class="article"><p>Commentaire ajouté.</p></div>';
}

$note = crackme_html_request('note');
$texte = trim(crackme_html_request('texte'));
if ($note !== false && $texte)
{
    if (crackme_get_magic_quotes()) $texte = stripslashes($texte);
   ajout($note, $texte);
}?>

<h2>Débat :</h2>

<p>Linux c'est de la merde</p>

<h2>Commentaires :</h2>

<?php
function lit()
{
	$r = crackme_sql_query('SELECT note, texte FROM crackme6');
	if (!$r) return;
	while ($row = mysql_fetch_array($r))
	{
		$texte = stripslashes($row[1]);
		echo "<p>($row[0]/9) $texte</p>\n";
	}
}
lit();
?>

<h2>Ajouter un commentaire :</h2>

<script type="text/javascript">
function check()
{
  var note = document.getElementById('note').value;
  var intnote = Number(note);
  if (note == '' || intnote < 1 || intnote > 9)
  {
    alert('Note invalide : doit être comprise entre 1 et 9 (inclus).');
    return false;
  }
  var texte = document.getElementById('texte').value;
  if (texte == '')
  {
     alert('Le texte du commentaire est vide.');
     return false;
  }
  return true;
}
</script>

<form action="index.php" method="post" onsubmit="return check();">
  <p>Note (de 1 à 9) : <input id="note" type="text" name="note" size="2" maxlength="1" /></p>
  <p>Texte :
  <textarea name="texte" rows="2" cols="60" id="texte"></textarea></p>
  <p><input type="submit" value="Ajouter" />
</form>

<h2>Supprimer les commentaires :</h2>

<form action="index.php" method="post">
  <p>Mot de passe :
  <input type="text" name="motpasse" size="10" /</p>
  <p><input type="submit" value="Identification" />
</form>

<h2>But de l'exercice :</h2>

<p>S'authentifier sans utiliser la force brute.</p>

<h2>Aide :</h2>

<p>Le répetoire courant est «&nbsp;<em><?php echo realpath('.'); ?></em>&nbsp;»</p>

<p>Ne vous laissez pas faire par un Javascript à la noix !</p>

<?php
// Bas de page
include($rootpath.'include/crackme_options.php');
include($rootpath.'include/footer.php');
?>
</body>
</html>

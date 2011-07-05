<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Language" content="fr" />
  <link rel="stylesheet" type="text/css" media="screen" href="../style.css" />
  <title>Crackme #1</title>
</head>
<body>
<h1>Crackme #1</h1>
<?php
$url_root = '../';
$rootpath = '../';
require_once($rootpath.'include/crackme_func.php');
crackme_set_magic_quotes(false);
error_reporting (E_ALL);

$table = 'crackme1';
$page = $_SERVER['PHP_SELF'];

function affiche_article($id)
{   
    if (!crackme_check_sql($id))
    {
       crackme_error('<p>Hum, je n\'ai pas réussi à valider tes entrées ... (engueule Victor)</p>');
       return -1;
    }
    $sql = 'SELECT titre, texte FROM '.$GLOBALS['table'].' WHERE id='.$id.' AND secret=0';
    $r = crackme_sql_query($sql);
    if (!$r) return false;
    if (mysql_num_rows($r) == 0) return 0;
    $row = mysql_fetch_array($r);
    if ($row === false) return 0;
    $titre = utf8_encode($row[0]);
    $texte = utf8_encode($row[1]);
    echo '<h2>'.$titre.'</h2>';
    echo '<div class="article">'.$texte.'</div>'."\n";
    return 1;
}

function liste_articles()
{
    $r = mysql_query('SELECT id,titre FROM '.$GLOBALS['table']);
    if (!$r)
    {
        crackme_error('<p>Erreur liste articles.</p>');
        return;
    }
    echo "<h2>Liste des articles :</h2>\n";
    echo "<ul>\n";
    while ($row = mysql_fetch_array($r))
    {
        $id = $row[0]; 
        $titre = utf8_encode($row[1]);
        $url = $GLOBALS['page'].'?id='.$id;
        echo '<li><a href="'.$url.'">'.$titre.'</a></li>'."\n";
    }
    echo "</ul>\n";
}

function main()
{
    $id = crackme_html_request('id');
    if ($id != '') {
        if (affiche_article($id) == 0)
        {
           crackme_error("<p>Article inexistant (ou secret !).</p>");
        }
        echo '<p><a href="'.$GLOBALS['page'].'">Retour à la liste des articles</a></p>';
    } else {
        liste_articles();
    }
}

$ok = crackme_init_sql();
if ($ok) main();
?>

<h2>Aide :</h2>

<?php crackme_help(); ?>

<div id="aide" style="display: none;" class="article">
<p>La table SQL est <em>article1</em> avec comme clé <em>id</em> et les champs :
<em>titre</em> (chaîne), <em>texte</em> (chaîne) et <em>secret</em> (entier)</p>

<p>Vous pouvez vous aider de 
<a href="http://www.haypocalc.com/wiki/Injection_de_SQL">mon article sur l'injection de SQL</a>.</p>
</div>

<?php
include($rootpath.'include/crackme_options.php');
include($rootpath.'include/footer.php');
?>
</body>
</html>

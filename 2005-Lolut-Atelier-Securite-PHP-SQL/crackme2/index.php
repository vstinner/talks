<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Language" content="fr" />
  <link rel="stylesheet" type="text/css" media="screen" href="../style.css" />
  <title>Crackme #2</title>
</head>
<body>
<h1>Crackme #2</h1>
<?php

error_reporting(E_ALL);

$rootpath = '../';
$url_root = '../';
require_once($rootpath.'include/crackme_func.php');

// Le secret est juste quelques lignes en dessous ...
$motpasse = crackme_html_request('motpasse');
if ($motpasse)
{
    if ($motpasse == 'yougotit') {
        echo '<div class="article"><p>Mot de passe valide !</p></div>';
        // ... (normalement on fait plein de truc ici)
    } else {
        crackme_error('<p>Mot de passe incorrect.</p>');
    }
}

$article = crackme_html_request('article');
if ($article)
{
    // Test pour rendre l'exercice plus complique 
    if (strstr($article, "../") !== false) {
        crackme_error("<p>Tututu, pas de \"../\" dans un nom d'article ! (pas folle l'abeille)</p>");
        $article = false;
        
    // Test pour eviter qu'on sorte du "cadre de l'exercice" ...
    } else if (file_exists($article)) {
        if (!crackme_file_allowed($article))
        {    
            crackme_error("<p>Tututu, pas le droit au repertoire \"".dirname($article)."\" !</p>");
            $article = false;
        }
    }
}

// S'il y a une erreur, utilise l'article par defaut
if (!$article) $article = 'index.txt';

// Affiche le contenu de l'article
$texte = file($article);
echo join("\n", $texte);
?>

<h2>Aide :</h2>

<?php crackme_help(); ?>

<div id="aide" style="display: none;" class="article">
<p>La faille n'est pas dans le système d'authentification ...</p>
</div>



<?php
// Bas de page
include($rootpath.'include/crackme_options.php');
include($rootpath.'include/footer.php');
?>
</body>
</html>

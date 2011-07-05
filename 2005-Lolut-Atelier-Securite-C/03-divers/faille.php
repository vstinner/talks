<?php
$name = trim($_SERVER['argv'][1]);
if ($name != '')
    system("grep $name /etc/passwd");
else
    echo "Veuillez passer un identifiant en argument.\n";
?>

<?php
function hex2ascii($str)
{
   $p = '';
   for ($i=0; $i < strlen($str); $i=$i+2)
   {
       $p .= chr(hexdec(substr($str, $i, 2)));
   }
   return $p;
}

// Convert mysql string to PHP string
// Eg. 'a\'b'
// Eg. 'abc'
// Eg. 0x616263
function mysql2str($string)
{
    $string = ereg_replace("#.*$", "", $string);
    if (eregi("^'(([^']|\\')+)'$", $string, $regs)) {
        return $regs[1];
    } else if (eregi("^0x([a-fA-F0-9]+)$", $string, $regs)) {
        return hex2ascii($regs[1]);
    } else {
        return false;
    }
}            


function crackme_check_loadfile($sql)
{
    if (preg_match_all('/LOAD_FILE\(([^)]+)\)/i', $sql, $match))
    {
        foreach ($match[1] as $string)
        {
            $str = mysql2str($string);
            if (!$str)
            {
                crackme_error("<p>Chaîne non reconnue : «&nbsp;$string&nbsp;».");
                return false;
            }

            if (strpos($str, "/") === false || !crackme_file_allowed($str))
            {
                crackme_error("<p>Pas le droit au fichier «&nbsp;<em>$str</em>&nbsp;».");
                return false;
            }
        }
    }
	return true;
}

function crackme_file_allowed($filename, $dir='.')
{
    $root = realpath($dir);
    $real = realpath($filename);
    if (!$real) return true;
    return (strncmp($root, $real, strlen($root)) == 0);
}

function crackme_check_sql($sql, $allow=Array())
{
  $crackme_table = $GLOBALS['table'];
  $forbidden = Array(
    'SHOW', 'INSERT', 'UPDATE', 
    'DATABASE', 'USER', 'VERSION', 'DESCRIBE',
    'SYSTEM', 'SESSION', 'EXPLAIN',
    'INTO', 'LOAD_FILE', 'OUTFILE', 'DUMPFILE');
  $forbidden = array_diff($forbidden, $allow);
  foreach ($forbidden as $kw)
  {
    if (stristr($sql, $kw))
    {
       crackme_error('<p>Pas le droit au mot clé <em>'.$kw.'</em>.</p>');
       return false;
    }
  }
  if (preg_match_all('/(FROM|INTO) +([a-z][a-z0-9_]*)/i', $sql, $froms))
  {
     foreach ($froms[2] as $table)
     { 
       if (in_array($table, $allow)) continue;
       if ($table != $crackme_table) 
       {
          crackme_error('<p>Pas le droit à la table <em>'.$table.'</em></p>');
          return false;
       }
     }
  }
  return true;
}

function crackme_help()
{
?>
<p id="clic_aide"><a id="lien_aide" href="#" style="cursor: wait;"
onclick="return crackme_show_help();">Cliquez pour afficher l'aide (<span id="timeout_aide"></span>)</a></p>

<script type="text/javascript">
function crackme_allow_help(new_timeout)
{
    timeout = new_timeout;
    if (0 < timeout) {
        delay = 5;
        setTimeout("crackme_allow_help("+(timeout-delay)+");", delay*1000);
        txt = 'bloqué durant <em>'+timeout+'</em> secondes';
    } else {
        txt = 'cliquez si vous êtes un <em>looser</em>';
        document.getElementById('lien_aide').style.cursor = 'help';
    }
    document.getElementById('timeout_aide').innerHTML = txt;
}

function crackme_show_help()
{
    if (0 < timeout)
    {
        alert('Faites travailler vos méninges !');
        return false;
    }
    document.getElementById('clic_aide').style.display='none';
    document.getElementById('aide').style.display='block';
    return false;
}
crackme_allow_help(100);
</script>
<?php
}


function crackme_init_sql()
{
    $root = realpath('../');
    if (ereg("^/var/www", $root))
        $file = '/var/www/crackme_mysql.inc';
    else
        //$file = '/home/haypocal/include/crackme_mysql.inc';
        $file = '/home/www-data2/apache2/htdocs/crackme_mysql.php';
    if (!file_exists($file))
    {
        crackme_error("<p>Impossible de trouver le fichier de configuration SQL (<em>$file</em>) !</p>");
        return false;
    }
    include ($file);
    return true;
}

function crackme_error($str)
{
  echo '<div class="erreur">'.$str.'</div>'."\n";
}

function crackme_html_request($key)
{
  if (!array_key_exists($key, $_REQUEST)) return false;
  return $_REQUEST[$key];
}

function crackme_sql_query($sql)
{
  $r = mysql_query($sql);
  if (!$r)
  {
    echo '<div class="erreur">';
    echo '<p>Erreur SQL : «&nbsp;<em>'.mysql_error().'</em>&nbsp;»</p>';
    echo '<p>(requête : «&nbsp;<em>'.$sql.'</em>&nbsp;»)</p>';
    echo '</div>';
    return false;
  }
  return $r;
}

function crackme_remove_magic_quotes(&$array)
{
   foreach($array as $key => $val){

       # Si c'est un array, recurssion de la fonction, sinon suppression des slashes
       if(is_array($val)){
           crackme_remove_magic_quotes($array[$key]);
       } else if(is_string($val)){
           $array[$key] = stripslashes($val);
       }
   }
}

function crackme_get_magic_quotes()
{
  global $crackme_set_magic_quotes;
  if (isset($crackme_set_magic_quotes)) return $crackme_set_magic_quotes;
  return get_magic_quotes_gpc();
}

function crackme_set_magic_quotes($enable)
{
  global $crackme_set_magic_quotes;
  $crackme_set_magic_quotes = $enable;
  set_magic_quotes_runtime($enable);
  if (get_magic_quotes_gpc() == $enable) return;
  if ($enable) {
     die('crackme_set_magic_quotes fails.');
  } else {
     crackme_remove_magic_quotes($_POST);
     crackme_remove_magic_quotes($_GET);
     crackme_remove_magic_quotes($_REQUEST);
     crackme_remove_magic_quotes($_SERVER);
     crackme_remove_magic_quotes($_FILES);
     crackme_remove_magic_quotes($_COOKIE);
  }
}
?>

<?php
function crackme_error_reporting_item(&$str, $err, $flag, $text)
{
  if (($err & $flag) == $flag)
  {
    if ($str != '') $str .= ' | ';
    $str .= $text;
  }
}

function crackme_error_reporting_str()
{
  $err = ini_get('error_reporting');
  if ($err == E_ALL) return 'E_ALL';
  $txt = '';
  crackme_error_reporting_item($txt, $err, E_ERROR, 'E_ERROR');
  crackme_error_reporting_item($txt, $err, E_WARNING, 'E_WARNING');
  crackme_error_reporting_item($txt, $err, E_PARSE, 'E_PARSE');
  crackme_error_reporting_item($txt, $err, E_NOTICE, 'E_NOTICE');
/*  case E_CORE_ERROR
  case E_CORE_WARNING
  case E_COMPILE_ERROR 
128	E_COMPILE_WARNING
256	E_USER_ERROR
512	E_USER_WARNING
1024	E_USER_NOTICE */
  return $txt;
}

echo '<p style="text-align: center;">PHP : ';
echo 'magic_quotes=<em>'.(crackme_get_magic_quotes()?'on':'off').'</em>';
echo ', error_reporting=<em>'.crackme_error_reporting_str().'</em>';
echo '</p>'."\n";
?>

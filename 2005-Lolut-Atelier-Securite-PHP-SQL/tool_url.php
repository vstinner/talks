<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Language" content="fr" />
  <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
  <script type="text/javascript">

/*** Copy of http://ostermiller.org/calc/encode.html ****/
function urlEncode(str){
    str=escape(str);
    str=str.replace(new RegExp('\\+','g'),'%2B');
    return str.replace(new RegExp('%20','g'),'+');
}
/*** End of copy of http://ostermiller.org/calc/encode.html ****/

 
function codeText()
{
    var text_input = document.getElementById('text');
    var encoded_input = document.getElementById('encoded');
    var text = text_input.value;
    var encoded = urlEncode(text);
    encoded_input.value = encoded;
}
</script>
</head>
<body>
  <h1>Encodeur pour URL</h1>
  <p>Outil permettant d'encodeur une chaîne de caractère pour pouvoir
  l'utiliser dans un argument d'une page PHP. Exemple : on n'écrit pas
  « index.php?message=Salut les éléphants! » mais
  « index.php?message=Salut+les+%E9l%E9phants%21 ». Seul la valeur des
  arguments doit être encodée avec cet outil.</p>
  <textarea id="text" rows="4" cols="80" onkeyup="codeText();"></textarea><br />
  <textarea id="encoded" rows="4" cols="80">
  </textarea><br />
  <input type="button" onclick="codeText();" value="Coder" />
  <p>Pense bête :</p>
  <ul>
    <li>« &nbsp; » =&gt; « + »</li>
    <li>« # » =&gt; « %23 »</li>
    <li>« ' » =&gt; « %27 »</li>
    <li>« ( » =&gt; « %28 »</li>
    <li>« ) » =&gt; « %29 »</li>
    <li>« + » =&gt; « %2B »</li>
  </ul>
  <?php $rootpath = './'; include($rootpath.'include/footer.php'); ?>
</body>
</html>

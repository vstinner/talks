<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <meta http-equiv="Content-Language" content="fr" />
  <link rel="stylesheet" type="text/css" media="screen" href="style.css" />
  <script type="text/javascript">

/*** Copy of http://ostermiller.org/calc/encode.html ****/
var digitArray = new Array
  ('0','1','2','3','4','5','6','7','8','9','a','b','c','d','e','f');

function pad(str, len, pad){
    var result = str;
    for (var i=str.length; i<len; i++){
        result = pad + result;
    }
    return result;
}

function toHex(n){
    var result = ''
    var start = true;
    for (var i=32; i>0;){
        i-=4;
        var digit = (n>>i) & 0xf;
        if (!start || digit != 0){
            start = false;
            result += digitArray[digit];
        }
    }
    if (result=='') result = '0';
    return pad(result, 2, '0');
}
/*** End of copy of http://ostermiller.org/calc/encode.html ****/

 
function codeText()
{
    var text_input = document.getElementById('text');
    var encoded_input = document.getElementById('encoded');
    var text = text_input.value;
    var encoded = "0x";
    for (var i=0; i<text.length; i++)
    {
        encoded += toHex(text.charCodeAt(i) & 255);
    }
    encoded_input.value = encoded;
}
  </script>
</head>
<body>
  <h1>Encodeur pour SQL</h1>
  <p>Utilisez cet outil pour convertir une chaîne de caractère en hexadécimal
  dans le format qu'utilise MySQL. Vous pourrez alors écrire 'abc' :
  0x616263 (plus besoin des apostrophes, codees 0x27 d'ailleurs).</p>
  <textarea id="text" rows="4" cols="80" onkeyup="codeText();"></textarea><br />
  <textarea id="encoded" rows="4" cols="80">
  </textarea><br />
  <input type="button" onclick="javascript:codeText();" value="Coder" />
  <?php include('./include/footer.php'); ?>
</body>
</html>

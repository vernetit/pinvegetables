<?
if(isset($_GET["q"])){

//echo $_GET["q"]."<br>";

if($_GET["q"]=="") die();

 function UniqueRandomNumbersWithinRange($min, $max, $quantity) {
     $numbers = range($min, $max);
     shuffle($numbers);
     return array_slice($numbers, 0, $quantity);
 }


 function rand_line($fileName, $maxLineLength = 40,$maxQuantity, $bQ, $patron) {

     $handle = @fopen($fileName, "r");

     $cantidad=20; if(isset($_GET["cantidad"])){ $cantidad=intval($_GET["cantidad"]); }

     //valido cantidades
     if($cantidad>300) die;
     if($cantidad<0) die;

     if ($handle) {
         $random_line = null;
         $line = null;
         $count = 0;
         $total = 0;

         $myArray = UniqueRandomNumbersWithinRange(0,$maxQuantity,$cantidad);

         while (($line = fgets($handle, $maxLineLength)) !== false) {

             /*
             if(strlen($line)){
               array_push($myArray, $count++);
               $count++;
               die;
               continue;
             }*/

           //if($total>=$cantidad)
           // continue;

             $count++;

             // P(1/$count) probability of picking current line as random line
             /*if(in_array($count, $myArray)) {
              //echo ($total+1)."-".strlen($line)."->".$line;
               if($bQ){
                 if($line=="\n" || $line==" " || strlen($line)<20){
                   array_push($myArray,$count+1);
                   $count--;
                   continue;

                 }
               }*/
               $line= strtolower(str_replace("\n", "", $line));

               $sujeto = $line;

               //$patrón = '/^[aeiou]{0,}[nñ][aeiou]{0,}[m][aeiou]{0,}[td][aeiou]{0,}$/';
               $coincidencias=null;
               preg_match($patron, $sujeto, $coincidencias, PREG_OFFSET_CAPTURE);

               if(count($coincidencias)>0 && strlen(trim($sujeto))>2){
                $random_line[$total]=$sujeto;
                $total++;

               }
               
               /*$random_line[$total] = "\n".'<a href="#" onclick="loadUrl('."'".$line."'".');" style="color: black;">'.$line.'</a>';
               $total++;

             }*/
             //if($count==1000) break;
         }
         if (!feof($handle)) {
             echo "Error: unexpected fgets() fail\n";
             fclose($handle);
             return null;
         } else {
             fclose($handle);
         }
         return $random_line;
     }
 }


 $numberQuery=$_GET["q"];

 
 //$poner = "/^[aeiou]{0,}";
 $poner="/^";

 $sustituir["0"]="[r]{1,}";
 $sustituir["1"]="[td]{1,}";
 $sustituir["2"]="[nñ]{1,}";
 $sustituir["3"]="[m]{1,}";
 $sustituir["4"]="[ck]{1,}";
 $sustituir["5"]="[l]{1,}";
 $sustituir["6"]="[sz]{1,}";
 $sustituir["7"]="[f]{1,}";
 $sustituir["8"]="(j|ch|g){1,}";
 $sustituir["9"]="[bvp]{1,}";

 for($i=0;$i<strlen($numberQuery);$i++){
  for($j=0;$j<10;$j++){

   if(intval($numberQuery[$i])==$j){
    //echo $numberQuery[$i];
    $vocales="[aeiouháéíóu]{0,}";

    if(intval($numberQuery[$i-1])==4)
     $vocales="[aeiouáéíóu]{0,}";

    $poner.=$vocales.$sustituir[$j.""];

   }
  }
  


 }
 $vocales="[aeiouháéíóu]{0,}";

 if(intval($numberQuery[$i-1])==4)
  $vocales="[aeiouáéíóu]{0,}";

 $poner.=$vocales."$/";

 $patron=$poner;

 //echo $patron."<br>";

 $txtToLoad = "db/lemario.txt"; $mq=80383;
 $bQ=0; $mLL=40;

 $txt = rand_line($txtToLoad,$mLL,$mq,$bQ,$patron);

 if(count($txt)==0) die;

 $poner="";
 foreach ($txt as $key => $value) {
  echo $value.", ";
 }

 //print_r($txt);
 die();
}
?>

<!DOCTYPE html>
<html>
<head>
 <meta charset="UTF-8">
 <title>pinvegetables</title>

 <meta name="description" content="Crea tu sistema mayor!">
 <meta name="keywords" content="sistema mayor, casillero mental, pao">

 <script src='js/jquery.min.js'></script>
 <script src="js/underscore-min.js"></script>
 <script src="js/jquery.tabSlideOut.js"></script>

  <link rel="stylesheet" href="js/jquery.tabSlideOut.css"> 
  <style type="text/css">
  .consonant{
   color: #DF496C;
  }

  #footer {
    position:fixed;
    bottom:0;
    width: 100%;
    text-align: right;
    font: bold;
}
  </style>
  <script>
       
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-45359665-6', 'auto');
  ga('send', 'pageview');

</script>
</head>
<body>
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/sdk.js#xfbml=1&version=v2.5";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<center>
<h1 style="color: green;">pinvegetables</h1>
<br>

<input type="text" name="search" value="" id="searchQuery" onkeypress="if(event.keyCode === 13) buscar();">
<input type="button" name="search" value="buscar" onclick="buscar()" >
<br>

<p>

<b style="color: gray;">Elige un número de cualquier tamaño</b><br><br>
<span style="font-size: 10px; color: gray;" > Memorizar usando el <a href="http://www.taringa.net/posts/salud-bienestar/17928387/Sistema-Mayor-desarrolla-una-Memoria-prodigiosa.html" style="font-size: 10px; color: gray;" target="_blank"> Sistema Mayor</a></span>

</p>

<br><br>
<div id="screen" style="word-break: normal;"></div>


</center>

 <div id="footer">
 <div style="margin-right: 20px; color: green;">robertchalean@gmail.com  &#169;2017 &nbsp; Based on <a href="http://pinfruit.com/" style="color: green;"  target="_blank">http://pinfruit.com/</a>&nbsp;&nbsp;
 <div class="fb-share-button" data-href="http://competicionmental.appspot.com/pinvegetables" data-layout="button_count" style="float: right;"></div>
</div>


</div>

<div id="slide-out-div" style="background: #8fbe00; color: white;">
    <a class="handle" style="background: #8fbe00; font-size: 20px;">El Sistema Mayor</a>
    <p>
     <b>Referencia</b>
     <br>
     <table class="systemTable">
        <tbody><tr>
          <td>0</td>
          <td>r</td>
          <td>o<span class="consonant">r</span>o, a<span class="consonant">r</span>o</td>
        </tr>
        <tr>
          <td>1</td>
          <td>t,d</td>
          <td><span class="consonant">t</span>ea, a<span class="consonant">d</span>a</td>
        </tr>
        <tr>
          <td>2</td>
          <td>n,ñ</td>
          <td><span class="consonant">n</span>oe, u<span class="consonant">ñ</span>a</td>
        </tr>
        <tr>
          <td>3</td>
          <td>m</td>
          <td>hu<span class="consonant">m</span>o</td>
        </tr>
        <tr>
          <td>4</td>
          <td>c,k</td>
          <td>o<span class="consonant">c</span>a, <span class="consonant">k</span>o</td>
        </tr>
        <tr>
          <td>5</td>
          <td>l</td>
          <td>o<span class="consonant">l</span>a</td>
        </tr>
        <tr>
          <td>6</td>
          <td>s,z</td>
          <td>o<span class="consonant">s</span>o, <span class="consonant">z</span>oo</td>
        </tr>
        <tr>
          <td>7</td>
          <td>f</td>
          <td>u<span class="consonant">f</span>o</td>
        </tr>
        <tr>
          <td>8</td>
          <td>j,ch,g</td>
          <td><span class="consonant">Ch</span>e, o<span class="consonant">j</span>o, a<span class="consonant">g</span>ua</td>
        </tr>
        <tr>
          <td>9</td>
          <td>p,b,v</td>
          <td><span class="consonant">B</span>húo, a<span class="consonant">v</span>e, a<span class="consonant">p</span>io</td>
        </tr>
      </tbody></table>
      <br>
      Ver <a href="http://www.nuecesyneuronas.com/mi-casillero-mental/" style="color: white;"  target="_blank"> guia de usuario</a><br>
      Ver <a href="http://diariopositivo2015.blogspot.com.ar/2016/04/mis-imagenes-de-los-casilleros-mentales.html" style="color: white;"  target="_blank"> imágenes</a>
    </p>
</div>

<img src="/img/loading.gif" style="display:none;">

<script type="text/javascript">

$(document).ready(function() {
 $('#slide-out-div').tabSlideOut({
     tabLocation: 'right' // optional, default is 'left'
 });
 $("#searchQuery").focus();
});


var txt;
count=0;

function buscar(){
 count++;
 if(count>30){ alert("muchas request"); return;}
 if(txt==$("#searchQuery").val()){ console.log("repeated"); return; }
 txt=parseInt($("#searchQuery").val());
 console.log(txt);
 if(isNaN(txt)){ console.log("not number"); return; }
 if(txt.length==0){ console.log("empty"); return; }

 $("#screen").html(`<img src="/img/loading.gif">`)
 
 $.ajax({url: "/pinvegetables?q="+$("#searchQuery").val(), success: function(result){
     //console.log(result);
     //arrayImages1=JSON.parse(result);
     //arrayPreloadImages = _.union(arrayImages,arrayImages1);
     //console.log(arrayPreloadImages);
     //preload();
     //console.log(arrayImages1);
     str=result;
     str=str.substring(0, str.length - 2);

     $("#screen").html(str);
     $("#screen").width("600px");
  }});
}

 
</script>

</body>
</html>
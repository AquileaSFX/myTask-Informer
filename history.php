<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>My - Activities History</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=no">
	<link rel="stylesheet" href="css/kraken.css">
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="js/responsiveslides.min.js"></script>
  <script src="js/kraken.js"></script>
  <script>
    $(document).ready(function(){
      var myrandom, mybgimg;
      myrandom = Math.ceil(Math.random() * 18);
      mybgimg = '0'+myrandom;
      //New version
      $.Kraken({ 
        pagesize : { width: 830 },
        bgimg    : { img : mybgimg },  
        bgcolor  : { color : '166E91' },
      });
    });
  </script>
  <!--[if lt IE 9]>
  <script src="http://css3-mediaqueries-js.googlecode.com/files/css3-mediaqueries.js"></script>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->
  <script type="text/javascript">
    $(function(){
      $('.mydesctitle').on('click', function(){
        $(this).parent().next().toggle(250);
        $(this).text($(this).text() == 'See description' ? 'Hide description' : 'See description');
      })
    })();
  </script>
</head>
<body>
  <!-- <div class="background-top"></div> -->
  <div id='menu'> <!-- MENU -->
    <nav class="nav center">
      <ul>
        <li class="current"><a href="index.php">Home</a></li>
      </ul>
    </nav>
  </div>
  <div class="wrap"><!--WRAP-->
    <div class="grids"> <!--GRIDS-->
      <div class="span" value="4.5"></div>
      <div class="grid-12 mL">
        <div class="mytaskstitle"><h6>myTasks Informer v0.2</h6></div>
        <div class="mydate"><date><?php echo date('l jS \of F Y h:i:s A'); ?></date></div>
        <div class="grid-10">
          <h1 title="Activities" style="margin-top:0;">History of Activities</h1>
        </div>
        <div class="grid-12 box solid">
          <div class="toptext">
            <h2 class="nomargin">History:</h2>
          </div>
          <div class="midtext">
          <?php
            class MyDB extends SQLite3
            {
              function __construct()
              {
                $this->open('admin/db/mytasks.db');
              }
            }
            $db = new MyDB();
            if(!$db){
              echo $db->lastErrorMsg();
            } 
            for ($i=01; $i < 12; $i++) { 
              $sqlfly=<<<EOF
                SELECT * from TASKS where STATUS="done" AND ENDDATE LIKE '%2014-0$i%' order by ENDDATE DESC;
EOF;
              $retfly = $db->query($sqlfly);
              switch ($i) {
                case '1':
                  $Mycurrentmonth = "January";
                  break;
                case '2':
                  $Mycurrentmonth = "February";
                  break;
                case '3':
                  $Mycurrentmonth = "March";
                  break;
                case '4':
                  $Mycurrentmonth = "April";
                  break;
                case '5':
                  $Mycurrentmonth = "May";
                  break;
                case '6':
                  $Mycurrentmonth = "June";
                  break;
                case '7':
                  $Mycurrentmonth = "July";
                  break;
                case '8':
                  $Mycurrentmonth = "August";
                  break;
                case '9':
                  $Mycurrentmonth = "September";
                  break;
                case '10':
                  $Mycurrentmonth = "October";
                  break;
                case '11':
                  $Mycurrentmonth = "November";
                  break;
                case '12':
                  $Mycurrentmonth = "December";
                  break;
              }
              echo "<ol><span style=\"font-size:28px;font-weight:bold;\"> $Mycurrentmonth </span>\n";
              while($row = $retfly->fetchArray(SQLITE3_ASSOC) ){
                //eliminar al agregar palabras con espacios en campos de db
                if ($row['STATUS'] == "waiting"){
                  $mystatus2 = "Waiting";
                }elseif ($row['STATUS'] == "inprogress") {
                  $mystatus2 = "In Progress";
                }elseif ($row['STATUS'] == "done") {
                  $mystatus2 = "Done";
                }else{
                  $mystatus2 = "Stopped";
                }
                //eliminar al agregar palabras con espacios en campos de db
                echo "<li class=\"mymainli\"><ul class=\"mynone\">\n";
                echo "<li>" . $row['TITLE'] . " | <span class=\"mydesctitle\">See description </span> |<br> <span style=\"font-weight:bold;\"> Start Date:</span>" . $row['STARTDATE'] . "  <span style=\"font-weight:bold;\">End Date:</span> <span style=\"font-weight:normal;\" class=\"" . strtolower(str_replace(' ', '', $row['STATUS'])) ."\">" . $row['ENDDATE'] . "</span></li>\n";
                echo "<li class=\"mydescbox inset2\">\n";
                echo "<p>" . $row['DESCRIPTION'] . "</p>\n";
                echo "<span class=" . strtolower(str_replace(' ', '', $row['STATUS'])) . ">Status:</span><br />\n";
                echo "<p>" . $row['ACTIONLOG'] . "</p>\n";
                echo "</li>\n";
                echo "</ul>\n";
                echo "<div class=\"progress bar2\" style=\"width:92%;\">\n";
                echo "<span class=\"color" . rand(1,4) . "\" style=\"width:" . $row['PROGRESSBAR'] . "%;\"><span>" . $row['PROGRESSBAR'] . "%</span></span>\n";
                echo "</div>\n";
                echo "</li>\n";
              } // termina mi while
              echo "</ol>\n";
            } // termina el super FOR
          ?>
          </div>
          <div class="break-a"></div>
        </div>
      </div> 
      <div class="span" value="3.5"></div>
      <div class="bottext grid-12">
        <h2><center>Tan simple como sea posible.</center></h2>
      </div>
      <div class="span" value="3.5"></div>
      <div class="break-a"></div>
      <div class="center">
        <img src="img/down.png" alt="">
      </div>
    </div><!--END GRIDS-->
  </div><!--END WRAP-->
  <div class="footer_union">&nbsp</div>
  <footer>
    <div class="footer wrap">
      <!-- <img src="img/kraken.png" class="grid-12"> -->
      <div class="grid-4 center">
        <div class="span" value="5"></div>
        <img src="img/minKraken.png" alt="">
        <h5>@ 2013 Kraken</h5>
      </div>
      <div class="grid-2">
        <div class="span" value="5"></div>
        <h3>Home</h3>
        <ul class="size-3">
          <li>Grids</li>
          <li>Slider</li>
        </ul>
      </div>
      <div class="grid-2">
        <div class="span" value="5"></div>
        <h3>Test</h3>
        <ul class="size-3">
          <li>test</li>
          <li>test</li>
        </ul>
      </div>
      <div class="grid-2">
        <div class="span" value="5"></div>
        <h3>Test</h3>
        <ul class="size-3">
          <li>test</li>
          <li>test</li>
        </ul>
      </div>
      <div class="grid-2">
        <div class="span" value="5"></div>
        <h3>Test</h3>
        <ul class="size-3">
          <li>test</li>
          <li>test</li>
        </ul>
      </div>
    </div>
  </footer>
  <!-- <div class="bottom-bar center">hola</div> -->
</body>
</html>
<!doctype html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Admin Area</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=no">

	<link rel="stylesheet" href="../css/kraken.css">

	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
  <script src="../js/responsiveslides.min.js"></script>
  <script src="../js/kraken.js"></script>

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
<style type="text/css">

  input, textarea{
    width:350px;
  }
  label{
    display: block;
    width: 200px;


  }
  textarea{
    height: 150px;

  }




  .mydate{
    width: 100%;
    height: auto;
    text-align: right;
  }
  .mytaskstitle h6{
    margin: 0;
    padding: 0;
    width: 100%;
    height: auto;
    text-align: right;
  }
  .nomargin{
    margin: 0;
  }
  ul{
    margin-left: 40px;
  }

  .mymainli{
    padding-bottom: 23px;
  }

  .mydesctitle{
    cursor: pointer;
    font-style: italic;
    text-decoration: underline;
  }
  .mydescbox{
    border: 1px solid white;
    width: 80%;
    height: auto;
    list-style-type: none;
    display: none;
    margin: 0 0 10px 0;
    padding: 0 0 0 15px;

  }
 
 .mynone{
    margin: 0;
    padding: 0;
    list-style-type: none;
  }

  .mydone{
    font-style: italic;
    font-weight: bold;
    color: #18C933;
  }

  .myinprogress{
  font-style: italic;
  font-weight: bold;
  color: #0B439E;
  }

  .mywaiting{
  font-style: italic;
  font-weight: bold;
  color: #F58916;
  }

  .mystoped{
  font-style: italic;
  font-weight: bold;
  color: #D11313;
  }
</style>

  <!--[if lt IE 9]>
  <script src="http://css3-mediaqueries-js.googlecode.com/files/css3-mediaqueries.js"></script>
  <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
  <![endif]-->

<script type="text/javascript">
  $(function(){
    
    $('.formadd').on('click', function (evt) {
    $('#formadd').submit();
    evt.preventDefault();
  });

    $('.formaddtask').on('click', function (evt) {
    $('#formaddtask').submit();
    evt.preventDefault();
  });

    $('.mysaveform').on('click', function (evt) {
    $('#mysaveform').submit();
    evt.preventDefault();
  });

  })();
</script>


</head>

<body>

<!-- MENU -->
<!-- <div class="background-top"></div> -->

<div id='menu'>
  <nav class="nav center">
    <ul>
      <li class="current"><a href="../index.php">Home</a></li>
      <li><a href="../history.php">History</a></li>
    </ul>
  </nav>
</div>

<!--WRAP-->
<div class="wrap">

	<!--GRIDS-->
	<div class="grids">

<div class="span" value="4.5"></div>

<div class="grid-12 mL">
<div class="mytaskstitle"><h6>myTasks Informer v0.2</h6></div>
<div class="mydate"><date><?php echo date('l jS \of F Y h:i:s A'); ?></date></div>
  <div class="grid-10">

    <h1 title="Activities" style="margin-top:0;">
      Adminarea
    </h1>
    
  </div>

  <div class="grid-12 box solid">


    

      <?php

        $addnew = isset($_POST['addnew']) ? $_POST['addnew'] : null ;
        $addtask = isset($_POST['addtask']) ? $_POST['addtask'] : null ;

        if (isset($addtask)){
          $title = $_POST['title'];
          $category = $_POST['category'];
          $description = $_POST['description'];
          
          
          
          $startdate = date('Y-m-d H:i:s');
          // inserta el nuevo TASK
          class MyDB extends SQLite3
   {
      function __construct()
      {
         $this->open('db/mytasks.db');
      }
   }
   $db = new MyDB();
   if(!$db){
      echo $db->lastErrorMsg();
   }

   $sql =<<<EOF
      INSERT INTO TASKS (TITLE,CATEGORY,DESCRIPTION,ACTIONLOG,STATUS,PROGRESSBAR,STARTDATE,ENDDATE)
      VALUES ('$title', '$category', '$description', '', 'waiting', '0', '$startdate', '' );
EOF;

   $ret = $db->exec($sql);
   if(!$ret){
      echo $db->lastErrorMsg();
   } else {
      echo "Record created successfully, Redirecting . . .\n";
      echo "<script>setTimeout(function(){location.reload()}, 1500);</script>";


   }
   $db->close();

        }
          if (!isset($_POST['mywhile'])){
        if (isset($addnew)){
      ?>

        <form action="" method="post" id="formaddtask">
          <label for "title">Title</label>
          <input type="text" name="title"> <br /><br />

          <label for "description">Description</label>
          <textarea name="description"></textarea> <br /><br />

          <label for "category">Category</label>
          <select name="category">
            <option value="onthefly">On the Fly</option>
            <option value="active">Active</option>
            <option value="passive">Passive</option>
          </select> <br /><br />

          <input type="hidden" name="addtask" value="addtask">

          <a href="#" class="button primary formaddtask">Add Task</a>

          </form>
      <?php
        }else{

    ?>
    <form method="post" action="" id="formadd">
      <input type="hidden" name="addnew" value="addnew">
      <a href="#" class="button icon add formadd">New Task</a>
      </form>

         <?php
        }// termina el new task

    }//termina la comprobación de si existe la variable GUARDADO
        if (!isset($addnew)){  //se repite el isset addnew para que NO mueste los tasks existentes si se esta creando uno nuevo
        
      ?>
          <div class="toptext">
        <h2 class="nomargin">Tasks:</h2><br />
      </div>
      <div class="midtext">
        <?php 
        $mywhile = isset($_POST['mywhile']) ? $_POST['mywhile'] : null ;;
          if (isset($mywhile)){
            class MyDB extends SQLite3
   {
      function __construct()
      {
         $this->open('db/mytasks.db');
      }
   }
   $db = new MyDB();
   if(!$db){
      echo $db->lastErrorMsg();
   }
            
            $i = 1;
            while($i <> $mywhile ){
              $myid = $_POST['ID' . $i];
              $title = $_POST['title' . $i];
              $category = $_POST['category' . $i];
              $status = $_POST['status' . $i];
              $progressbar = $_POST['progressbar' . $i];
              $description = $_POST['description' . $i];
              $actionlog = $_POST['actionlog' . $i];
              $myenddate = $_POST['myenddate' . $i];

              $sql =<<<EOF
      UPDATE TASKS set TITLE = "$title" where ID=$myid;
      UPDATE TASKS set CATEGORY = "$category" where ID=$myid;
      UPDATE TASKS set STATUS = "$status" where ID=$myid;
      UPDATE TASKS set PROGRESSBAR = "$progressbar" where ID=$myid;
      UPDATE TASKS set DESCRIPTION = "$description" where ID=$myid;
      UPDATE TASKS set ACTIONLOG = "$actionlog" where ID=$myid;
      UPDATE TASKS set ENDDATE = "$myenddate" where ID=$myid;
EOF;
   $ret = $db->exec($sql);
   if(!$ret){
      echo $db->lastErrorMsg();
   }else{
    $mysuccess = " Record(s) updated successfully, Redirecting . . .\n";
   }
              

              $i++;
            } //cierra mi while
            $db->close();
            echo $mysuccess;
      echo "<script>setTimeout(function(){location.reload()}, 1200);</script>";

   
            
            



            
          }else{

        ?>


    <form action="" method="post" class="smallform" id="mysaveform">
    <a href="#" class="button icon approve mysaveform">Save Changes</a>
         
    <?php
    
   class MyDB extends SQLite3
   {
      function __construct()
      {
         $this->open('db/mytasks.db');
      }
   }
   $db = new MyDB();
   if(!$db){
      echo $db->lastErrorMsg();
   } 

   $sql =<<<EOF
      SELECT * from TASKS where ENDDATE="";
EOF;
  $ret = $db->query($sql);
  
  $mywhile = 1;
   
   while($row = $ret->fetchArray(SQLITE3_ASSOC) ){
      echo "<input type=\"hidden\" name=\"ID" . $mywhile . "\" value=\"" . $row['ID'] . "\">\n";
      echo "<table border=\"2\" cellpadding=\"2\" cellspacing=\"3\">\n";
      echo "<tr>\n";
      echo "<td>Title</td>\n";
      echo "<td>Category</td>\n";
      echo "<td>Status</td>\n";
      echo "<td>Progress</td>\n";
      echo "<td style=\"font-size:12px;text-align:center;\">Start Date</td>\n";
      echo "<td style=\"font-size:12px;text-align:center;\">End Date</td>\n";
      echo "</tr>\n";
      echo "<tr>\n";

      echo "<td><input type=\"text\" name=\"title" . $mywhile . "\" style=\"width:260px;\" value=\"" . $row['TITLE'] . "\"></td>\n";

      echo "<td><select name=\"category" . $mywhile . "\">\n";

      $catonthefly = "";
      $catactive = "";
      $catpassive = "";

      if ($row['CATEGORY'] == "onthefly"){
        $catonthefly = "selected";
      }elseif ($row['CATEGORY'] == "active") {
        $catactive = "selected";
      }else{
        $catpassive = "selected";
      }
      echo "<option value=\"onthefly\" " . $catonthefly . ">On the fly</option>\n";
      echo "<option value=\"active\" " . $catactive . ">Active</option>\n";
      echo "<option value=\"passive\" ". $catpassive . ">Passive</option>\n";
      echo "</select></td>\n";

          

      echo "<td><select name=\"status" . $mywhile . "\">\n";
      $catwaiting = "";
      $catinprogress = "";
      $catstopped = "";
      $catdone = "";

      if ($row['STATUS'] == "waiting"){
        $catwaiting = "selected";
      }elseif ($row['STATUS'] == "inprogress") {
        $catinprogress = "selected";
      }elseif ($row['STATUS'] == "stopped") {
        $catstopped = "selected";
      }else{
        $catdone = "selected";
      }
      echo "<option value=\"waiting\" " . $catwaiting . ">Waiting</option>\n";
      echo "<option value=\"inprogress\" " . $catinprogress . ">In Progress</option>\n";
      echo "<option value=\"stopped\" " . $catstopped . ">Stopped</option>\n";
      echo "<option value=\"done\" " . $catdone . ">Done</option>\n";
      echo "</select></td>\n";

      echo "<td><input type=\"text\" name=\"progressbar" . $mywhile . "\" style=\"width:50px;\" value=\"" . $row['PROGRESSBAR'] . "\"></td>\n";
      echo "<td style=\"width:70px;font-size:11px;text-align:center;\">" . $row['STARTDATE'] . "</td>\n";
      echo "<td style=\"width:70px;font-size:11px;text-align:center;\">date out</td>\n";

      echo "</tr>\n";
      echo "<tr>\n";
      echo "<td colspan=\"2\">Description:<br /><textarea name=\"description" . $mywhile . "\" style=\"width:340px;height:60px;\">" . $row['DESCRIPTION'] . "</textarea></td>\n";
      echo "<td colspan=\"4\">Action Log:<br /><textarea name=\"actionlog" . $mywhile . "\" style=\"width:340px;height:60px;\">" . $row['ACTIONLOG'] . "</textarea></td>\n";
      echo "</tr>\n";

      if ($row['STATUS'] == "done"){
        $theenddate = date('Y-m-d H:i:s');
        echo "<input type=\"hidden\" name=\"myenddate" . $mywhile . "\" value=\"" . $theenddate . "\">\n";
      }

      echo "</table><br /><br />\n";

      $mywhile = 1 + $mywhile;

   }

   $db->close();

          
      ?>

  
      <a href="#" class="button icon approve mysaveform">Save Changes</a>
      <input type="hidden" value="<?php echo $mywhile ?>" name="mywhile"> 
      </form>


      <?php
    }
        }//termina el add new task comprobador
      ?>
      </div>

  </div>

</div> <!-- termina contenido -->



<div class="span" value="3.5"></div>

      <div class="bottext grid-12">
        <h2>
            <center>Tan simple como sea posible.</center>
        </h2>
      </div>

<div class="span" value="3.5"></div>
 
 <div class="break-a"></div>

 <div class="center">
   <img src="../img/down.png" alt="">
 </div>

<!--END GRIDS-->
  </div>

<!--END WRAP-->
</div>


<div class="footer_union">&nbsp</div>
<footer>
  <div class="footer wrap">
  <!-- <img src="img/kraken.png" class="grid-12"> -->
    <div class="grid-4 center">
      <div class="span" value="5"></div>
      <img src="../img/minKraken.png" alt="">
      <h5>@ 2013 Kraken</h5>
    </div>

    <div class="grid-2">
      <div class="span" value="5"></div>
      <h3>
          Home
      </h3>
      <ul class="size-3">
        <li>Grids</li>
        <li>Slider</li>
      </ul>
    </div>

    <div class="grid-2">
      <div class="span" value="5"></div>
      <h3>
          Test
      </h3>
      <ul class="size-3">
        <li>test</li>
        <li>test</li>
      </ul>
    </div>
        <div class="grid-2">
      <div class="span" value="5"></div>
      <h3>
          Test
      </h3>
      <ul class="size-3">
        <li>test</li>
        <li>test</li>
      </ul>
    </div>

        <div class="grid-2">
      <div class="span" value="5"></div>
      <h3>
          Test
      </h3>
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


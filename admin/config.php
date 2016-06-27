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
      CREATE TABLE TASKS
      (ID INTEGER PRIMARY KEY     AUTOINCREMENT,
      TITLE           TEXT,
      CATEGORY        VARCHAR(100),
      DESCRIPTION     TEXT,
      ACTIONLOG       TEXT,
      STATUS          VARCHAR(50),
      PROGRESSBAR     INT(10),
      STARTDATE       DATE,
      ENDDATE         DATE);
EOF;

   $ret = $db->exec($sql);
   if(!$ret){
      echo $db->lastErrorMsg();
   }
   $db->close();
?>



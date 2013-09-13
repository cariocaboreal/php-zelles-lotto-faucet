<?php
error_reporting(0);

$allow_every = 'hour';
// $allow_every = 'day';

$database = (object) array('db_host' => 'localhost',
                     'db_user' => 'YourUsername',
                     'db_pass' => 'YourPassword',
                     'db_name' => 'YourDatabaseName');

$db_connection = mysql_connect($database->db_host,$database->db_user,$database->db_pass);
if(!$db_connection) { die("Error connecting to the database."); }
if(!mysql_select_db($database->db_name)) { die("Error connecting to the specified database."); }

mysql_query("CREATE TABLE IF NOT EXISTS zelles_lotto (z_id INT NOT NULL AUTO_INCREMENT, PRIMARY KEY(z_id), z_date VARCHAR(300), z_day VARCHAR(300), z_hour VARCHAR(300), z_ip VARCHAR(30), z_address TEXT, z_status VARCHAR(300))");

$date = strtotime('now');
$ip = $_SERVER['REMOTE_ADDR'];
$day = date('j');
$hour = date('G');

if(isset($_GET['ajax'])) {
   if($_GET['address']!='') {
      $address = addslashes(strip_tags($_GET['address']));
      if($allow_every=='hour') { $Query = mysql_query("SELECT z_ip FROM zelles_lotto WHERE z_ip='$ip' and z_day='$day' and z_hour='$hour'"); }
      else { $Query = mysql_query("SELECT z_ip FROM zelles_lotto WHERE z_ip='$ip' and z_day='$day'"); }
      if(mysql_num_rows($Query)===0) {
         if($allow_every=='hour') { $Query = mysql_query("SELECT z_address FROM zelles_lotto WHERE z_address='$ip' and z_day='$day' and z_hour='$hour'"); }
         else { $Query = mysql_query("SELECT z_address FROM zelles_lotto WHERE z_address='$ip' and z_day='$day'"); }
         if(mysql_num_rows($Query)===0) {
            $random = rand(1,2);
            if($random==1){
               $Function_Query = mysql_query("INSERT INTO zelles_lotto (z_id,z_date,z_day,z_hour,z_ip,z_address,z_status) VALUES ('','$date','$day','$hour','$ip','$address','pending')");

               // send the coins to $address or you can send in batches and set paid/pending using z_status

               echo '<img src="winner.jpg">
                     <div style="margin-top: 20px;">Coins would be sent to '.$address.'.</div>';
            } else {
               echo '<img src="loser.jpg">
                     <div style="margin-top: 20px;">You lost this ticket. <a href="index.php">Try again.</a>.</div>';
            }
         } else {
            echo '<img src="lotto.jpg">
                  <div style="margin-top: 20px;">No address was entered. <a href="index.php">Try again.</a>.</div>';
         }
      } else {
         if($allow_every=='hour') { $ticket_msg = 'this hour'; }
         else { $ticket_msg = 'today'; }
         echo '<img src="lotto.jpg">
               <div style="margin-top: 20px;">You have already won on a ticket '.$ticket_msg.'.</div>';
      }
   } else {
      if($allow_every=='hour') { $ticket_msg = 'this hour'; }
      else { $ticket_msg = 'today'; }
      echo '<img src="lotto.jpg">
            <div style="margin-top: 20px;">You have already won on a ticket '.$ticket_msg.'.</div>';
   }
   mysql_close($db_connection);
   die('');
   exit;
}
mysql_close($db_connection);
?>
<html>
<head>
   <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0"/>
   <style type="text/css">
      body {
         font-family: tahoma;
         font-size: 12px;
      }
      a {
         text-decoration: none;
      }
      #lotto-ticket {
         width: 300px;
         max-width: 300px;
         min-width: 300px;
         height: 160px;
         max-height: 160px;
         min-height: 160px;
         background: url('lotto.jpg');
         border-collapse: collapse;
      }
      #lotto-ticket td {
         width: 50px;
         max-width: 50px;
         min-width: 50px;
         height: 32px;
         max-height: 32px;
         min-height: 32px;
         background: #888888;
      }
      #coin-address {
         width: 320px;
         margin-top: 20px;
      }
   </style>
   <script type="text/javascript" src="jquery-1.9.1.js"></script>
   <script language="javascript">
      var lotto_count = 0;
      function lotto_scratcher(id) {
         if(document.getElementById(id).style.backgroundColor != 'transparent') {
            lotto_count++;
            document.getElementById(id).style.backgroundColor = 'transparent';
            if(lotto_count==30) {
               var coin_address = document.getElementById('coin-address').value;
               $('#lotto-ticket-div').load('index.php?ajax=true&address='+coin_address);
            }
         }
      }
   </script>
</head>
<body>
   <center>

   <h2><a href="index.php">Lotto Scratch Off</a></h2>

   <div id="lotto-ticket-div">
      <table id="lotto-ticket">
         <tr><td id="zelles10" onmouseover="lotto_scratcher('zelles10')"></td><td id="zelles11" onmouseover="lotto_scratcher('zelles11')"></td><td id="zelles12" onmouseover="lotto_scratcher('zelles12')"></td><td id="zelles13" onmouseover="lotto_scratcher('zelles13')"></td><td id="zelles14" onmouseover="lotto_scratcher('zelles14')"></td><td id="zelles15" onmouseover="lotto_scratcher('zelles15')"></td></tr>
         <tr><td id="zelles20" onmouseover="lotto_scratcher('zelles20')"></td><td id="zelles21" onmouseover="lotto_scratcher('zelles21')"></td><td id="zelles22" onmouseover="lotto_scratcher('zelles22')"></td><td id="zelles23" onmouseover="lotto_scratcher('zelles23')"></td><td id="zelles24" onmouseover="lotto_scratcher('zelles24')"></td><td id="zelles25" onmouseover="lotto_scratcher('zelles25')"></td></tr>
         <tr><td id="zelles30" onmouseover="lotto_scratcher('zelles30')"></td><td id="zelles31" onmouseover="lotto_scratcher('zelles31')"></td><td id="zelles32" onmouseover="lotto_scratcher('zelles32')"></td><td id="zelles33" onmouseover="lotto_scratcher('zelles33')"></td><td id="zelles34" onmouseover="lotto_scratcher('zelles34')"></td><td id="zelles35" onmouseover="lotto_scratcher('zelles35')"></td></tr>
         <tr><td id="zelles40" onmouseover="lotto_scratcher('zelles40')"></td><td id="zelles41" onmouseover="lotto_scratcher('zelles41')"></td><td id="zelles42" onmouseover="lotto_scratcher('zelles42')"></td><td id="zelles43" onmouseover="lotto_scratcher('zelles43')"></td><td id="zelles44" onmouseover="lotto_scratcher('zelles44')"></td><td id="zelles45" onmouseover="lotto_scratcher('zelles45')"></td></tr>
         <tr><td id="zelles50" onmouseover="lotto_scratcher('zelles50')"></td><td id="zelles51" onmouseover="lotto_scratcher('zelles51')"></td><td id="zelles52" onmouseover="lotto_scratcher('zelles52')"></td><td id="zelles53" onmouseover="lotto_scratcher('zelles53')"></td><td id="zelles54" onmouseover="lotto_scratcher('zelles54')"></td><td id="zelles55" onmouseover="lotto_scratcher('zelles55')"></td></tr>
      </table>
   </div>

   <input type="text" id="coin-address" placeholder="Enter your Franko address." autofocus>

   <div style="margin-top: 20px;">This demo does not pay out! Date: <?php echo date("n/j G a"); ?></div>

   <div style="margin-top: 20px;">
      Created by <a href="skype:zelles.?chat">zelles.</a> and posted on <a href="https://github.com/zelles/php-zelles-lotto-faucet" target="_blank">github</a>. With <a href="http://lotto.hostpile.info/" target="_blank">demo</a>.<br>
      <font style="font-size: 11px;">Donate using Franko: FTs84CKHw8uu8RGvFw4nq1yc4tRT49wVLS</font>
   </div>

   </center>
</body>
</html>
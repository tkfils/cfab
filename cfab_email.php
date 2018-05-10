<?php
$to ="ha.nguyen@kingsfund.org.uk";
#$to = "m.hale@kingsfund.org.uk".", ";
#$to = "m.hale@kingsfund.org.uk";
$subject ="CfAB Selections - ";
$when= date("Y-m-d");
$subject .=$when;
$headers = "Content-Transfer-Encoding: base64\r\n";
$headers .= "Content-type: text/html; charset=UTF-8\r\n";
$headers .= "MIME-Version: 1.0\r\n";

$db = mysqli_connect("localhost", "database", "password", "table");


$body = "<html><head>";
$body .= "<meta http-equiv='Content-type' content='text/html;charset=UTF-8'></head>";
$body .="<body style='font-size:11pt;font-family:Calibri';>";

$result = mysqli_query($db,"select d.author, d.title, d.description, d.link, d.date from data d, lastsent l where d.work='y' and l.id=13 and d.date_added  > l.lastsent");
$num=mysqli_num_rows($result);
if ($num > 0) {
$body .= "<h3>Work and Finance</h3>";
}

$i=0;

while ($i < $num) 						{
$row = mysqli_fetch_row($result);
$body.= "<strong>".$row[1]."</strong>";
$body .= "<br>";
$body .= $row[0];
$body .= "<br>";
$body .= $row[4];
$body .= "<br>";
$body .= $row[2];
$body .= "<br>";
$body .= "<a href='".$row[3]."'>".$row[3]."</a>";
$body.="<p>";

$i++;
}


$result = mysqli_query($db,"select d.author, d.title, d.description, d.link, d.date from data d, lastsent l where d.housing='y' and l.id=13 and d.date_added > l.lastsent");
$num=mysqli_num_rows($result);
if ($num > 0) {
$body .= "<h3>Housing and Communities</h3>";
}

$i=0;

while ($i < $num) 						{
$row = mysqli_fetch_row($result);
$body.= "<strong>".$row[1]."</strong>";
$body .= "<br>";
$body .= $row[0];
$body .= "<br>";
$body .= $row[4];
$body .= "<br>";
$body.=$row[2];
$body .= "<br><a href='".$row[3]."'>".$row[3]."</a>";
$body.="<p>";

$i++;
}

$result = mysqli_query($db,"select d.author, d.title, d.description, d.link, d.date from data d, lastsent l where d.wellbeing='y' and l.id=13 and d.date_added > l.lastsent");
$num=mysqli_num_rows($result);
if ($num > 0) {
$body .= "<h3>Wellbeing</h3>";
}

$i=0;

while ($i < $num) 						{
$row = mysqli_fetch_row($result);
$body.= "<strong>".$row[1]."</strong>";
$body .="<br>";
$body .= $row[0];
$body .= "<br>";
$body .= $row[4];
$body .= "<br>";
$body .= $row[2];
$body .= "<br><a href='".$row[3]."'>".$row[3]."</a>";
$body.="<p>";

$i++;
}

$result = mysqli_query($db,"select d.author, d.title, d.description, d.link, d.date from data d, lastsent l where d.care='y' and l.id=13 and d.date_added > l.lastsent");
$num=mysqli_num_rows($result);
if ($num > 0) {
$body .= "<h3>Care</h3>";
}

$i=0;

while ($i < $num)                                               {
$row = mysqli_fetch_row($result);
$body.= "<strong>".$row[1]."</strong>";
$body .="<br>";
$body .= $row[0];
$body .= "<br>";
$body .= $row[4];
$body .= "<br>";
$body .= $row[2];
$body .= "<br><a href='".$row[3]."'>".$row[3]."</a>";
$body.="<p>";

$i++;
}

$body .= "</body></html>";

$sql="update lastsent set lastsent=CURRENT_DATE() where id=13";
mysqli_query($db,$sql);

mysqli_close($db);
$body1= chunk_split(base64_encode($body));

if (mail($to, $subject, $body1, $headers)) {
   echo("<p>Message successfully sent!</p>");
  } else {
   echo("<p>Message delivery failed...</p>");
         }
echo $body;

?>

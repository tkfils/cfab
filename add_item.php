<?php
$con = mysqli_connect("localhost", "db", "pass", "table");
if (!$con)
  {
  die('Could not connect: ' . mysqli_error());
  }
$title = $_POST['title'];
$author = $_POST['author'];
$link = $_POST['link'];
$description = $_POST['description'];
$date = $_POST['date'];
$work = $_POST['work'];
$housing = $_POST['housing'];
$wellbeing = $_POST['wellbeing'];
$care = $_POST['care'];
$sub1 = $_POST['sub1'];
$sub2 = $_POST['sub2'];
$sub3 = $_POST['sub3'];
$sub4 = $_POST['sub4'];
$sub5 = $_POST['sub5'];
$sub6 = $_POST['sub6'];
$sub7 = $_POST['sub7'];
$sub8 = $_POST['sub8'];


$title = mysqli_real_escape_string($con,$title);
$author = mysqli_real_escape_string($con,$author);
$link = mysqli_real_escape_string($con,$link);
$description = mysqli_real_escape_string($con,$description);

mysqli_query($con, "INSERT INTO data (title,author,link,description,date,work,housing,wellbeing,Care,fulfilling,home,changes,community,active,local,digital,later) VALUES ('$title','$author','$link','$description','$date','$work','$housing','$wellbeing','$care','$sub1','$sub2','$sub3','$sub4','$sub5','$sub6','$sub7','$sub8')");

$output= "<rss xmlns:dc='http://purl.org/dc/elements/1.1/' xmlns:content='http://purl.org/rss/1.0/modules/content/' version='2.0'>";
$output .= "<channel>";
$output .= "<title>Centre for Ageing Better alert</title>";
$output .= "<link>https://outlawjosey.wales/rss/cfab_alert.xml</link>";
$output .= "<description>RSS feed for Centre for Ageing Better alert</description>";
$output .= "<dc:language>en-uk</dc:language>";
$output .= "<dc:date>";
$output .= date("Y-m-d");
$output .= "</dc:date>";

$result = mysqli_query($con,"SELECT * FROM data");
while($array = mysqli_fetch_array($result)){
$output .= "<item>";
$output .= "<title>";
$output .= $array['title'];
$output .= "</title>";
$output .= "<dc:creator>";
$output .= $array['author'];
$output .= " ";
$output .= "</dc:creator>";
$output .= "<link>";
$output .= $array['link'];
$output .= "</link>";
$output .= "<description>";
$output .= "<![CDATA[";
$output .= $array['description'];
$output .= "]]>\n";
$output .= "</description>";
if ($array['fulfilling']=="y"){
$output .= "<dc:subject>";
$output .= "Being in fulfilling work";
$output .= "</dc:subject>";
}
if ($array['home']=="y"){
$output .= "<dc:subject>";
$output .= "Living in a suitable home and neighbourhood";
$output .= "</dc:subject>";
}
if ($array['changes']=="y"){
$output .= "<dc:subject>";
$output .= "Managing major life changes";
$output .= "</dc:subject>";
}
if ($array['community']=="y"){
$output .= "<dc:subject>";
$output .= "Contributing to communities";
$output .= "</dc:subject>";
}
if ($array['active']=="y"){
$output .= "<dc:subject>";
$output .= "Keeping physically active";
$output .= "</dc:subject>";
}
if ($array['local']=="y"){
$output .= "<dc:subject>";
$output .= "Taking a local approach to ageing";
$output .= "</dc:subject>";
}
if ($array['digital']=="y"){
$output .= "<dc:subject>";
$output .= "Getting the most out of digital";
$output .= "</dc:subject>";
}
if ($array['later']=="y"){
$output .= "<dc:subject>";
$output .= "Wellbeing in later life";
$output .= "</dc:subject>";
}
$output .= "<dc:date>";
$output .= $array['date'];
$output .= "</dc:date>";
$output .= "</item>";
}
$output .= "</channel>";
$output .= "</rss>";
$output = str_replace("&","&amp;",$output);


mysqli_close($con);

$file = fopen('cfab_alert.xml',"w");
fwrite($file,$output);
fclose($file);


echo "This item has been added:<br>";
 
$handle = popen("tail -n2 cfab_alert.xml 2>&1", 'r');
while(!feof($handle)) {
    $buffer = fgets($handle);
    echo "$buffer<br/>\n";
    ob_flush();
    flush();
}
pclose($handle);
echo "<br>";
echo "<a href='add_item_new.html'>Add another</a>";
echo "<br>";
echo "<a href='cfab_alert.xml'>View feed</a>";

?>

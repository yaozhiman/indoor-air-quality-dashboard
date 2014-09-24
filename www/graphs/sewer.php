<?php // content="text/plain; charset=utf-8"
include 'graph_base.php';

$result=mysqli_query($conn,"SELECT * from readings WHERE core_id=$id and ts>= $start_ts and ts<= $end_ts order by ts"); 
$ts=Array();
$sewer=Array();
$level=Array();
while($row = mysqli_fetch_array($result)) {
	$ts_str=gmdate('r', $row['ts']);
	error_log("temp=".$row['temperature']."||humidity=".$row['humidity']."||ts=".$row['ts']."||ts=".$ts_str);
	$ts[]=$row['ts'];
	$sewer[]=$row['sewer'];
	$level[]=1000;
}
$sewer_plot=new LinePlot($sewer,$ts);
$sewer_plot->SetColor('darkgoldenrod');
$sewer_plot->SetWeight(2);
$level_plot=new LinePlot($level,$ts);

$graph = new Graph($width,$height);
$graph->SetFrame(false);
$graph->SetBackgroundImage('traffic33_66.png',BGIMG_FILLPLOT);
$graph->SetBackgroundImageMix(35);
$graph->SetMargin(60,60,40,50);
$graph->SetMarginColor('white');
$graph->SetScale('datlin',0,1500);
$graph->Add($sewer_plot);

$graph->xaxis->SetLabelAngle(90);
$graph->xaxis->scale->SetDateFormat('g a');
$graph->xaxis->SetWeight(2);
$graph->xaxis->SetFont(FF_ARIAL,FS_NORMAL,$font_size-3);

$graph->yaxis->SetWeight(2);
$graph->yaxis->SetColor('darkgoldenrod');
$graph->yaxis->SetFont(FF_ARIAL,FS_NORMAL,$font_size-3);
$graph->yaxis->title->SetColor('darkgoldenrod');
$graph->yaxis->title->Set('Sewer');
$graph->yaxis->title->SetFont(FF_ARIAL,FS_BOLD,$font_size);
$graph->yaxis->title->SetAngle(90);
$graph->yaxis->title->SetMargin(10);

// Display the graph
$graph->Stroke();
?>
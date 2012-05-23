<?php
$format=$_POST['format'];

if ($format=="XLIFF")
{
header('Location: ./pmuixlf.php');
} else
{
header('Location: ./pmuitxt.php');
}
?>
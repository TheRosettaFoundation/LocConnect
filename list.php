<?php
require_once('./conf.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml">
<head id="Head1">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.5.2/jquery.min.js" type="text/javascript" language="javascript"></script>
    <script src="js/jQuery.dualListBox-1.3.min.js" language="javascript" type="text/javascript"></script>
    <script language="javascript" type="text/javascript">
        $(function() {
            $.configureBoxes();
        });
    </script>
    <!--<link href="styles/styles.css" type="text/css" rel="Stylesheet" />-->
	
	<title>test</title>
</head>
<body>
    <form name="form1" method="post" action="listpro.php" id="form1">
<div>
<input type="hidden" name="__VIEWSTATE" id="__VIEWSTATE" value="/wEPDwUKMTk5MjI0ODUwOWRkA+3uwu7ozEmRbyMvuoC8w6qxqko=" />
</div>

    <div>
	
	Upload, select or create LMC file from previous locConnect projects:<br>
	
	LMC Description:
	<input type="text" name="lmcdesc" /> <br>
	
<select name="prevlmc">
  
	<option value="0" selected>(select previous LMC file:)</option> 
	<?php
						 try
						{
						//open the database
						$db = new PDO('sqlite:'.BASE_DB_URL.'locTemp.sqlite');
						$res = $db->query('SELECT ResourceID,Description,Type FROM Resources');
							foreach($res as $row)
							{
								$title= strlen($row['Description'])>30?substr($row['Description'],1,30):$row['Description'];
								if ($row["Type"]=="LMC")
									print "<option value='".$row['ResourceID']."' title='".$title."'>".$title."</option>";
							}
							
					  }
					  catch(PDOException $e)
					  {
						//print 'Exception : '.$e->getMessage();
					  }
					  	$db = NULL;
	?>
				</select>
	
	

    <table>
            <tr>
                <td>
                        Filter: <br> <input type="text" id="box1Filter" size="15" /><button type="button" id="box1Clear">X</button><br />

                        <select id="box1View" multiple="multiple" style="height:100px;width:300px;">
						<?php
						 try
						{
						//open the database
						$db = new PDO('sqlite:'.BASE_DB_URL.'locTemp.sqlite');
						
						$res = $db->query('SELECT ID,PName,Desc, Output FROM Project');
						foreach($res as $row)
						{
							$title= strlen($row['Desc'])>30?substr($row['Desc'],1,30):$row['Desc'];
							if (trim($row['Output']!=""))
								print "<option value='".$row['ID']."' title='".$title."'>".$row['PName']."</option>";
						}
						
						
						
						// close the database connection
						$db = NULL;
					  }
					  catch(PDOException $e)
					  {
						//print 'Exception : '.$e->getMessage();
					  }
					?>
                        </select><br/>
                         <span id="box1Counter" class="countLabel"></span>
                       <select id="box1Storage" >
                        </select>
                </td>
                <td>
                    <button id="to2" type="button">&nbsp;>&nbsp;</button>
                    <button id="allTo2" type="button">&nbsp;>>&nbsp;</button>

                    <button id="allTo1" type="button">&nbsp;<<&nbsp;</button>
                    <button id="to1" type="button">&nbsp;<&nbsp;</button>
                </td>
                <td>
                    Filter:<br> <input type="text" id="box2Filter" /><button type="button" id="box2Clear">X</button><br />
                    <select name="selectlmc[]" id="box2View" multiple="multiple" style="height:100px;width:300px;">

                    </select><br/>
                    <span id="box2Counter" class="countLabel"></span>
                    <select id="box2Storage">
                    </select>
                </td>
            </tr>
        </table>
    </div>
	
	<input type="submit" value="Submit">
	
    </form>

</body>
</html>

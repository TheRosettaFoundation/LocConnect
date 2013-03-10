<?php
class XliffParser
{
    private $domDoc;

    function XliffParser($xliff_source)
    {
        $this->domDoc = new DomDocument();
        $this->domDoc->loadXML($xliff_source);
    }

    function printTranslationInfo($download = false)
    {
        print '<center> <a href="#" id="trans"><h2>'.BASE_XLFV_TRAN.'</h2> </a></center>';
        if($download) {
            print '<center><p class="txt"><a id="closet" href="#"> <em>'.BASE_XLFV_HIDET.'</em> </a></p></center><br/>' ;
            $this->printDownloadInfo();
        }
        print '<div id="translate">';
        print '<table class="trans" border="0" cellpadding="3" cellspacing="0" align="center"><tbody>';
        $nodes = $this->domDoc->getElementsByTagName("trans-unit");
        //print '<tr class="header"><td colspan="2" rowspan="1">XLIFF Count Group Metadata</td></tr>';
        foreach ($nodes as $node)
        {
            $name =$node->getAttribute("id");
            if ($node->hasChildNodes())
            {
                //Check if the current segment is supposed to be translated
                $tag = $node;
                $foundTransAtt = false;
                $translateSeg = true;
                while(strcasecmp($tag->nodeName, "file") != 0 && !($foundTransAtt)) {
                    $translate = $tag->getAttribute('translate');
                    if($translate !== NULL) {
                        if($translate == 'no') {
                            $translateSeg = false;
                        }
                        $foundTransAtt = true;
                        $tag = $tag->parentNode;
                    }
                }
                        
                $sourceNode=$node->getElementsByTagName("source");
                $reference_list = array();  //assiciative array of text => reference
                $comment_list = array();    //associative array of text => comment
                if ($sourceNode->length>0) $source=$sourceNode->item(0)->nodeValue ;else $source=BASE_XLFV_SRCERR;
                if (trim($source)=="") {
                    $source=BASE_XLFV_SRCERR;
                } else {
                    $node = $sourceNode->item(0);
                    $source = "";
                    if($node->hasChildNodes()) {
                        $child = $node->firstChild;
                        while($child != NULL) {
                            if(strcasecmp($child->nodeName, "mrk") == 0) {
                                $mtype = $child->getAttribute("mtype");
                                if($mtype != NULL) {
                                    if(strcasecmp($mtype, "phrase") == 0) {
                                        $source .= " ".$child->nodeValue;
                                        $text = $child->nodeValue;
                                        $ref = $child->getAttribute("url");
                                        if($ref == NULL) {
                                            $ref = $child->getAttribute("disambigIdentRef");
                                        }
                                        if($ref != NULL) {
                                            $source .= "<sup><a target='_blank' href='$ref'>[ref]</a></sup>";
                                            $comment = $child->getAttribute('comment');
                                            if($comment != NULL) {
                                                $comment_list[$text] = $comment;
                                            }
                                            $reference_list[$text] = $ref;
                                        }
                                    } else if(strcasecmp($mtype, "x-DNT") == 0 || strcasecmp($mtype, "preserve") == 0) {
                                        $source .= " <span class='no-translate'>";
                                        $source .= $child->nodeValue;
                                        $source .= "</span>";
                                    }
                                }
                            } else {
                                $source .= " ".$child->nodeValue;
                            } 
                            $child = $child->nextSibling;
                        }
                    }
                }
            }
            $targetNode=$node->getElementsByTagName("target");
            //print $node->hasElement("target");
            if ($targetNode->length>0) $target=$targetNode->item(0)->nodeValue; else $target=BASE_XLFV_TGTERR;
            if (trim($target)=="") $target=BASE_XLFV_TGTERR;
            $altTrans=$node->getElementsByTagName("alt-trans");
            print '<tr class="header"><td colspan="4" rowspan="1">'.$name.'</td></tr>';
            print '<tr class="row" id="src">';
            if($translateSeg) {
                print '<td>'.BASE_XLFV_SRC.'</td>';
                print '<td colspan="3" rowspan="1">';
//                print htmlentities($source,ENT_QUOTES,'UTF-8');
                print $source;
                //print $source;
                print '</td>';
            } else {
                print '<td class="no-translate">'.BASE_XLFV_SRC.'</td>';
                print '<td colspan="3" rowspan="1" class="no-translate" title="Do not translate this text">';
                print htmlentities($source,ENT_QUOTES,'UTF-8');
                //print $source;
                print '</td>';
            }
            print '</tr>';
            print '<tr id="tgt">';
            print '<td>'.BASE_XLFV_TGT.'</td>';
            print '<td colspan="3" rowspan="1" ';
            if($download && $translateSeg) {
                print "class='dblclick' id='$name'";
            }
            print '>'.htmlentities($target,ENT_QUOTES,'UTF-8').'</td>';
                    
            print '</tr>';
                     
            if ($altTrans->length>0)
            {
                $k=0;
                foreach ($altTrans as $alt)
                {
                    $k++;
                    $altval=$alt->nodeValue;
                    if ($k==1) {
                        print '<tr class="row-no-click"><td colspan="1" rowspan="'.(string)$altTrans->length.'">'.BASE_XLFV_ALT.'</td>'; 
                    } else {
                        print "<tr class='row-no-click'>";
                    }
                    if ($altval!="") {
                        print '<td class="alt">'.$altval.'</td>';
                    } else {
                        print '<td> <em>'.BASE_XLFV_ALTERR.' </em> </td>';
                    }
                    $temp="";
                    $length = $alt->attributes->length;
                    for ($i = 0; $i < $length; ++$i)
                    {
                        $att =$alt->attributes->item($i)->name;
                        $val=$alt->attributes->item($i)->value;
                        if ($att!="match-quality") $temp=$temp.$att. " : ".$val. "<br/>";
                    }
                    $mq =$alt->getAttribute("match-quality");
                    if ($mq=="" or $mq==NULL) $mq="N/A";
                    print '<td class="red" id="altb">'.$mq.'</td><td class="txt" id="altb">'.$temp.'</td></tr>';
                }
            } else {
                print '<tr class="row-no-click"><td colspan="4" rowspan="1" class="alt"> <em>'.BASE_XLFV_ALTERR.'</em> </td></tr>';
            }

            if(count($reference_list) > 0) {
                print "<tr class='row-no-click'>";
                print "<td colspan='4'>";
                print "<h3>References</h3>";
                print "<ul>";
                foreach($reference_list as $key => $reference) {
                    print "<li>";
                    print "<a target='_blank' href=$reference>$key</a>";
                    if(isset($comment_list[$key])) {
                        print " - ".$comment_list[$key];
                    }
                    print "</li>";
                }
                print "</ul>";
                print "</td>";
                print "</tr>";
            }
        }
        print '</tbody></table>';
        print '<center><p class="txt"><a id="closet" href="#"> <em> '.BASE_XLFV_HIDET.' </em> </a></p></center></div>' ;
    }

    function printMetaData()
    {
        print '<center> <a href="#" id="meta"><h2>'.BASE_XLFV_META.'</h2> </a></center>';
        print '<center><p class="txt"><a id="close" href="#"> <em> hide Metadata </em> </a></p></center>' ;
        print '<div id="metadata">';
        print '<table class="meta" border="0" cellpadding="2" cellspacing="0" align="center">';

        $tagNames = array('pmui-data' => BASE_T_XMETA, 'file' => BASE_T_XFILE, 
                            'task' => BASE_T_XWF, 'phase' => BASE_T_XPM, 
                            'tool' => BASE_T_XTM);
        foreach($tagNames as $tagName => $displayName)
        {
            $nodes = $this->domDoc->getElementsByTagName($tagName);
            print '<tr class="header"><td colspan="2" rowspan="1">'.$displayName.'</td></tr>';

            foreach ($nodes as $node)
            {
                $length = $node->attributes->length;
                for ($i = 0; $i < $length; ++$i)
                {
                    $name =$node->attributes->item($i)->name;
                    $val =$node->attributes->item($i)->value;
                    if ($val!="") {
                        print "<tr class='row'><td class='bold'>".$name."</td><td>".$val."</td></tr>";
                    }
                }
                print '<tr class="blankrow"><td colspan="2" rowspan="1">&nbsp;</td></tr>';
            }
        }

        $nodes = $this->domDoc->getElementsByTagName ("count-group");
        print '<tr class="header"><td colspan="2" rowspan="1">'.BASE_T_XCGM.'</td></tr>';
        foreach ($nodes as $node)
        {
            $length = $node->attributes->length;
            for ($i = 0; $i < $length; ++$i)
            {
                $name =$node->attributes->item($i)->value;
                if ($node->hasChildNodes())
                {
                    $countNode=$node->getElementsByTagName("count");
                    $func=$countNode->item(0)->attributes->item(0)->value;
                    $type=$countNode->item(0)->attributes->item(1)->value;
                    $val=$countNode->item(0)->nodeValue;
                    if ($val!="") {
                        print "<tr class='row'><td  class='bold'>".$func." ".$type." count(".$name.")</td><td>".$val."</td></tr>";
                    }
                }
            }
        }
        print '<tr class="blankrow"><td colspan="2" rowspan="1">&nbsp;</td></tr>';

        $nodes = $this->domDoc->getElementsByTagName ("note");
        print '<tr class="header"><td colspan="2" rowspan="1">'.BASE_T_XNM.'</td></tr>';
        foreach ($nodes as $node)
        {
            $val=$node->nodeValue;
            if ($val!="")
            {
                print '<tr class="header"><td colspan="2" rowspan="1">'.$val.'</td></tr>';
            }
        }
        
        print '</tbody></table>';
        print '<center><p class="txt"><a id="close" href="#"> <em>'.BASE_XLFV_HIDEM.'</em> </a></p></center></div>' ;
        print '<br>';
        
    }

    function printDownloadInfo()
    {
        $id = $_GET['id'];
        if($id != '') {
            print "<br/>";
            print "<center>";
                print "<a class='txt' href='http://".$_SERVER['HTTP_HOST'].BASE_URL."/download.php?id=".$id."'>".BASE_T_DXLIFF."</a>";
                print "&nbsp;|&nbsp;";
                print "<a class='txt' href='http://".$_SERVER['HTTP_HOST'].BASE_URL."/xconv.php?id=".$id."&method=download'>";
                    print BASE_XLFV_DOWNTF;
                print "</a>&nbsp;|&nbsp;";
                print "<a class='txt' ";
                print "href='http://".$_SERVER['HTTP_HOST'].BASE_URL."/xconv.php?id=".$id."&method=view&style=".BASE_PREV_STYLE."'>";
                   print BASE_XLFV_PREVF;
               print "</a>";
            print "</center>";
            print "<br/>";
        }
    }

    function printLegend()
    {
        print "<center>";
            print "<h3>Legend</h3>";
        print "</center>";
        print '<table class="trans" border="0" cellpadding="3" cellspacing="0" align="center"><tbody>';
            print "<tr class='header'><td>Format</td><td>Meaning</td></tr>";
            print "<tr><td class='no-translate'>Sample</td><td>Text marked as \"Do Not Translate\"</td></tr>";
        print "</table>";
    }
}

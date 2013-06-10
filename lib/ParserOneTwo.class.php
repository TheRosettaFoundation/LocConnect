<?php

require_once 'IParser.class.php';

class ParserOneTwo extends IParser
{
    public function __construct($dom)
    {
        parent::__construct($dom);
    }

    public function printTranslationInfo($download = false)
    {
        print '<center> <a href="#" id="trans"><h2>'.BASE_XLFV_TRAN.'</h2> </a></center>';
        if($download) {
            print '<center><p class="txt"><a id="closet" href="#"> <em>'.BASE_XLFV_HIDET.'</em> </a></p></center><br/>' ;
            $this->printDownloadInfo();
        }
        print '<div id="translate">';
        print '<table class="trans" border="0" cellpadding="3" cellspacing="0" align="center"><tbody>';
        $translate = true;      // default value
        $foundTransAtt = false;
        $foundRef = false;
        $node = $this->domDoc->getElementsByTagName("body")->item(0);
        while (strcasecmp($node->nodeName, "xliff") != 0) {
            if (!$foundTransAtt) {
                $transAtt = $node->getAttribute('translate');
                if($transAtt !== NULL) {
                    if($transAtt == 'no') {
                        $translate = false;
                    }
                    $foundTransAtt = true;
                }
            }
            $annotatorsRef = $node->getAttribute("annotatorsRef");
            if ($annotatorsRef == NULL) {
                $annotatorsRef = $node->getAttribute("its:annotatorsRef");
            }
            if ($annotatorsRef != NULL) {
                if (!$foundRef) {
                    $foundRef = true;
                    print '<tr><td>Annotators References: </td></tr>';
                }
                $category = substr($annotatorsRef, 0, strpos($annotatorsRef, "|"));
                $ref = substr($annotatorsRef, strpos($annotatorsRef, "|") + 1, strlen($annotatorsRef) - 1);
                print "<tr><td>$category</td><td><a href='$ref' target='_blank'>$ref</a></td></tr>";
            }
            $node = $node->parentNode;
        }
        $nodes = $this->domDoc->getElementsByTagName("trans-unit");
        
        //print '<tr class="header"><td colspan="2" rowspan="1">XLIFF Count Group Metadata</td></tr>';
        foreach ($nodes as $node) {
            $name =$node->getAttribute("id");
            $translateSeg = $translate;
            $transAtt = $node->getAttribute("translate");
            if ($transAtt !== NULL) {
                if ($transAtt == 'no') {
                $translateSeg = false;
                } else {
                    $translateSeg = true;
                }
            }
            if ($node->hasChildNodes()) {
                if ($node->getElementsByTagName("seg-source")->length > 0) {
                    $sourceNode=$node->getElementsByTagName("seg-source")->item(0);
                    $source = $this->parseElement($sourceNode);
                } elseif ($node->getElementsByTagName("source")->length > 0) {
                    $sourceNode=$node->getElementsByTagName("source")->item(0);
                    $source = $this->parseElement($sourceNode);
                } else {
                    $source=BASE_XLFV_SRCERR;
                }
                if (trim($source)=="") {
                    $source=BASE_XLFV_SRCERR;
                }
            }
            $targetNode=$node->getElementsByTagName("target");
            if ($targetNode->item(0) && $targetNode->item(0)->parentNode &&
                $targetNode->item(0)->parentNode->nodeName == "alt-trans") {
                $target=BASE_XLFV_TGTERR;
            } else {
                if ($targetNode->length>0) $target=$targetNode->item(0)->nodeValue; else $target=BASE_XLFV_TGTERR;
            }
            
            if (trim($target)=="") $target=BASE_XLFV_TGTERR;
            $altTrans=$node->getElementsByTagName("alt-trans");
            print '<tr class="header"><td colspan="4" rowspan="1">'.$name.'</td></tr>';
            print '<tr class="row" id="src">';
            if($translateSeg) {
                print '<td>'.BASE_XLFV_SRC.'</td>';
                print '<td colspan="3" rowspan="1">';
//              print htmlentities($source,ENT_QUOTES,'UTF-8');
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

            if ($altTrans->length>0) {
                $k=0;
                foreach ($altTrans as $alt) {
                    $altSource = $alt->getElementsByTagName("source")->item(0);
                    $altTarget = $alt->getElementsByTagName("target")->item(0);
                    $k++;
                    $altval=$alt->nodeValue;
                    if ($k==1) {
                        print '<tr class="row-no-click"><td colspan="1" rowspan="'.
                                (string)($altTrans->length * 3).'">'.BASE_XLFV_ALT.'</td>';
                    } else {
                        print "<tr class='row-no-click'>";
                    }
                    if ($altval!="") {
                        print '<td class="alt">Source: '.$altSource->nodeValue.'</td>';
                    } else {
                        print '<td> <em>'.BASE_XLFV_ALTERR.' </em> </td>';
                    }
                    $temp="";
                    $length = $alt->attributes->length;
                    for ($i = 0; $i < $length; ++$i) {
                        $att =$alt->attributes->item($i)->name;
                        $val=$alt->attributes->item($i)->value;
                        if ($att!="match-quality") $temp=$temp.$att. " : ".$val. "<br/>";
                    }
                    $mq =$alt->getAttribute("match-quality");
                    if ($mq=="" or $mq==NULL) $mq="N/A";
                    print '<td class="red" id="altb" rowspan=\'2\'>'.$mq.
                            '</td><td class="txt" id="altb" rowspan=\'2\'>'.$temp.'</td></tr>';
                    print "<tr class='row-no-click'>";
                    print "<td class='alt'>Target: ".$altTarget->nodeValue."</td>";
                    print "</tr>";
                    print "<tr><td>   </td></tr>";
                }
            } else {
                print '<tr class="row-no-click"><td colspan="4" rowspan="1" class="alt"> <em>'.BASE_XLFV_ALTERR.'</em> </td></tr>';
            }
        }
        print '</tbody></table>';
        print '<center><p class="txt"><a id="closet" href="#"> <em> '.BASE_XLFV_HIDET.' </em> </a></p></center></div>' ;
    }

    private function parseElement($node)
    {
        $source_parsed = "";
        if (get_class($node) == "DOMText") {
            $source_parsed = $node->nodeValue;
        } else {
            $closingTag = "";
            if(strcasecmp($node->nodeName, "mrk") == 0) {
                $mtype = $node->getAttribute("mtype");
                if(strcasecmp($mtype, "phrase") == 0) {
                    $source_parsed .= " ".$node->nodeValue;
                    $ref = $node->getAttribute("url");
                    if($ref == NULL) {
                        $ref = $node->getAttribute("disambigIdentRef");
                    }
                    if($ref == NULL) {
                        $ref = $node->getAttribute("comment");
                    }
                    if($ref != NULL) {
                        $source_parsed .= "<sup><a target='_blank' href='$ref'>[ref]</a></sup>";
                    }
                } elseif(strcasecmp($mtype, "x-DNT") == 0 || strcasecmp($mtype, "preserve") == 0
                                || strcasecmp($mtype, "protected") == 0) {
                    $source_parsed .= " <span class='no-translate'>";
                    $closingTag .= "</span>";
                } elseif(strcasecmp($mtype, "x-its-Translate-Yes") == 0) {
                    $source_parsed .= " <span class='translate'>";
                    $closingTag .= "</span>";
                } elseif(strcasecmp($mtype, "term") == 0 || $node->getAttribute("its:terminology") == "yes") {
                    $confidence = $node->getAttribute("its:termConfidence");
                    if ($confidence == "") {
                        $confidence = $node->getAttribute("its:termConfidence");
                    }
                    $ref = $node->getAttribute("its:termInfoRef");
                    if ($ref == "") {
                        $ref = $node->getAttribute("termInfoRef");
                    }
                    $source_parsed .= "<span class='term' title='Confidence: $confidence'>";
                    $closingTag .= "</span><sup><a href='$ref'>[$ref]</a></sup>";
                } elseif(strcasecmp($mtype, "x-its") || strcasecmp($mtype, "xits")) {
                    $comment = $node->getAttribute("comment");
                    if ($comment != "") {
                        $source_parsed .= " <span class=\"comment\" title=\"$comment\">";
                        $closingTag .= "</span>";
                    }
                }
            }
            $annotatorsRef = $node->getAttribute("annotatorsRef");
            if ($annotatorsRef == NULL) {
                $annotatorsRef = $node->getAttribute("its:annotatorsRef");
            }
            if ($annotatorsRef != NULL) {
                $category = substr($annotatorsRef, 0, strpos($annotatorsRef, "|"));
                $ref = substr($annotatorsRef, strpos($annotatorsRef, "|") + 1, strlen($annotatorsRef) - 1);
                $source_parsed .= "<a href='$ref' title='$category' target='_blank'>";
                $closingTag .= "</a>";
            }
            if($node->hasChildNodes()) {
                $child = $node->firstChild;
                while($child != NULL) {
                    $source_parsed .= $this->parseElement($child);
                    $child = $child->nextSibling;
                }
            }
            $source_parsed .= $closingTag;
        }
        
        return $source_parsed;
    }

    public function printMetaData()
    {
        print '<center> <a href="#" id="meta"><h2>'.BASE_XLFV_META.'</h2> </a></center>';
        print '<center><p class="txt"><a id="close" href="#"> <em> hide Metadata </em> </a></p></center>' ;
        print '<div id="metadata">';
        print '<table class="meta" border="0" cellpadding="2" cellspacing="0" align="center">';
        
        $tagNames = array('pmui-data' => BASE_T_XMETA, 'file' => BASE_T_XFILE,
                    'task' => BASE_T_XWF, 'phase' => BASE_T_XPM,
                    'tool' => BASE_T_XTM);
        foreach($tagNames as $tagName => $displayName) {
            $nodes = $this->domDoc->getElementsByTagName($tagName);
            print '<tr class="header"><td colspan="2" rowspan="1">'.$displayName.'</td></tr>';
            
            foreach ($nodes as $node) {
                $length = $node->attributes->length;
                for ($i = 0; $i < $length; ++$i) {
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
        foreach ($nodes as $node) {
            $length = $node->attributes->length;
            for ($i = 0; $i < $length; ++$i) {
                $name =$node->attributes->item($i)->value;
                if ($node->hasChildNodes()) {
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
        foreach ($nodes as $node) {
            $val=$node->nodeValue;
            if ($val!="") {
                print '<tr class="row"><td colspan="2" rowspan="1">'.$val.'</td></tr>';
            }
        }
        
        print '</tbody></table>';
        print '<center><p class="txt"><a id="close" href="#"> <em>'.BASE_XLFV_HIDEM.'</em> </a></p></center></div>' ;
        print '<br>';
    }

    public function printGlossary()
    {
        $glossaries = $this->domDoc->getElementsByTagName("glossary-entry");
        if ($glossaries->length > 0) {
            echo "<center><h3>Glossary</h3></center>";
            echo "<table class='trans' border=\"1\" cellpadding=\"3\" cellspacing=\"0\" align='center'>";
            echo "<tr class='header'><th>ID</th><th>Term</th><th>Translation</th></tr>";
            foreach ($glossaries as $glossary) {
                $ref = $glossary->getAttribute("id");
                if ($glossary->hasChildNodes()) {
                    $term = "";
                    $translation = "";
                    $node = $glossary->firstChild;
                    while ($node != NULL) {
                        if ($node->nodeName == "itsx:term" || $node->nodeName == "term") {
                            $term = $node->textContent;
                        }
                        if ($node->nodeName == "itsx:translation" || $node->nodeName == "translation") {
                            $translation = $node->textContent;
                        }
                        $node = $node->nextSibling;
                    }
                    if ($ref != "" && $translation != "" && $term != "") {
                        echo "<tr>";
                        echo "<td><a name='$ref'>$ref</td>";
                        echo "<td>$term</td>";
                        echo "<td>$translation</td>";
                        echo "</tr>";
                    }
                }
            }
            echo "</table>";
        }
    }
}

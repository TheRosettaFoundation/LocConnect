<?php

require_once 'IParser.class.php';

class ParserTwoZero extends IParser
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
        $xliff = $this->domDoc->getElementsByTagName("xliff")->item(0);
        $this->parseAttributes($xliff, $translate);
        $fileCount = 0;
        $files = $this->domDoc->getElementsByTagName("file");
        foreach ($files as $file) {
            $this->parseAttributes($file, $translate);
            print "<tr><td>File #".++$fileCount."</td></tr>";
            $childNode = $file->firstChild;
            while ($childNode != NULL) {
                if ($childNode->nodeName == "group" ||
                    $childNode->nodeName == "unit") {
                    $this->parseGroupOrUnit($childNode, $translate);
                }
                $childNode = $childNode->nextSibling;
            }
        }
        print '</tbody></table>';
        print '<center><p class="txt"><a id="closet" href="#"> <em> '.BASE_XLFV_HIDET.' </em> </a></p></center></div>' ;
    }

    private function parseGroupOrUnit($group, $translate)
    {
        if ($group->hasChildNodes()) {
            $this->parseAttributes($group, $translate);
            if ($group->nodeName == "group") {
                print "<tr><td>Group</td></tr>";
            } elseif ($group->nodeName == "unit") {
                print "<tr><td>Unit {$group->getAttribute('id')}</td></tr>";
            }
            $child = $group->firstChild;
            while ($child != NULL) {
                if ($child->nodeName == "group" ||
                        $child->nodeName == "unit") {
                    $this->parseGroupOrUnit($child, $translate);
                } elseif ($child->nodeName == "segment") {
                    $this->parseSegment($child, $translate);
                }
                $child = $child->nextSibling;
            }
        }
    }

    private function parseSegment($segment, $translate)
    {
        if ($segment->hasChildNodes()) {
            $this->parseAttributes($segment, $translate);
            print '<tr class="header"><td colspan="4" rowspan="1">Segment</td></tr>';
            $source = $segment->getElementsByTagName("source")->item(0);
            if ($source) {
                $source = $this->parseElement($source);
            } else {
                $source = BASE_XLFV_SRCERR;
            }
            if (trim($source)=="") {
                $source = BASE_XLFV_SRCERR;
            }

            print '<tr class="row-no-click" id="src">';
            print '<td>'.BASE_XLFV_SRC.'</td>';
            if ($translate) {
                print '<td colspan="3" rowspan="1">'.$source.'</td>';
            } else {
                print '<td colspan="3" rowspan="1" class="no-translate" title="Do not translate this text">';
                print $source.'</td>';
            }
            print '</tr>';

            $target = $segment->getElementsByTagName("target");
            if ($target->item(0) && $target->item(0)->parentNode &&
                    $target->item(0)->parentNode->nodeName == "segment") {
                $target = $this->parseElement($target->item(0));
            } else {
                $target = BASE_XLFV_SRCERR;
            }
            if (trim($target)=="") {
                $target = BASE_XLFV_SRCERR;
            }
            print '<tr id="tgt">';
            print '<td class="row-no-click">'.BASE_XLFV_TGT.'</td>';
            print '<td colspan="3" rowspan="1" ';
            print 'class="dblclick">'.$target.'</td>';
            print '</tr>';

            $matches = $segment->getElementsByTagName("match");
            if ($matches->length > 0) {
                $first = true;
                print '<tr class="row-no-click"><td rowspan="'.(string)($matches->length * 3).
                        '">'.BASE_XLFV_ALT.'</td>';
                foreach ($matches as $match) {
                    if ($first) {
                        $first = false;
                    } else {
                        print "<tr class='row-no-click'>";
                    }

                    $metaData = "";
                    $length = $match->attributes->length;
                    for ($i = 0; $i < $length; $i++) {
                        $att = $match->attributes->item($i)->name;
                        $val= $match->attributes->item($i)->value;
                        if ($att!="match-quality") {
                            $metaData .= $att. " : ".$val. "<br/>";
                        }
                    }
                    $quality = $match->getAttribute("match-quality");
                    if ($quality == "" || $quality == NULL) {
                        $quality = "N/A";
                    }

                    $source = $match->getElementsByTagName("source")->item(0);
                    $length = $source->attributes->length;
                    for ($i = 0; $i < $length; $i++) {
                        $att = $source->attributes->item($i)->name;
                        $val= $source->attributes->item($i)->value;
                        $metaData .= "source-$att : $val<br/>";
                    }
                    if ($source != "") {
                        print '<td class="alt">Source: '.$source->nodeValue.'</td>';
                    } else {
                        print '<td> <em>'.BASE_XLFV_ALTERR.' </em> </td>';
                    }

                    $target = $match->getElementsByTagName("target")->item(0);
                    $length = $target->attributes->length;
                    for ($i = 0; $i < $length; $i++) {
                        $att = $target->attributes->item($i)->name;
                        $val= $target->attributes->item($i)->value;
                        $metaData .= "target-$att : $val<br/>";
                    }

                    print "<td class=\"red\" id=\"altb\" rowspan='2'>$quality</td>";
                    print "<td class=\"txt\" id=\"altb\" rowspan='2'>$metaData</td></tr>";

                    print "<tr class='row-no-click'>";
                    print "<td class='alt'>Target: ".$target->nodeValue."</td>";
                    print "</tr>";
                    print "<tr><td>   </td></tr>";
                }
            } else {
                print '<tr class="row-no-click"><td colspan="4" rowspan="1" class="alt"> <em>'.
                        BASE_XLFV_ALTERR.'</em> </td></tr>';
            }
        }
    }

    private function parseAttributes($node, &$translate)
    {
        $transAtt = $node->getAttribute('translate');
        if($transAtt !== NULL) {
            if($transAtt == 'no') {
                $translate = false;
            } else {
                $translate = true;
            }
        }
        $annotatorsRef = $node->getAttribute("annotatorsRef");
        if ($annotatorsRef == NULL) {
            $annotatorsRef = $node->getAttribute("its:annotatorsRef");
        }
        if ($annotatorsRef != NULL) {
            $category = substr($annotatorsRef, 0, strpos($annotatorsRef, "|"));
            $ref = substr($annotatorsRef, strpos($annotatorsRef, "|") + 1, strlen($annotatorsRef) - 1);
            print "<tr><td>$category</td><td><a href='$ref' target='_blank'>$ref</a></td></tr>";
        }
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

            $translate = $node->getAttribute("translate");
            if ($translate) {
                if ($translate == "no") {
                    $source_parsed .= " <span class='no-translate'>";
                    $closingTag .= "</span>";
                } else {
                    $source_parsed .= " <span class='translate'>";
                    $closingTag .= "</span>";
                }
            }

            if ($node->hasChildNodes()) {
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
                    'task' => BASE_T_XWF);
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

        $metadata = $this->domDoc->getElementsByTagName("mda:metadata");
        if ($metadata->length < 1) {
            $metadata = $this->domDoc->getElementsByTagName("metadata");
        }

        if ($metadata->length > 0) {
            foreach ($metadata as $data) {
                $metagroups = $data->getElementsByTagName("mda:metagroup");
                if ($metagroups->length < 1) {
                    $metagroups = $data->getElementsByTagName("metagroup");
                }

                if ($metagroups->length > 0) {
                    foreach ($metagroups as $metagroup) {
                        $metas = $metagroup->getElementsByTagName("mda:meta");
                        if ($metas->length < 1) {
                            $metas = $metagroup->getElementsByTagName("meta");
                        }

                        if ($metas->length > 0) {
                            $category = $metagroup->getAttribute("category");
                            if (!$category || $category == '') {
                                $category = "Group Data";
                            }

                            print '<tr class="header"><td colspan="2" rowspan="1">'.$category.'</td></tr>';
                            foreach ($metas as $meta) {
                                $name = $meta->getAttribute('type');
                                $value = $meta->nodeValue;
                                print "<tr class='row'><td class='bold'>$name</td><td>$value</td></tr>";
                            }
                        }
                        print '<tr class="blankrow"><td colspan="2" rowspan="1">&nbsp;</td></tr>';
                    }
                }
            }
        }
        $notes = $this->domDoc->getElementsByTagName ("note");
        if ($notes->length > 0) {
            print '<tr class="header"><td colspan="2" rowspan="1">'.BASE_T_XNM.'</td></tr>';
            foreach ($notes as $note) {
                $val=$note->nodeValue;
                if ($val!="") {
                    print '<tr class="row"><td colspan="2" rowspan="1">'.$val.'</td></tr>';
                }
            }
        }
        
        print '</tbody></table>';
        print '<center><p class="txt"><a id="close" href="#"> <em>'.BASE_XLFV_HIDEM.'</em> </a></p></center></div>' ;
        print '<br>';
    }

    public function printGlossary()
    {
        $glossaries = $this->domDoc->getElementsByTagName("glossentry");
        if ($glossaries->length < 1) {
            $glossaries = $this->domDoc->getElementsByTagName('gls:glossentry');
        }

        if ($glossaries->length > 0) {
            echo "<center><h3>Glossary</h3></center>";
            echo "<table class='trans' border=\"1\" cellpadding=\"3\" cellspacing=\"0\" align='center'>";
            echo "<tr class='header'><th>ID</th><th>Term</th><th>Translation/Definition</th></tr>";
            foreach ($glossaries as $glossary) {
                $ref = $glossary->getAttribute('id');
                if ($glossary->hasChildNodes()) {
                    $term = "";
                    $translation = "";
                    $node = $glossary->firstChild;
                    while ($node != NULL) {
                        if ($node->nodeName == "gls:term" || $node->nodeName == "term") {
                            $term = $node->textContent;
                        } elseif ($node->nodeName == "gls:translation" || $node->nodeName == "translation") {
                            $translation = $node->textContent;
                        } elseif ($node->nodeName == "gls:definition" || $node->nodeName == "definition") {
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

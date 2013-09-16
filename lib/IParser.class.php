<?php

require_once 'ParserOneTwo.class.php';
require_once 'ParserTwoZero.class.php';

abstract class IParser
{
    protected $domDoc;
    protected $xpath;

    protected function __construct($dom)
    {
        $this->domDoc = $dom;
        $this->xpath = new DOMXPath($dom);
    }

    public static function getParser($xliffSource)
    {
        $parser = null;
        $domDoc = new DomDocument();
        $domDoc->loadXML($xliffSource);
        $xliff = $domDoc->getElementsByTagName("xliff")->item(0);
        if ($version = $xliff->getAttribute("version")) {
            if ($version == "1.2") {
                $parser = new ParserOneTwo($domDoc);
            } elseif ($version == "2.0") {
                $parser = new ParserTwoZero($domDoc);
            }
        }
        return $parser;
    }

    public function printDownloadInfo()
    {
        $id = $_GET['id'];
        if ($id != '') {
            print "<br/>";
            print "<center>";
                print "<a class='txt' href='http://".$_SERVER['HTTP_HOST'].BASE_URL.
                        "/download.php?id=".$id."'>".BASE_T_DXLIFF."</a>";
                print "&nbsp;|&nbsp;";
                print "<a class='txt' href='http://".$_SERVER['HTTP_HOST'].BASE_URL.
                        "/xconv.php?id=".$id."&method=download'>";
                    print BASE_XLFV_DOWNTF;
                print "</a>&nbsp;|&nbsp;";
                print "<a class='txt' ";
                    print "href='http://".$_SERVER['HTTP_HOST'].BASE_URL."/xconv.php?id=".$id.
                            "&method=view&style=".BASE_PREV_STYLE."'>";
                    print BASE_XLFV_PREVF;
                print "</a>";
            print "</center>";
            print "<br/>";
        }
    }

    public function printLegend()
    {
        print "<center>";
            print "<h3>Legend</h3>";
        print "</center>";
        print '<table class="trans" border="0" cellpadding="3" cellspacing="0" align="center"><tbody>';
            print "<tr class='header'><td>Format</td><td>Meaning</td></tr>";
            print "<tr><td class='no-translate'>Sample</td><td>Text marked as \"Do Not Translate\"</td></tr>";
            print "<tr><td class='comment'>Comment</td><td>Hover over this text for a comment</td></tr>";
            print "<tr><td class='term'>Term</td><td>Text marked as a term. Hover over for confidence.</td></tr>";
        print "</table>";
    }

    public abstract function printTranslationInfo($download = false);
    public abstract function printMetaData();
    public abstract function printGlossary();
}

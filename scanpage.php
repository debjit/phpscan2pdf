<?php

/*SCANNER_MODE="Gray"   # try  "lin", "bin",  "gr", or "col" 
$SCANNER_RES=300
PDF_QUALITY=70
PDF_FORCE="colour"
#PDF_FORCE="monochrome"
PAGE_X=210
PAGE_Y=297
DESTFILE=$(pwd)
DM=`date +%d%b%y_%H%M%S`
DESTFILE="$DESTFILE/scan_$DM.pdf"*/

$SCANNER_MODE="Gray";
$SCANNER_RES=300;
$PAGE_X=210;
$PAGE_Y=297;

if(isset($_POST['mode'])) $SCANNER_MODE=$_POST['mode'];

//	scanimage --mode $SCANNER_MODE --format tiff --resolution $SCANNER_RES -x $PAGE_X -y $PAGE_Y > $TEMP_FLDR/out$i.tif

if (isset($_POST['tempdir']) && isset($_POST['pagenum']))
    $outname = "${_POST['tempdir']}/out${_POST['pagenum']}.tif";
    exec("scanimage --mode $SCANNER_MODE --format tiff --resolution $SCANNER_RES -x $PAGE_X -y $PAGE_Y > $outname", $dummy, $return);

//Because we want to use json, we have to place things in an array and encode it for json.
//This will give us a nice javascript object on the front side.
echo json_encode(
    array(
        "returnValue" => $dummy,
        "completedpages" => $_POST['pagenum'],
        "return" => $return
        )
    );  

?>

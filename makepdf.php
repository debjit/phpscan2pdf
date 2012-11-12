<?php

$PDF_QUALITY=70;
$DM=date('dmY_His');
$DESTFILE="scan_$DM.pdf";

if (isset($_POST['tempdir'])){
    $TEMP_FLDR=$_POST['tempdir'];
    exec("tiffcp -c lzw $TEMP_FLDR/out*.tif $TEMP_FLDR/output.tif", $dummy, $return);
    exec("tiff2pdf -j -q $PDF_QUALITY $TEMP_FLDR/output.tif > $TEMP_FLDR/$DESTFILE", $dummy, $return);
    
//Because we want to use json, we have to place things in an array and encode it for json.
//This will give us a nice javascript object on the front side.
echo json_encode(
    array(
        "filename" => "$TEMP_FLDR/$DESTFILE",
        "link" => "http://".$_SERVER['HTTP_HOST'].$_SERVER['PHP_SELF']."?filename=$TEMP_FLDR/$DESTFILE",        
        "return" => $return
        )
    );  
    
}    

if (isset($_GET['filename'])){
   header("Content-Type: application/octet-stream");
   header("Content-Disposition: attachment; filename=".basename($_GET['filename']));
   readfile($_GET['filename']);

}

?>

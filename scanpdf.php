<html>
<head>

        <script language="javascript" type="text/javascript"
        src="/javascript/jquery/jquery.js"></script>
        
       
</head>
<body>


<?php

#
# Check that a scanner is attached
#
exec('scanimage -f %d', $output);
if(sizeof($output) == 0)
{
    display_no_scanner();
    exit;
}

exec('mktemp -d',$TEMP_FLDR)

?>
  <script type="text/javascript" charset="utf-8">
    var tempdir = "<? echo $TEMP_FLDR[0]; ?>";
    var pagenum = 1;
  </script>
<!--  <select id="mode"><option value="Gray">B & W</option>
    <option value="Color">Colour</option></select>
    -->
<input type="hidden" id="mode" value="Gray"/>
<button id="scanpage">Press to scan page</button>
<button id="makepdf">Press to complete PDF</button>

<div id="loading"><img src="loading.gif"/></div>

<div id="pages">Completed Pages: <span id="completedpages">0</span></div>
<div id="display"></div>

  <script type="text/javascript" charset="utf-8">

        $(document).ready(function(){
            $('#makepdf').hide();
            $('#loading').hide();            
            $('#scanpage').click(function(){
                sendValue($(this).val());
                $(this).hide();  
                $('#makepdf').hide();                
               
            });
           
        });
        
        $(document).ready(function(){
            $('#makepdf').click(function(){
                $('#loading').show();
                $('#makepdf').hide();                
                $('#scanpage').hide();                                
                $.post("makepdf.php",
                    { tempdir: tempdir },
                    function(data){
                        $('#display').html(data.filename);
                        window.location.href = data.link;
                        setTimeout("location.reload(true)", 1000);
                    }, "json");               
            });
           
        });        
        function sendValue(str){
            $('#loading').show();
            //tempdir = $('#tempdir').val();
            mode = $('#mode').val();
            $.post("scanpage.php",
                { tempdir: tempdir,
                pagenum: pagenum,
                mode: mode },
                function(data){
                    $('#loading').hide();
                    $('#display').html(data.returnValue);
                    $('#completedpages').html(data.completedpages);
                    if(data.return == 0) $('#scanpage').show();
                    if(data.return == 0) $('#makepdf').show();                    
                }, "json");
            pagenum ++;
           
        }
       
    </script> 
<?




function display_no_scanner()
{
    ?>
    Sorry. No scanner attached. Please plugin the scanner and try again
    <?
}

?>
</body>
</html>

<?php 

include_once('includes/test_utils.inc');
include_once('dwca.inc');

ini_set('display_errors', 1);
ini_set('error_reporting', E_ALL);

function test_open_dwca_file(){

  try{
    $dwca = new DwCA('examples/eol.zip');
  }catch (Exception $ex){
    $dwca = FALSE;
    print $ex;
  }

  test_result('Open DwC-A file', ($dwca != FALSE));
}


function test_open(){
  $core = FALSE;

  try{
    $dwca = new DwCA('examples/benin.zip');
    $dwca->open();

    $core = $dwca->meta->core;

  }catch (Exception $ex){
    $core = false;
    print $ex;
  }

  test_result('DwCA::open ', (basename($core->files[0])  === 'occurrence.txt'));
}

function test_get_records($file ){

  $core = FALSE;
  try{
    $dwca = new DwCA($file);
    $dwca->open();
    $rows = $dwca->get_records(0, 50);

  }catch (Exception $ex){
    $rows = FALSE;
    print $ex;
  }

  test_result("Test get records from archive file [$file]", (count($rows) == 50));
}


function test_get_extensions(){

  $extensions = FALSE;
  try{
    $dwca = new DwCA('examples/eol.zip');
    $dwca->open();
    $extensions = $dwca->meta->extensions;

  }catch (Exception $ex){
    $extensions = FALSE;
    print $ex;
  }

  test_result('Test get extensions', (count($extensions) == 4));
}

$dir = 'examples';
$dh = opendir($dir);

while (false !== ($file = readdir($dh))) {
#  print "\tThis is the file to work with [$file] \n";
  if (is_file($dir.'/'.$file) && $file != "." && $file != "..") {
    test_get_records($dir.'/'.$file);
  }
}

  #test_open_dwca_file();
  #test_open();
  #test_get_records($file);
  #test_get_extensions();

?>

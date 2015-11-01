<HTML>
    <HEAD >
        <SCRIPT language='javascript' src='jquery-1.11.3.js' ></SCRIPT>
        <SCRIPT language='javascript' >function JSX_JS_Toggle_dir( p_id ){ $("#"+p_id).toggle(1000); }</SCRIPT>
    </HEAD>
<BODY>    
<?php

// Error handling.
error_reporting(E_ALL);

// Globals.
$g_dir_img = "./media/";
$g_icon_fold = $g_dir_img . "icon_fold_70x70.png";
$g_icon_file = $g_dir_img . "icon_file_70x70.png";
$g_cnt = 0; // Counter for <tags> ID.

// Init.
$l_sPath = "./Example_Folder";

// Start recursive printing from somewhere.
JSX_PHP_Files_List_Recursive_Print( $l_sPath );

// Recursive function.
function JSX_PHP_Files_List_Recursive_Print( $p_sPath )
  {
  global $g_icon_fold;
  global $g_icon_file;
  global $g_cnt;
  
  // Init.
  $dir = $p_sPath;
  $l_aFolds = array();
  $l_aFiles = array();

  // Open a known directory, and proceed to read its contents
  if(is_dir($dir)) 
      {
      if ($dh = opendir($dir)) 
          {
          while (($file = readdir($dh)) !== false)
            {
            $type = filetype($dir ."/". $file);
            //echo "File: [<B >" .$file. "</B>] (" .$type. ")<BR />";
            if( $type=="dir" )
              {
              if( $file=="." )
                continue;
              if( $file==".." )
                continue;
                $l_aFolds[] = array( 'name' => $file, 'type' => $type );
              }
            else
            {
            $l_aFiles[] = array( 'name' => $file, 'type' => $type );
            }
          }
          closedir($dh);
      }
  }

  // Sort and merge arrays.
  asort( $l_aFolds );
  asort( $l_aFiles );
  $l_aTree = array_merge( $l_aFolds, $l_aFiles ); 

  // Recursively (if in case) print array data.
  echo "<HR />\n";
  echo "[<B >" .$p_sPath. "</B>] (Files n." .sizeof($l_aTree). ")<BR />\n"; 
  echo "<UL >";
  foreach ($l_aTree as $key => $val)
    {
    $g_cnt++;
    $l_id = "id_n" .$g_cnt;
    echo "<LI >";
    if( $val['type']=="dir" )
      {
      echo "<A href='#000' onclick='JSX_JS_Toggle_dir(\"" .$l_id. "\");' >";  
        echo "<IMG src='" .$g_icon_fold. "' />";
      echo "</A>";
      echo $val['name'] . "<BR />\n";
      echo "<SPAN id='" .$l_id. "' style=' display:none; width:100%; ' >";
        JSX_PHP_Files_List_Recursive_Print( $p_sPath ."/". $val['name'] );
      echo "</SPAN>";
      }
    else
      {
      echo "<A href='" .$p_sPath."/".$val['name']. "' target='_blank' >";
        echo "<IMG src='" .$g_icon_file. "' />";
      echo "</A>";
      echo $val['name'] . "<BR />\n";
      }
    echo "</LI>";
    }
  echo "</UL>";

  // Return value.
  $rv = $l_aFiles;
  return( $rv );

  }//JSX_PHP_Files_List_Recursive

?>
</BODY>
</HTML>

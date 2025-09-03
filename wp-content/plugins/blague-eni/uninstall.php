<?php
if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) )
	exit();

function eniBlague_uninstall(){

    global $wpdb; 
     
    $table_site = $wpdb->prefix.'eniBlague'; 
    
  if($wpdb->get_var("SHOW TABLES LIKE '$table_site'") == $table_site){    
        $sql = "DROP TABLE `$table_site`";  
        $wpdb->query($sql);
  }   
}

eniBlague_uninstall();  
?>
<?php
require ('../header_inc/connect/connect.php');

   foreach ($_POST['deleteCheckes'] as $value)
    {
      $query_delete = "UPDATE pvt_messages SET deleted = 'yes', opened = 'yes' WHERE id='$value'";
      mysql_query($query_delete);
    }

?>
<?php
  $tpl = file_get_contents('tpl/test.apptztemplate');
  echo str_replace("%1", "testing", $tpl);
?>

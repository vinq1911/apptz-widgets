<?php
$tpl = file_get_contents('tpl/services.apptztemplate'); // grid base
$grid = file_get_contents('tpl/grid.apptztemplate'); // grid item, these go into base
$resitem = file_get_contents('tpl/resitem.apptztemplate'); // prod item inside grid item
$gridbase = file_get_contents('tpl/gridbase.apptztemplate');
$apptz_widget_queue_style(UIKIT_STYLE);
$apptz_widget_queue_script(JQUERY);
$apptz_widget_queue_script(UIKIT_SCRIPT);

$gridsize = ($apptz_widget_request[3] && $apptz_widget_request[4]) ? [$apptz_widget_request[3], $apptz_widget_request[4]] : [1, 2]; // grid size; 1-2 if not set in second and third path param
$res = $apptz_dataquery('embed/nextavail/'.$apptz_widget_request[2]);
$griditems = [];

foreach ($res as $r) {
  $griditems[] = $apptz_embed(
    "CONTENT",
    $apptz_embed(
      ['%STARTDATE%', '%WAITTIME%', '%STARTTIME%', '%ENDTIME%', '%RESID%'],
      [$r['sensibledate'], $r['sensiblewaittime'], $r['sensibletimestart'], $r['sensiblerealtimeend'], $r['res_id']],
      $resitem),
    $apptz_embed("WIDTH", implode("-", $gridsize), $grid)
  );
}
$grid = '';
for ($j = 0; $j < count($griditems); $j++) {
  $_grid = '';
  for ($i = 0; $i < $gridsize[1]; $i++) {
    $_grid = array_pop($griditems).$_grid;
  }
  $grid = $apptz_embed("CONTENT", $_grid, $gridbase).$grid;
}



$apptz_render($apptz_embed("CONTENT", $grid, $tpl));

?>

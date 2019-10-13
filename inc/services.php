<?php

  $tpl = file_get_contents('tpl/services.apptztemplate'); // grid base
  $grid = file_get_contents('tpl/grid.apptztemplate'); // grid item, these go into base
  $proditem = file_get_contents('tpl/proditem.apptztemplate'); // prod item inside grid item
  $gridbase = file_get_contents('tpl/gridbase.apptztemplate');
  $apptz_widget_queue_style(UIKIT_STYLE);
  $apptz_widget_queue_script(JQUERY);
  $apptz_widget_queue_script(UIKIT_SCRIPT);

  $apptz_widget_queue_style(UIKIT_STYLE);
  $apptz_widget_queue_script(JQUERY);
  $apptz_widget_queue_script(UIKIT_SCRIPT);
  $gridsize = ($apptz_widget_request[2] && $apptz_widget_request[3]) ? [$apptz_widget_request[2], $apptz_widget_request[3]] : [1,2]; // grid size; 1-2 if not set in second and third path param
  $res = $apptz_dataquery('embed/svcs/'.APPTZ['lang']);
  $griditems = [];

  foreach ($res as $r) {
    $griditems[] = $apptz_embed(
      "CONTENT",
      $apptz_embed(
        ['%NAME%', '%PRICE%', '%CONTENT%', '%PRODID%'],
        [$r['prod_name_lang_translated'], ($r['prod_price']/100).$r['prod_currency_symbol'], $r['prod_shortexp_lang_translated'], $apptz_link('nextfree/'.$r['prod_id']."/".implode("/", $gridsize), $r['prod_id'])],
        $proditem),
      $apptz_embed("WIDTH", implode("-", $gridsize), $grid)
    );
  }
  $grid = '';
  for ($j = 0; $j < count($griditems); $j++) {
    $_grid = '';
    for ($i = 0; $i < $gridsize[1]; $i++) {
      $_grid = array_pop($griditems).$_grid;
    }
    $grid .= $apptz_embed("CONTENT", $_grid, $gridbase);
  }

  $apptz_render($apptz_embed("CONTENT", $grid, $tpl));
?>

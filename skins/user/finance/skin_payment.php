<?php
class skin_objectpublic{


function showDetail($obj, $option = array()){
  global $bw,$vsLang,$vsPrint,$vsTemplate;
	$count=count($option['other']);


		$BWHTML .= <<<EOF
<h3 class="title_cate">{$obj->getTitle()}</h3>

<div class="main_item main_th">
    <div class='payment-content'>{$obj->getContent()}</div>

    <div class="g-plusone" data-annotation="inline" data-width="300"></div>
    <script type="text/javascript">
      (function() {
        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
        po.src = 'https://apis.google.com/js/platform.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
      })();
    </script>
    <iframe src="http://www.facebook.com/plugins/like.php?href=http://shophoa360.com/&amp;layout=standard&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp" style="overflow:hidden;width:100%;height:80px;" scrolling="no" frameborder="0" allowTransparency="true"><a href="http://www.stromvergleich.bz">stromvergleich.bz</a></iframe>
    <div class="clear"></div>
  </div>
EOF;
	}
}
?>

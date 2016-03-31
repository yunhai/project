<?php
class skin_objectpublic{

function showObj($obj,$module){
    global $bw,$vsLang,$vsPrint,$vsTemplate,$vsMenu;

		$BWHTML .= <<<EOF
    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
        <div class="item_th">
            <a class="thickbox img_th"  href="{$obj->getCacheImagePathByFile($obj->file,1,1,1,1,$obj->getTitle())}">
                {$obj->createImageCache($obj->file,263,172,1,0,$obj->getTitle())}
            </a>
            <h3><a href="{$obj->getUrl($bw->input['module'])}">{$obj->getTitle(45)}</a></h3>
            <p>{$obj->getIntro(250)}</p>
        </div>
    </div>
EOF;
	}
function showDetail($obj,$option){
  global $bw,$vsLang,$vsPrint,$vsTemplate;
	$count=count($option['other']);

		$BWHTML .= <<<EOF
 <h3 class="title_cate">
    <if="$bw->input['module']=='ho-tro-khach-hang'">{$vsLang->getWords('ho-tro-khach-hang','Hỗ trợ khách khàng')}</if>
    <if="$bw->input['module']==dichvu">{$vsLang->getWords('dichvu','Dịch Vụ')}</if>
    <if="$bw->input['module']==news">{$vsLang->getWords('news','Tìm hiểu Về Hoa')}</if>
</h3>

<div class="main_item main_th">
    <h1 class="title_detail_th">{$obj->getTitle()}</h1>
    {$obj->getContent()}

    <if="$bw->input['module']==dichvu && $obj->getId() == 5">
      <iframe src="https://docs.google.com/forms/d/1Ul6dhfDwHYTneLkfdb_oLZ5tDIX4Ad3IFUeefSYl8-w/viewform?embedded=true#start=openform" width="760" height="500" frameborder="0" marginheight="0" marginwidth="0">Đang tải...</iframe>
    </if>

	<div class='clear'></div>
	<br />
    <div class="g-plusone" data-annotation="inline" data-width="300"></div>
    <script type="text/javascript">
      (function() {
        var po = document.createElement('script'); po.type = 'text/javascript'; po.async = true;
        po.src = 'https://apis.google.com/js/platform.js';
        var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(po, s);
      })();
    </script>
    <iframe src="http://www.facebook.com/plugins/like.php?href=http://shophoa360.com/&amp;layout=standard&amp;show_faces=true&amp;action=like&amp;colorscheme=light&amp" style="overflow:hidden;width:100%;height:800px;" height='800px' scrolling="no" frameborder="0" allowTransparency="true"><a href="http://www.stromvergleich.bz">stromvergleich.bz</a></iframe>
    <div class="clear"></div>
  	<if="$bw->input['module']==news && $option['other']">
        <h3 class="title_cate">{$vsLang->getWords('baivietkhac','Bài viết khác')}</h3>
        <div class="main_item">
          <foreach="$option['other'] as $value">
              {$this->showObj($value)}
          </foreach>
        </div>
    </if>

    <if="$bw->input['module']=='dichvu' || $bw->input['module']=='ho-tro-khach-hang'">
        <if="$option['pageList']">
            <h3 class="title_cate">Bài viết khác</h3>
        </if>
        <div class="main_item">
            <foreach="$option['pageList'] as $obj">
                {$this->showObj($obj)}
            </foreach>
        </div>
    </if>
  </div>
EOF;
	}

function showDefault($option){
	global $bw,$vsLang,$vsPrint,$vsTemplate;

		$BWHTML .= <<<EOF
            	<h3 class="title_cate">{$vsPrint->mainTitle}</h3>
                <div class="main_item">
                    <foreach="$option['pageList'] as $obj">
                        {$this->showObj($obj)}
                    </foreach>
                    <div class="clear"></div>
                    <if="$option['paging']">
                        <div class="page">
                            {$option['paging']}
                        </div>
                    </if>
                </div>
EOF;
	}

function showDetail_video($obj,$option){
    global $bw,$vsLang,$vsPrint,$vsTemplate;
    $BWHTML .= <<<EOF
       <if="$obj->getAddress()">
            <div class="show show_video">
                <iframe  id="videos_obj_code_img" style=""  width="818" height="413" src="http://www.youtube.com/embed/{$obj->getAddress()}" frameborder="0" allowfullscreen></iframe>
            </div>
    </if>
EOF;
    }




}
?>

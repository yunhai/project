<?php

class GlobalLoad {

    function __construct() {
        $this->addDefaultScript();
        $this->addDefaultCSS();
    }


    function addDefaultScript() {
        global $vsPrint, $bw, $vsSettings,$vsTemplate;
            $vsPrint->addCurentJavaScriptFile("jquery-latest",1);

            $vsPrint->addCurentJavaScriptFile("jcarousellite");
            $vsPrint->addCurentJavaScriptFile("jquery.nivo.slider.pack");
            $vsPrint->addCurentJavaScriptFile("popup-window");
            $vsPrint->addCurentJavaScriptFile("main");
            $vsPrint->addCurentJavaScriptFile("thickbox");

            $vsPrint->addCurentJavaScriptFile("m-extend/jquery.mobile-events.min");
            $vsPrint->addCurentJavaScriptFile("m-extend/m-extend");
            $vsPrint->addCurentJavaScriptFile("jquery.browser");
            $vsPrint->addCurentJavaScriptFile("owl.carousel");

            $vsPrint->addJavaScriptFile( 'vs.ajax',1);
            $vsPrint->addJavaScriptFile( 'jquery/ui.core');
            $vsPrint->addJavaScriptFile( 'jquery/ui.widget');
            $vsPrint->addJavaScriptFile( 'jquery/ui.position');
            $vsPrint->addJavaScriptFile( 'jquery/ui.dialog');
            $vsPrint->addJavaScriptFile( "jquery/ui.alerts");

            $vsPrint->addJavaScriptString ( 'global_var', '
                var vs = {};
                var ajaxfile = "index.php";
                var noimage=0;
                var imgurl = "' . $bw->vars ['img_url'] . '/";
                var image = imgurl + "loader.gif";
                var img = "' . $bw->vars ['cur_folder'] . 'htc";
                var boardUrl = "'.$bw->vars['board_url'].'";
                var baseUrl  = "'.$bw->base_url.'";
                var global_website_title = "'.$bw->vars['global_websitename'].'/";
            ', 1 );

            $vsPrint->addJavaScriptString ( 'global_analysis', "
                (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
                (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
                m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
                })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

                ga('create', 'UA-20001804-3', 'shophoa360.com');
                ga('send', 'pageview');
            ");
    }

    function addDefaultCSS() {
            global $vsUser,$vsPrint, $vsModule,$bw;
                $vsPrint->addCSSFile('bootstrap/css/bootstrap');
                $vsPrint->addCSSFile('material-design-iconic-font/css/material-design-iconic-font');

                $vsPrint->addCSSFile('default');
                $vsPrint->addCSSFile('global');
                $vsPrint->addCSSFile('content');
                $vsPrint->addCSSFile('menu');
                $vsPrint->addCSSFile('nivo-slider');
                $vsPrint->addCSSFile('thickbox');
                $vsPrint->addCSSFile('m-extends');
                $vsPrint->addCSSFile('main');
                $vsPrint->addCSSFile('owl.carousel');

                $vsPrint->addGlobalCSSFile('jquery/base/ui.theme');
                $vsPrint->addGlobalCSSFile('jquery/base/ui.core');
                $vsPrint->addGlobalCSSFile('jquery/base/ui.theme');
                $vsPrint->addGlobalCSSFile('jquery/base/ui.dialog');

                $vsPrint->addCSSFile($vsModule->obj->getClass());
    }
}
    $styleLoad = new GlobalLoad();

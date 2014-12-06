<?php

if (! defined ( 'IN_VSF' )) {
	print "<h1>Permission denied!</h1>You cannot access this area. (VS Framework is powered by <a href=\"http://www.vietsol.net\">Viet Solution webdesign company</a>)";
	exit ();
}
global $vsStd;
$vsStd->requireFile ( CORE_PATH . "pages/pages_public.php" );
class abouts_public extends pages_public {
	function auto_run() {
		global $bw;
		$bw->input['action']="pages_".$bw->input['action'];
		require_once EXTEND_PATH.$bw->input[0]."/abouts_controler_public.php";
		$controler=new abouts_controler_public('pages',"skin_abouts","page",'abouts');
		$controler->auto_run();
		return $this->setOutput($controler->getOutput());
	}
}
?>
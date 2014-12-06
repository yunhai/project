<?php
class VSSCounter {
	public $datetime;
	
	function __construct(){
		$now			=	mktime();
		$this->datetime = VSFactory::getDateTime()->getTimeStart(0,1,$now);
		$tb=time();
		$this->datetime['flag']=($tb-$tb%300);
		$this->datetime['yesterdaystart']=($tb-$tb%-86400);
		$this->datetime['daystart']=($tb-$tb%86400);
		$this->datetime['weekstart']=($tb-$tb%604800);
		$this->datetime['monthstart']=($tb-$tb%2562000);
		//echo $this->datetime['flag'];
		
	}
	
	function insertCounter($visist=1,$guest=1,$member=1){
		$DB=VSFactory::createConnectionDB();
		$DB->simple_construct(array( 'select' 	=> '*',
										 'from' 	=> 'counter_log',
										 'where' 	=> 'time='.$this->datetime['flag']
									)
								 );
 
			$DB->simple_exec(); 
			if($lg = $DB->fetch_row ())
			{
				 $DB->do_update('counter_log',array('visits'=>$lg['visits']+$visist,'guests'=>$lg['guests']+$guest,'members'=>$lg['members']+$member),"time=".$this->datetime['flag']);
			}
			else{
					$DB->do_insert('counter_log',array('time'=>$this->datetime['flag'],'visits'=>$visist,'guests'=>$guest,'members'=>$member));
			}
	}
	
	function getStatistic($timestart = 0, $timestop = 0) {
		
		$timestart = ( int ) $timestart;
		$timestop = ( int ) $timestop;
		return $this->getVisitsFromLogs ( $timestart, $timestop );
	
	}
	
	function getVisitsFromLogs($timestart = 0, $timestop = 0) {
		$DB=VSFactory::createConnectionDB();		
		$timestart = ( int ) $timestart;
		$timestop = ( int ) $timestop;
		$records = null;
		
		$total = array ();
		
		$total ['visits'] = 0;
		$total ['guests'] = 0;
		$total ['members'] = 0;
		$total ['bots'] = 0;
		$total ['lasttime'] = 0;
		$total ['online']=0;
		
		$query = array ("select" => "(SELECT  SUM(visits)
FROM vsf_counter_log
WHERE `time`>={$this->datetime['flag']} ) AS online,

(SELECT  SUM(visits)
FROM vsf_counter_log
WHERE `time`>={$this->datetime['daystart']}  ) AS today,
(SELECT  SUM(visits)
FROM vsf_counter_log
WHERE `time`>={$this->datetime['weekstart']}  ) AS week,
(SELECT  SUM(visits)
FROM vsf_counter_log
WHERE `time`>={$this->datetime['monthstart']}  ) AS month,
(SELECT  SUM(visits)
FROM vsf_counter_log ) AS total ", "from" => "counter_log ", "where" => "'1=1' " );
		
		
		if(!$timestop){
			$timestart = $timestart - 86400;
			$query['where'] = " time = {$timestart} ";
		}
		else $query['where'] = " time >= {$timestart} AND time <= {$timestop} ";
		
				
		$DB->simple_construct ( $query );
		$DB->simple_exec ();
		$record = $DB->fetch_row ();
		/*if($_REQUEST['test']){
		echo "<pre>";
	print_r($record);
	echo "<pre>";
	exit;
		
	}
	*/
		return $record;
	}
	
	function getStatesInformation(){
		global $vsTemplate,$vsStd,$bw;
		$DB=VSFactory::createConnectionDB();

//		$DB->simple_construct(
//			array(	'select'	=> 'COUNT(*) as totalmember',
//					'from'		=> 'user'
//				)
//		);
//		$DB->simple_exec();
//		$stats = $DB->fetch_row();

                $DB->simple_construct(
			array(	'select'	=> '*',
					'from'		=> 'user_session',
					'where'		=> 'sessionTime >'.(time()-(30*60))
			)
		);

		$DB->simple_exec();
		$membercount = 0; $visitorcount = 0;
		$loginuser = $DB->fetch_row();
		while($loginuser){
			if($loginuser['userId']) $membercount++;
			else $visitorcount++;
			$loginuser = $DB->fetch_row();
		}
		$stats['members'] = $membercount = $membercount?$membercount:0;
		$stats['guests'] = $visitorcount;
		$stats['visits'] = $membercount+$visitorcount;

		return $stats;
	}
	

	function visitCounter() {
		global $bw,$vsTemplate,$vsSettings;
	
		$visits = $this->getStatesInformation();
		$visits=$this->getStatistic ( 0, $this->datetime['local_daystart']);
	
		
		return $visits;
	}
}
?>
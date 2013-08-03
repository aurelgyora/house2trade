<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Crontab_interface extends MY_Controller{
	
	function __construct(){
		
		parent::__construct();
	}
	
	public function sendingEmailAboutNewMatch(){
		
		$start_time = microtime(true);
		echo 'Начало работы: '.date("d.m.Y H:i:s").'<br/>';flush();
		echo "\n---------------------------------------------<br/>\n";flush();
		$this->load->model(array('match'));
		
		if($matches = $this->match->getWaitingMatches()):
			foreach($matches as $key => $match):
				$propertiesIDs = $this->getMatchPropertiesIDs($match);
				$this->sendMultiMailsPropertiesIDs(12,$propertiesIDs);
				$this->match->update_field($match['id'],'mailing_date',date("Y-m-d"),'match');
				echo 'Номер Match ID:'.$match['id'].'<br/>';flush();
			endforeach;
		endif;
		echo "\n---------------------------------------------\n<br/>";flush();
		$exec_time = round((microtime(true) - $start_time),2);
		echo "Скрипт выполнен за: $exec_time сек.\n";
		echo '<br/>Конец работы: '.date("d.m.Y H:i:s");flush();
		exit;
	}
	
}
?>
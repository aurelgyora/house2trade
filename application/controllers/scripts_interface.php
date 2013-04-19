<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

class Scripts_interface extends MY_Controller{
	
	function __construct(){
		
		parent::__construct();
	}
	
	function csvExportProperties(){
		
		$start_time = microtime(true);
		'Начало работы: '.date("d.m.Y H:i:s").'<br/>';flush();
		$this->load->model('properties');
		$this->load->model('images');
		$this->load->helper('string');
		$properties = array();
		$property_index = 0;
		$files = scandir('csv');
		foreach($files as $index => $value):
			if($value == '.' || $value == '..' ):
				continue;
			endif;
			$name = getcwd().'/csv/'.$value;
			if(is_file($name)):
				echo "file name: $name<br/>";flush();
				$handle = fopen($name,"r");
				$line = FALSE;
				while(($data = fgetcsv($handle,100000,",")) !== FALSE):
					$properties[$property_index] = array('address'=>'','state'=>'','zip_code'=>0);
					if(!$line):
						$line = TRUE;
						continue;
					endif;
					if(isset($data[0]) && !empty($data[0])):
						$properties[$property_index]['address'] = $data[0];
					endif;
					if(isset($data[1]) && !empty($data[1])):
						$split = explode(' ',$data[1]);
						$properties[$property_index]['state'] = $split[0];
						$properties[$property_index]['zip_code'] = $split[1];
					endif;
					if(!empty($properties[$property_index]['address']) && !empty($properties[$property_index]['state']) && !empty($properties[$property_index]['zip_code'])):
						$zillow_result = $this->zillowApi($properties[$property_index]['address'],$properties[$property_index]['zip_code']);
						if($zillow_result):
							echo '<br/><br/>Запрос в зиллов прошел успешно!<br/>';
							echo '-----------------------------------------------------------------<br/>';
							echo 'Адрес: '.$properties[$property_index]['address'].'<br/>';
							echo 'Штат: '.$properties[$property_index]['state'].'<br/>';
							echo 'ZIP код: '.$properties[$property_index]['zip_code'].'<br/>';
							echo '-----------------------------------------------------------------<br/>';
							flush();
							$insertProperty = array(
								'zip_code'=>$zillow_result['property-zipcode'],
								'bathrooms'=>$zillow_result['property-bathrooms'],
								'bedrooms'=>$zillow_result['property-bedrooms'],
								'tax'=>$zillow_result['property-tax'],
								'mls'=>'',
								'address1'=>$zillow_result['property-address1'],
								'address2'=>'',
								'city'=>$zillow_result['property-city'],
								'state'=>$zillow_result['property-state'],
								'type'=>$zillow_result['property-type'],
								'sqf'=>$zillow_result['property-sqf'],
								'description'=>'',
								'price'=>0,
								'user_id'=>0
							);
							$propertyExist = $this->properties->csvPropertiesExits($insertProperty['address1'],$insertProperty['state'],$insertProperty['zip_code']);
							if(!$propertyExist):
								$propertyID = $this->properties->insert_record($insertProperty);
								if($propertyID):
									echo 'Недвижимость добавлена успешно!<br/>';
									echo '-----------------------------------------------------------------<br/>';
									echo 'ID недвижимости: '.$propertyID.'<br/>';
									echo '-----------------------------------------------------------------<br/>';
									flush();
									$this->properties->update_field($propertyID,'status',17,'properties');
									$randomNumber = mt_rand(1,1000);
									$nextPropertyID = $this->images->nextID('images');
									$insert = array('main'=>0,'property_id'=>$propertyID,'photo'=>'','owner_id'=>$insertProperty['user_id']);
									$images = $this->arrayImagesFromPage($zillow_result['page-content']);
									if($images):
										$insert['main'] = 1;
										$newFileName = preg_replace('/.+(.)(\.)+/','property_'.$nextPropertyID.'_'.$randomNumber."\$2",$images[0]);
										file_put_contents(getcwd().'/upload_images/'.$newFileName,file_get_contents($images[0]));
										$insert['photo'] = 'upload_images/'.$newFileName;
										$this->images->insert_record($insert);
										$insert['main'] = 0;
										for($i=1;$i<count($images);$i++):
											if(isset($images[$i])):
												$nextPropertyID = $this->images->nextID('images');
												$randomNumber = mt_rand(1,1000);
												$newFileName = preg_replace('/.+(.)(\.)+/','property_'.$nextPropertyID.'_'.$randomNumber."\$2",$images[$i]);
												file_put_contents(getcwd().'/upload_images/'.$newFileName,file_get_contents($images[$i]));
												$insert['photo'] = 'upload_images/'.$newFileName;
												$this->images->insert_record($insert);
											endif;
										endfor;
									endif;
								endif;
							else:
								echo 'Недвижимость существует!<br/>';
								echo '-----------------------------------------------------------------<br/>';
								echo 'ID недвижимости: '.$propertyExist.'<br/>';
								echo '-----------------------------------------------------------------<br/>';
								flush();
							endif;
						endif;
					endif;
					$property_index++;
				endwhile;
				fclose($handle);
				unlink($name);
			endif;
			break;
		endforeach;
		$exec_time = round((microtime(true) - $start_time),2);
		$text = "Скрипт выполнен за: $exec_time сек.\n";
		echo($text);
		echo '</br>Конец работы: '.date("d.m.Y H:i:s");
		exit;
	}

	function removeImagesByZipcode(){
		
		show_error('Cкрипт не работает! Нужно переписать доступ к таблицам!');
		$start_time = microtime(true);
		'Начало работы: '.date("d.m.Y H:i:s").'<br/>';flush();
		$this->load->model('properties_images');
		$this->load->model('images');
		$step = TRUE;
		$offset = 0;
		$count = 100;
		$records = array();
		while($step):
			$records = $this->properties_images->read_limit_records($count,$offset,'properties_images','zipcode','ASC');
			if($records):
				echo '<br/>------------------------<br/>'.$offset.'<br/>------------------------<br/>';
				for($i=0;$i<count($records);$i++):
					$dirPath = $filePath = getcwd().'/upload_images/';
					if($records[$i]['photo']):
						$fileName = substr($records[$i]['photo'],14);
						$filePath .= $fileName;
						if(is_file($filePath)):
							echo "file name: $filePath<br/>";flush();
							$dirPath .= $records[$i]['zipcode'];
							if(!file_exists($dirPath) && !is_dir($dirPath)):
								mkdir($dirPath,0777);
							endif;
							if(rename($filePath,$dirPath.'/'.$fileName)):
								$this->images->update_field($records[$i]['image_id'],'photo','upload_images/'.$records[$i]['zipcode'].'/'.$fileName,'images');
							endif;
							/*if(copy($filePath,$dirPath.'/'.$fileName)):
								unlink($filePath);
							endif;*/
						endif;
					endif;
				endfor;
				$offset += 100;
			else:
				$step = FALSE;
			endif;
		endwhile;
		$exec_time = round((microtime(true) - $start_time),2);
		$text = "Скрипт выполнен за: $exec_time сек.\n";
		echo($text);
		echo '</br>Конец работы: '.date("d.m.Y H:i:s");
		exit;
	}
}
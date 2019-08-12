<!--//////////////////////////////////////////////

API CONNECTION CLASS

///////////////////////////////////////////////-->
<?php
class contentful_conn{
	
	private $space_ID;
	private $access_token;
	private $entry_ID = "%s";
	private $URL = "https://cdn.contentful.com/spaces/%s/entries%s/?access_token=%s";
	private $image_info;
	public $result_picture_array;
	public $result_entry_array;
	
	//IMPORT TOKEN DEFINED IN API_CONFIG PAGE AND SET HTTP REQUEST URL
	
	function __construct($space_ID, $access_token){
		$this->space_ID = $space_ID;
		$this->access_token = $access_token;
		$this->URL = sprintf($this->URL, $this->space_ID, $this->entry_ID, $this->access_token);
	}
	
	//GET JSON INFO FROM API AND DECODE TO ARRAY
	
	function get_entry($entry_ID){
		$json = file_get_contents(sprintf($this->URL, '/' . $entry_ID));
		$this->result_entry_array = json_decode($json, true)['fields'];
		$this->get_entry_pictures();
	}
	
	//EXTRACT ASSET IDS FROM ENTRY ARRAY
	
	private function get_entry_pictures(){
		$json = file_get_contents(sprintf($this->URL, ''));
		$this->image_info = json_decode($json, true)['includes']['Asset'];
		foreach($this->result_entry_array['picture'] as $picture){
			$pic_ID = $picture['sys']['id'];
			$this->result_picture_array[] = array('info' => $this->get_picture_info($pic_ID));
		}
	}
	
	//GET ASSET INFORMATION USING ASSET ID AND SPACE INFO
	
	private function get_picture_info($ID){
		foreach($this->image_info as $asset){
			if ($ID == $asset['sys']['id']){
				return $asset['fields'];
			}
		}
	}
	
}

//IMPORT ACCESS TOKEN INFO FROM API_CONFIG PAGE

require('api_config.php');

?>
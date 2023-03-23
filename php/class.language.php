<?php //class Language

class Language {
    
    private static $instance;
    
    public   $language = '';
    public   $Languages = array('en','de');
    public   $DefaultLanguage = 'en';
    private  $tags = array();
    
    public static function getInstance($REGmon_Folder) {
        if (self::$instance === null) {
            self::$instance = new self($REGmon_Folder);
        }
        return self::$instance;
    }
    
    public function __construct($REGmon_Folder) {

		if (isset($_REQUEST['lang'])) {
            if (in_array($_REQUEST['lang'], $this->Languages)) {
                $this->language = $_REQUEST['lang'];
            }
        } 
		elseif (isset($_COOKIE['LANG'])) {
            $this->language = $_COOKIE['LANG'];
        }
		elseif (isset($_SERVER['HTTP_ACCEPT_LANGUAGE'])) {
			//break up string into pieces (languages and q factors)
			preg_match_all('/([a-z]{1,8}(-[a-z]{1,8})?)\s*(;\s*q\s*=\s*(1|0\.[0-9]+))?/i', $_SERVER['HTTP_ACCEPT_LANGUAGE'], $lang_parse);

			$langs = array();
			if (count($lang_parse[1])) {
				$langs = array_combine($lang_parse[1], $lang_parse[4]); //create a list like "en" => 0.8
				
				foreach ($langs as $lang => $val) { //set default to 1 for any without q factor
					if ($val === '') $langs[$lang] = 1;
				}				
				arsort($langs, SORT_NUMERIC); //sort list based on value	
			}

			//look through sorted list and use first one that matches our languages
			foreach ($langs as $lang => $val) {
				if (strpos($lang, 'en') === 0) { 
                    $this->language = 'en';
                    break; 
                }
				elseif (strpos($lang, 'de') === 0) { 
                    $this->language = 'de'; 
                    break; 
                }
                else {
                    $this->language = $this->DefaultLanguage;
                }			
			}
		}
		else {
            $this->language = $this->DefaultLanguage;
        }
		
        if (!in_array($this->language, $this->Languages)) { 
			$this->language = $this->DefaultLanguage;
        }

		setcookie ('LANG', $this->language, time() + (2 * 365 * 24 * 60 * 60), '/'.$REGmon_Folder); //2 years

        $this->tags = include (__DIR__.'/lang_'.$this->language.'.php');
    }
    
    public function __destruct() {
    	$this->language = '';
    	$this->tags = array();
    }
    
    public function __get($tag) {
        if (!isset($this->tags[$tag])) {
            error_log('Missing Language Tag : '.$tag);
            return '_['.$tag.']_';
        } 
        return $this->tags[$tag];
    }
}
?>
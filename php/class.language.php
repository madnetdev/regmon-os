<?php //class Language

class Language {
    
    /**
     * @var static $instance
     */
    private static $instance = null;
    
    /**
     * @var string $language
     */
    public $language = '';
    /**
     * @var mixed $Languages
     */
    public $Languages = array('en','de');
    /**
     * @var string $Default_Language
     */
    public $Default_Language = 'en';
    /**
     * @var bool $Use_Multi_Language_Selector
     */
    public $Use_Multi_Language_Selector = true;
    /**
     * @var mixed $tags
     */
    private $tags = array();
    
    /**
     * @param string $REGmon_Folder
     * @param string $Default_Language
     * @param bool $Use_Multi_Language_Selector
     */
    public static function getInstance(string $REGmon_Folder, string $Default_Language, bool $Use_Multi_Language_Selector) {
        if (self::$instance === null) {
            self::$instance = new self($REGmon_Folder, $Default_Language, $Use_Multi_Language_Selector);
        }
        return self::$instance;
    }
    
    /**
     * @param string $REGmon_Folder
     * @param string $Default_Language
     * @param bool $Use_Multi_Language_Selector
     */
    public function __construct(string $REGmon_Folder, string $Default_Language, bool $Use_Multi_Language_Selector) {

		if (!$Use_Multi_Language_Selector) {
            $this->Default_Language = $Default_Language;
            $this->language = $Default_Language;
        }
		elseif (isset($_REQUEST['lang'])) {
            if (in_array($_REQUEST['lang'], (array)$this->Languages)) {
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
                    $this->language = $this->Default_Language;
                }			
			}
		}
		else {
            $this->language = $this->Default_Language;
        }
		
        if (!in_array($this->language, (array)$this->Languages)) { 
			$this->language = $this->Default_Language;
        }

        $cookie_options = array(
            'expires' => time() + (2 * 365 * 24 * 60 * 60),
            'path' => '/'.$REGmon_Folder,
            //'domain' => null,
            'secure' => false,
            'httponly' => false,
            'samesite' => 'Lax' // None || Lax || Strict
        );

        setcookie ('LANG', $this->language, $cookie_options); //2 years

        $this->tags = include (__DIR__.'/lang_'.$this->language.'.php');
    }
    
    public function __destruct() {
        $this->language = '';
        $this->tags = array();
    }
    
    public function __get(mixed $tag):mixed {
        if (!isset($this->tags[$tag])) {
            error_log('Missing Language Tag : '.$tag);
            return '_['.$tag.']_';
        } 
        return $this->tags[$tag];
    }
}
?>
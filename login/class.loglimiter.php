<?php
/**
* LogLimiter class.
*
* Provides a simple way to implement a limitator for login attempts
* @author Francesco Cirac. <sydarex@gmail.com>
* @copyright Copyleft (c) 2009, Francesco Cirac.

* @changed by MAD to fit in REGmon project
*/
class LogLimiter {

	/**
	 * Max attempts concessed before blocking.
	 *
	 * @access private
	 * @var integer
	 */
	private $Max_Attempts = 0;

	/**
	 * Time of blocking (minutes).
	 *
	 * @access private
	 * @var integer
	 */
	private $Block_Minutes = 0;

	/**
	 * Validity attempts in attempts counting (minutes)
	 *
	 * @access private
	 * @var integer
	 */
	private $Reset_Attempts_Minutes = 0;

	/**
	 * MySQL connection handler.
	 *
	 * @access private
	 * @var object
	 */
	private $db;

	/**
	 * Client IP.
	 *
	 * @access private
	 * @var string
	 */
	private $ip = null;

	/**
	 * Class constructor. Sets class vars and deletes expired attempts.
	 *
	 * @param object $db database object.
	 * @param integer $Max_Attempts max attempts concessed before blocking.
	 * @param integer $Block_Minutes time of blocking (minutes).
	 * @param integer $Reset_Attempts_Minutes validity attempts in attempts counting (minutes).
	 */
	function __construct($db, $Max_Attempts, $Block_Minutes, $Reset_Attempts_Minutes) {
		$this->db = $db;
		$this->ip = $_SERVER['REMOTE_ADDR'];
		$this->Max_Attempts = $Max_Attempts;
		$this->Block_Minutes = $Block_Minutes;
		$this->Reset_Attempts_Minutes = $Reset_Attempts_Minutes;
		$this->deleteExpired();
	}

	/**
	 * Deletes expired blocks and attempts from database.
	 * 
	 * @access private
	 */
	private function deleteExpired():void {
		$this->db->delete("login_blocks", "expire <= ?", array(time()));
		$time_pass = time() - ($this->Block_Minutes * 60);
		$this->db->delete("login_attempts", "date <= ?", array($time_pass));
	}


	/**
	 * Blocks the current IP
	 */
	function blockIP():void {
		$values = array();			
		$values['ip'] = $this->ip;
		$values['expire'] = ($this->Block_Minutes * 60) + time();
		$this->db->insert($values, "login_blocks");
	}

	/**
	 * Checks if there is an IP block.
	 * 
	 * @return bool
	 */
	function checkBlock() {
		$this->db->fetch("SELECT * FROM login_blocks WHERE ip = ?", array($this->ip));
		if ($this->db->numberRows() > 0) {
			return true;
		}
		return false;
	}

	/**
	* Logs a failed login attempt.
	*/
	function logFailedAttempt():void {
		$values = array();			
		$values['ip'] = $this->ip;
		$values['date'] = time();
		$this->db->insert($values, "login_attempts");
	}

	/**
	* Counts how many attempts from this IP.
	*/
	function countFailedAttempts():int {
		$this->db->fetch("SELECT * FROM login_attempts WHERE ip = ?", array($this->ip));
		return $this->db->numberRows();
	}

	/**
	* Call this method when a login fails. 
	* Logs the attempt and checks if a block is needed. If is, does it.
	*/
	function failedAttempt():void {
		$this->logFailedAttempt();
		if ($this->countFailedAttempts() >= $this->Max_Attempts) {
			$this->blockIP();
		}
	}

	/**
	* Call this method when a login goes right. Deletes the attempts from this IP.
	*/
	function login():void {
		$this->db->delete("login_attempts", "ip = ?", array($this->ip));
	}
 }
 ?>
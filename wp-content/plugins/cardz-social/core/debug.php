<?php if (!defined('ABSPATH')) { exit; }

/**
 *	Deubgging utility class.
 */
class AP_Debug
{
	/**
	 *	The instance of this class.
	 */
	private static $instance = null;
	
	/**
	 *	The log array.
	 */
	private $log_stack = array();
	
	/**
	 *	Whether to show this in the browser's console.
	 */
	public $show_in_console = true;
	
	
	/**
	 *	Loging types.
	 */
	const TYPE_LOG = 'log';
	const TYPE_INFO = 'info';
	const TYPE_WARN = 'warn';
	const TYPE_ERROR = 'error';
	const TYPE_DUMP = 'dump';

	/**
	 *	Default constructor.
	 */
	public function __construct()
	{
		add_action('wp_footer', array(&$this, 'insert_in_footer'));
		add_action('admin_footer', array(&$this, 'insert_in_footer'));
	}
	
	/**
	 *	Returns the instance of this class.
	 */
	public static function get_instance()
	{
		if (self::$instance === null)
		{
			self::$instance = new self();
		}
		
		return self::$instance;
	}
	
	/**
	 *	Insert the logs in the footer.
	 */
	public function insert_in_footer()
	{
	?>
		<script type="text/javascript">
			/* <![CDATA[ */
				<?php foreach ($this->log_stack as $log) : ?>
					console.<?php echo $log->type; ?>(<?php echo $log->content; ?>);
				<?php endforeach; ?>
			/* ]]> */
		</script>
	<?php
	}
	
	/**
	 *	Log the given data to the broser's console using .log().
	 *
	 *	@param $data...	The data to be printed.
	 */
	public function log()
	{
		$args = func_get_args();
		
		$this->add_to_log(self::TYPE_LOG, $args);
	}
	
	/**
	 *	Log the given data to the broser's console using .info().
	 *
	 *	@param $data...	The data to be printed.
	 */
	public function info()
	{
		$args = func_get_args();
		
		$this->add_to_log(self::TYPE_INFO, $args);
	}
	
	/**
	 *	Log the given data to the broser's console using .warn().
	 *
	 *	@param $data...	The data to be printed.
	 */
	public function warn()
	{
		$args = func_get_args();
		
		$this->add_to_log(self::TYPE_WARN, $args);
	}
	
	/**
	 *	Log the given data to the broser's console using .error().
	 *
	 *	@param $data...	The data to be printed.
	 */
	public function error()
	{
		$args = func_get_args();
		
		$this->add_to_log(self::TYPE_ERROR, $args);
	}
	
	/**
	 *	Show a back trace for debugging.
	 *
	 *	By default the data is printed on the screen.
	 *
	 *	@param $show_in_console	Whether to show this in the browser's console.
	 */
	public function trace($show_in_console = true)
	{
		$trace = debug_backtrace();
		
		if ($show_in_console)
		{
			$this->add_to_log(self::TYPE_LOG, array($trace));
		}
	}
	
	/**
	 *	Dump one or more vairables.
	 *
	 *	@params $vars... The variables to dump.
	 */
	public function dump()
	{
		$args = func_get_args();
		$data = array();
		
		ob_start();
		
		foreach ($args as $arg)
		{
			var_dump($arg);
			$data[] = ob_get_contents();
			ob_clean();
		}
		
		ob_end_clean();
		
		$this->add_to_log(self::TYPE_LOG, $data);
	}
	
	/**
	 *	Format the data and put it in an array, for later retrieval.
	 *
	 *	@param $type The type of log.
	 *	@param $data An array of data to be logged.
	 */
	private function add_to_log($type, $data)
	{
		$value = '';
		
		foreach ($data as $item)
		{
			$item = (is_string($item)) ? $item : print_r($item, true);
			
			if ($this->show_in_console)
			{
				// escape
				$item = html_entity_decode($item, ENT_QUOTES, 'UTF-8');
				$item = str_replace("\t", '\t', $item);
				$item = str_replace("\n", '\n', $item);
				$item = str_replace("\r", '\r', $item);
				$item = str_replace("'", "\'", $item);
				$item = str_replace(",", "\,", $item);
				$item = "'" . $item . "'";
			}
			
			$value .= $item . ',';
		}
		
		$value = rtrim($value, ',');
		
		if (!$this->show_in_console)
		{
			echo '<pre>' . $value . '</pre>';
		}
		else
		{
			$log = new stdClass();
			
			$log->type = $type;
			$log->content = $value;
			
			$this->log_stack[] = $log;
		}
	}
}

/**
 *	Interface for AP_Debug. This is only to make the usage simpler.
 *
 *	@param $show_in_console	Whether to show this in the browser's console. Default to true.
 */
function ap_debug($show_in_console = true)
{
	$instance = AP_Debug::get_instance();
	
	$instance->show_in_console = $show_in_console;
	
	return $instance;
}
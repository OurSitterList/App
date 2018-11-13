<?php
if ( ! function_exists('load_class'))
{
	function &load_class($class, $directory = 'includes/classes', $param = NULL)
	{
		static $_classes = array();
		// Does the class exist? If so, we're done...
		if (isset($_classes[$class]))
		{
			return $_classes[$class];
		}

		$name = FALSE;
		// Look for the class first in the local application/libraries folder
		// then in the native system/libraries folder
		foreach (array(BASEPATH) as $path)
		{
			if (file_exists($_SERVER["DOCUMENT_ROOT"].'/'.$directory.'/'.$class.'.php'))
			{
				$name = $class;
				if (class_exists($name, FALSE) === FALSE)
				{
					require_once($_SERVER["DOCUMENT_ROOT"].'/'.$directory.'/'.$class.'.php');
				}
				break;
			}
		}
		
		// Did we find the class?
		if ($name === FALSE)
		{
			// Note: We use exit() rather then show_error() in order to avoid a
			// self-referencing loop with the Exceptions class
			http_response_code(503);
			echo 'Unable to locate the specified class: '.$class.'.php';
			exit(5); // EXIT_UNK_CLASS
		}

		// Keep track of what we just loaded
		is_loaded($class);

		$_classes[$class] = isset($param)
			? new $name($param)
			: new $name();
		return $_classes[$class];
	}
}

// --------------------------------------------------------------------

if ( ! function_exists('is_loaded'))
{
	/**
	 * Keeps track of which libraries have been loaded. This function is
	 * called by the load_class() function above
	 *
	 * @param	string
	 * @return	array
	 */
	function &is_loaded($class = '')
	{
		static $_is_loaded = array();

		if ($class !== '')
		{
			$_is_loaded[strtolower($class)] = $class;
		}

		return $_is_loaded;
	}
}

load_class('Setting');
load_class('Cryptography');
load_class('Response');
load_class('Auth');
load_class('MyAccount');
load_class('Booking');
load_class('Notification');
load_class('Actions');
?>

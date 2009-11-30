<?php
/* 
	SimpleTest + CodeIgniter
	
	test.php
	the test runner - loads all needed files,
	integrates with CodeIgniter and runs the tests
	
	by Jamie Rumbelow
	http://jamierumbelow.net/
*/

//Configure and load files
define('ROOT', dirname(__FILE__) . '/');

require_once ROOT . 'system/test/unit_tester.php';
require_once ROOT . 'system/test/web_tester.php';
require_once ROOT . 'system/test/reporter.php';

function add_test($file, &$test) {
	$implementation = '';
 
	if (preg_match('/_controller/', $file)) {
		$controller = preg_replace('#' . ROOT . 'application/tests/controllers/([a-zA-Z0-9_\-])_controller.php#', '$1', $file);
		$implementation = ROOT . 'application/controllers/'.$controller.'.php';
	} elseif (preg_match('/_model/', $file)) {
		$model = preg_replace('#' . ROOT . 'application/tests/models/([a-zA-Z0-9_\-])_model.php#', '$1', $file);
		$implementation = ROOT . 'application/models/'.$model.'_model.php';
	} elseif (preg_match('/_view/', $file)) {
		$view = preg_replace('#' . ROOT . 'application/tests/views/([a-zA-Z0-9_\-])_view.php#', '$1', $file);
		$view = implode('/', explode('_', $view));
		$implementation = ROOT . 'application/views/'.$view.'.php';
	}
	elseif (preg_match('/_library/', $file)) {
		$view = preg_replace('#' . ROOT . 'application/tests/libraries/([a-zA-Z0-9_\-])_library.php#', '$1', $file);
		$view = implode('/', explode('_', $view));
		$implementation = ROOT . 'application/libraries/'.$view.'.php';
	}
	elseif (preg_match('/_helper/', $file)) {
		$view = preg_replace('#' . ROOT . 'application/tests/helpers/([a-zA-Z0-9_\-])_helper.php#', '$1', $file);
		$view = implode('/', explode('_', $view));
		$implementation = ROOT . 'application/helpers/'.$view.'_helper.php';
	}
 
	if (file_exists($implementation)) {
		require_once($implementation);
	}
 
	$test->addFile($file);
}

class CodeIgniterUnitTestCase extends UnitTestCase { 
	protected $ci;
	
	public function __construct() {
		parent::UnitTestCase();
		$this->ci =& get_instance();
	}
}

class CodeIgniterWebTestCase extends WebTestCase { 
	protected $ci;
	
	public function __construct() {
		parent::WebTestCase();
		$this->ci =& get_instance();
	}
}

//Capture CodeIgniter output, discard and load system into $CI variable
ob_start();
	include(ROOT . 'index.php');
	$CI =& get_instance();
ob_end_clean();

//Setup the test suite
$test =& new TestSuite();
$test->_label = 'CodeIgniter Application Test Suite';

if (!isset($_GET['test'])) {
	//What are we testing?
	$files = array();

	if (isset($_GET['controllers'])) {
		$files = @scandir(ROOT . 'application/tests/controllers');
	} elseif (isset($_GET['models'])) {
		$files = @scandir(ROOT . 'application/tests/models');
	}	elseif (isset($_GET['models'])) {
		$files = @scandir(ROOT . 'application/tests/views');
	} elseif (isset($_GET['all'])) {
		$files = @scandir(ROOT . 'application/tests/controllers');
		$files = array_merge($files, @scandir(ROOT . 'application/tests/models'));
		$files = array_merge($files, @scandir(ROOT . 'application/tests/views'));
	} else {
		//Use all by default
		$files = @scandir(ROOT . 'application/tests/controllers');
		$files = array_merge($files, @scandir(ROOT . 'application/tests/models'));
		$files = array_merge($files, @scandir(ROOT . 'application/tests/views'));
		$files = array_merge($files, @scandir(ROOT . 'application/tests/libraries'));
		$files = array_merge($files, @scandir(ROOT . 'application/tests/helpers'));
	}

	//Remove ., .. and any .whatever files, and add the full path
	function prepare_array($value, $key) {
	  global $files;
	  
		if (preg_match('/^\./', $value)) { unset($files[$key]); }
		if (preg_match('/_model/', $value)) { $files[$key] = ROOT . 'application/tests/models/' . $value; }
		if (preg_match('/_controller/', $value)) { $files[$key] = ROOT . 'application/tests/controllers/' . $value; }
		if (preg_match('/_view/', $value)) { $files[$key] = ROOT . 'application/tests/views/' . $value; }
		if (preg_match('/_library/', $value)) { $files[$key] = ROOT . 'application/tests/libraries/' . $value; }
		if (preg_match('/_helper/', $value)) { $files[$key] = ROOT . 'application/tests/helpers/' . $value; }
	}

	array_walk($files, 'prepare_array');

	//Add each file to the test suite
	foreach ($files as $file) {
		add_test($file, &$test);
	}
} else {
	add_test(ROOT . 'application/tests/' . $file, &$test);
}

//Run tests!
$test->run(new HtmlReporter());
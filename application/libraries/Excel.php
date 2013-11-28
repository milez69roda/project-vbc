<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
02	 
12	require_once APPPATH."/third_party/PHPExcel.php";
13	 
14	class Excel extends PHPExcel {
15	    public function __construct() {
16	        parent::__construct();
17	    }
18	}
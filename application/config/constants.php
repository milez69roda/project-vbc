<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');


define('WEBSITE_HEADER',	'Project VBC Admin');
define('WEBSITE_TITLE',		'Project VBC Admin');

define('PROFILE_IMAGE_PATH','photo');


define('TERM_ACTIVE',			'0'); //Active
define('TERM_EXPIRED',			'1'); //Expired
define('TERM_SUSPENSION',		'2'); //Suspension
define('TERM_TERMINATION',		'3'); //Termination
define('TERM_ROLLING_MONTLY',	'4'); //Rolling Monthly
define('TERM_DELETED',			'5'); //Deleted
define('TERM_EXTEND_6',			'6'); //Extend 6 months
define('TERM_EXTEND_12',		'12'); //Extend 12 months

 
define('PAY_STATUS_0', 			0); //no payment yet
define('PAY_STATUS_1', 			1);
define('PAY_STATUS_2', 			2);
define('PAY_STATUS_3', 			3); //payment accepted

define('PAYMENT_MODE_CC', 		0); //payment by credit card
define('PAYMENT_MODE_DD', 		1); //dd
define('PAYMENT_MODE_CASH', 	2); //payment by cash

define('PAYMENT_CC_MONTLY',		0); //Payment Monthly
define('PAYMENT_CC_FULL',		1); //Payment full

//used in the shedule payment table
define('PAYMENT_TYPE_CC',			0); //Credit card
define('PAYMENT_TYPE_CASH',			1); //cash
define('PAYMENT_TYPE_MAILORDER',	2); //mail oder
define('PAYMENT_TYPE_NETS',			3); //nets
define('PAYMENT_TYPE_VISA',			4); //visa
define('PAYMENT_TYPE_MASTERCARD',	5); //mastercard
define('PAYMENT_TYPE_CHEQUE',		6); //cheque
define('PAYMENT_TYPE_WITH_GST',		7); //with GST
define('PAYMENT_TYPE_WITH_OUT_GST',	8); //without GST
 
define('FPDF_FONTPATH',APPPATH .'third_party/fpdf/font/');
/* End of file constants.php */
/* Location: ./application/config/constants.php */
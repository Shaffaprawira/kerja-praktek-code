<?php
defined('BASEPATH') OR exit('No direct script access allowed');

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
define('DIR_WRITE_MODE', 0755);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ', 'rb');
define('FOPEN_READ_WRITE', 'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE', 'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE', 'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE', 'ab');
define('FOPEN_READ_WRITE_CREATE', 'a+b');
define('FOPEN_WRITE_CREATE_STRICT', 'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT', 'x+b');


/*
|--------------------------------------------------------------------------
| Display Debug backtrace
|--------------------------------------------------------------------------
|
| If set to TRUE, a backtrace will be displayed along with php errors. If
| error_reporting is disabled, the backtrace will not display, regardless
| of this setting
|
*/
define('SHOW_DEBUG_BACKTRACE', TRUE);

/*
|--------------------------------------------------------------------------
| Exit Status Codes
|--------------------------------------------------------------------------
|
| Used to indicate the conditions under which the script is exit()ing.
| While there is no universal standard for error codes, there are some
| broad conventions.  Three such conventions are mentioned below, for
| those who wish to make use of them.  The CodeIgniter defaults were
| chosen for the least overlap with these conventions, while still
| leaving room for others to be defined in future versions and user
| applications.
|
| The three main conventions used for determining exit status codes
| are as follows:
|
|    Standard C/C++ Library (stdlibc):
|       http://www.gnu.org/software/libc/manual/html_node/Exit-Status.html
|       (This link also contains other GNU-specific conventions)
|    BSD sysexits.h:
|       http://www.gsp.com/cgi-bin/man.cgi?section=3&topic=sysexits
|    Bash scripting:
|       http://tldp.org/LDP/abs/html/exitcodes.html
|
*/
define('EXIT_SUCCESS', 0); // no errors
define('EXIT_ERROR', 1); // generic error
define('EXIT_CONFIG', 3); // configuration error
define('EXIT_UNKNOWN_FILE', 4); // file not found
define('EXIT_UNKNOWN_CLASS', 5); // unknown class
define('EXIT_UNKNOWN_METHOD', 6); // unknown class member
define('EXIT_USER_INPUT', 7); // invalid user input
define('EXIT_DATABASE', 8); // database error
define('EXIT__AUTO_MIN', 9); // lowest automatically-assigned error code
define('EXIT__AUTO_MAX', 125); // highest automatically-assigned error code


/* define constant for specific application */
// $bcc = 'sabbana.log@gmail.com';
//$bcc = 'sabbana.log@gmail.com,ijtech@eng.ui.ac.id,bccmultiijtech@ruki.web.id';
//$bcc = 'ijtech@eng.ui.ac.id,bccmultiijtech@ruki.web.id';
$bcc = 'ijtech.website@gmail.com';
define('P_ISSN', '2086-9614');
define('E_ISSN', '2087-2100');
// define('MAILSYSTEM', 'journal@sstud-io.net');
define('MAILSYSTEM', 'noreply@ijtech.eng.ui.ac.id');
//define('BCC_MAILSYSTEM', 'ijtech@eng.ui.ac.id,bccijtech@ruki.web.id');
define('BCC_MAILSYSTEM', 'ijtech.website@gmail.com');
define('BCC_MAILSYSTEM_MULTI', $bcc);
define('REMINDER_AUTHOR', 14);
define('REMINDER_REVIEWER', 14); //10apr2021: ini ga kepake
define('DAY_AFTER_ACCEPT', 7);

define('DAY_TO_REVIEW_MANUSCRIPT', 21); //day to reveiw (after acepting invitation) //26mei2022: ganti ke 21 tadinya 7
define('DAY_TO_ACCEPT_REVIEW', 3);
define('DAY_REVISE_SCREENING', 7);

define('DAY_4_REVR_2_RESPOND_INVTN', 3);
define('DAY_4_REVR_2_GIVE_REVW', 7);

define('MAX_REMIND_TIMES', 3); //tadinya 50
define('MAX_BULK_SENDMAIL', 15); //tadinya 50


define('NOTIF_ALL_AUTHOR', true);

// Define Ajax Request
define('IS_AJAX', isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest');

define('GLOBAL_MSG_DASHBOARD', ""); //"System maintenance will be conducted at 19-20 August 2023 (GMT+7).<br>Any changes (registration, submission, or reviewing) during that period may not be saved correctly.");
define('GLOBAL_MSG_FRONT', ""); //"System maintenance will be conducted at 19-20 August 2023 (GMT+7).<br>Any changes (registration, submission, or reviewing) during that period may not be saved correctly.");
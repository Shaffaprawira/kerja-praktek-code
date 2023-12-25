<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = 'home';
$route['about'] = 'home/about';
$route['about/(:any)'] = 'home/about/$1';
$route['about/(:any)/(:any)'] = 'home/about/$1/$2';
$route['announcement'] = 'home/announcement';
$route['announcement/(:any)/(:any)'] = 'home/announcement/$1/$2';
$route['announcement/page'] = 'home/announcement';
$route['download_bibtex/(:any)'] = 'home/download_bibtex/$1';
$route['article'] = 'home';
$route['article/page/(:any)'] = 'home/index/page/$1';
$route['article/page'] = 'home/index';
$route['article/(:any)'] = 'home/article/$1';
$route['article/(:any)/(:any)'] = 'home/article/$1/$2';
$route['reviewer'] = 'home/reviewer';
$route['reviewer/(:any)'] = 'home/reviewer/$1';

$route['search'] = 'home/search';
$route['search/page/(:any)'] = 'home/search/page/$1';

$route['archives'] = 'home/archives';
$route['issue'] = 'home/issue';
$route['people'] = 'home/people';
$route['issue/(:any)'] = 'home/issue/$1';

$route['confirmation/(:any)/(:any)'] = 'home/confirmation/$1/$2';

$route['404_override'] = '_404';
$route['reset'] = 'login/reset';
$route['reset/(:any)/(:any)'] = 'login/reset/$1/$2';
$route['register'] = 'home/register';

$route['invitation/(:any)/(:any)/(:any)'] = 'dashboard/invitation/$1/$2/$3';
$route['invitation/(:any)/(:any)/(:any)/(:any)'] = 'dashboard/invitation/$1/$2/$3/$4';

$route['download/article/(:any)'] = 'home/download/$1';

# route old journal view articel
$route['journal/(:any)/(:any)/(:any)'] = 'journal_old/referal/$1/$2/$3'; // for preview or download article
# route old jurnal issue
$route['index.php/journal/issue/(:any)/(:any)'] = 'journal_old/referal_issue/$1/$2'; // for issue articel

# export route
$route['dashboard/export'] = 'export/index'; 
$route['dashboard/export/reviewer'] = 'export/submission'; 

$route['dashboard/export/reviewer'] = 'export/reviewer'; 


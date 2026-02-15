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
|	https://codeigniter.com/userguide3/general/routing.html
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

// Halaman pengumuman
$route['pengumuman'] = 'announcement/index';
$route['pengumuman/(:num)'] = 'announcement/detail/$1';
$route['pengumuman/penting'] = 'announcement/important';
$route['pengumuman/terbaru/(:num)'] = 'announcement/latest_json/$1';
$route['pengumuman/terbaru'] = 'announcement/latest_json/5';

// Halaman berita
$route['berita'] = 'news/index';
$route['berita/detail/(:any)'] = 'news/detail/$1';

$route['kelulusan'] = 'kelulusan/index';

$route['profil/password']        = 'profil/password';
$route['profil/password/update'] = 'profil/password_update';

// Admin auth + dashboard
$route['admin']         = 'admin/dashboard';
$route['admin/login']   = 'admin/login';
$route['admin/logout']  = 'admin/logout';

$route['admin/forgot_password']        = 'admin/forgot_password';
$route['admin/forgot_password/process'] = 'admin/forgot_password_process';

$route['admin/forgot_password/otp'] = 'admin/forgot_password_otp';
$route['admin/forgot_password/verify'] = 'admin/forgot_password_verify';
$route['admin/forgot_password/resend'] = 'admin/forgot_password_resend';
$route['admin/forgot_password/new_password'] = 'admin/forgot_password_new_password';
$route['admin/forgot_password/new_password_process'] = 'admin/forgot_password_new_password_process';


// CRUD Pengumuman di admin
$route['admin/pengumuman']              = 'admin_pengumuman/index';
$route['admin/pengumuman/tambah']       = 'admin_pengumuman/create';
$route['admin/pengumuman/edit/(:num)']  = 'admin_pengumuman/edit/$1';
$route['admin/pengumuman/hapus/(:num)'] = 'admin_pengumuman/delete/$1';

// CRUD Berita di admin
$route['admin/berita']                = 'admin_berita/index';
$route['admin/berita/tambah']         = 'admin_berita/create';
$route['admin/berita/edit/(:num)']    = 'admin_berita/edit/$1';
$route['admin/berita/hapus/(:num)']   = 'admin_berita/delete/$1';

// CRUD Kelulusan di admin
$route['admin/kelulusan']                = 'admin_kelulusan/index';
$route['admin/kelulusan/tambah']         = 'admin_kelulusan/create';
$route['admin/kelulusan/edit/(:num)']    = 'admin_kelulusan/edit/$1';
$route['admin/kelulusan/hapus/(:num)']   = 'admin_kelulusan/delete/$1';

// CRUD Admin User (hanya super_admin)
$route['admin/users']              = 'admin_users/index';
$route['admin/users/tambah']       = 'admin_users/create';
$route['admin/users/edit/(:num)']  = 'admin_users/edit/$1';
$route['admin/users/hapus/(:num)'] = 'admin_users/delete/$1';

// CRUD Tahun Kelulusan
$route['admin/tahun-kelulusan']              = 'admin_tahun_kelulusan/index';
$route['admin/tahun-kelulusan/tambah']       = 'admin_tahun_kelulusan/create';
$route['admin/tahun-kelulusan/edit/(:num)']  = 'admin_tahun_kelulusan/edit/$1';
$route['admin/tahun-kelulusan/hapus/(:num)'] = 'admin_tahun_kelulusan/delete/$1';

$route['admin/kategori']              = 'admin_kategori/index';
$route['admin/kategori/tambah']       = 'admin_kategori/create';
$route['admin/kategori/edit/(:num)']  = 'admin_kategori/edit/$1';
$route['admin/kategori/hapus/(:num)'] = 'admin_kategori/delete/$1';


$route['default_controller'] = 'home';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

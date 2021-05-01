<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php')) {
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('Home');
$routes->setDefaultMethod('index');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/**
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.
$routes->get('/', 'Dashboard::index');
$routes->get('/export-pdf', 'Export::export_pdf');
$routes->get('/export-excel', 'Export::export_excel');

$routes->get('/ajax-jquery', 'Ajax::index');
$routes->get('/ajax-jquery/get_data', 'Ajax::get_data');
$routes->get('/ajax-jquery/get_modal', 'Ajax::get_modal');
$routes->post('/ajax-jquery/save_data', 'Ajax::save_data');
$routes->post('/ajax-jquery/get_modal_edit', 'Ajax::get_modal_edit');
$routes->post('/ajax-jquery/update_data', 'Ajax::update_data');
$routes->post('/ajax-jquery/delete_data', 'Ajax::delete_data');

/**
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php')) {
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}

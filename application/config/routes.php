<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "users_interface";
$route['404_override'] = '';

$route['set-db-data'] = 'users_interface/setDbData';
$route['clear-session'] = 'users_interface/clearSession';
$route['valid/exist-email'] = 'ajax_interface/existEmail';

/*************************************************** AJAX INTRERFACE ***********************************************/

$route['login-in']				= "ajax_interface/login";
$route['signup-account']		= "ajax_interface/signup_account";
$route['signup-properties']		= "ajax_interface/signup_properties";
$route['seller-signup-properties'] = "ajax_interface/seller_signup_properties";
$route['change-user-status']	= "ajax_interface/change_user_status";
$route['save-property-info']	= "ajax_interface/save_property_info";
$route['send-forgot-password']	= "ajax_interface/send_forgot_password";
$route['multi-upload']			= "ajax_interface/multiUpload";
$route['delete-property-images']= "ajax_interface/deletePropertyImages";
$route['save-profile']			= "ajax_interface/saveProfile";
$route['set-current-owner']			= "ajax_interface/setCurrentOwner";
$route['text-load/:any/from/:num']	= "ajax_interface/text_load";
$route[BROKER_START_PAGE.'/delete']	= "ajax_interface/deleteProperty";
$route[OWNER_START_PAGE.'/delete/seller']	= "ajax_interface/deletePropertySeller";
$route['search-properties'] = "ajax_interface/searchProperty";
$route['add-to-favorite'] = "ajax_interface/addToFavorite";
$route['remove-to-favorite'] = "ajax_interface/removeToFavorite";
$route['add-to-potential-by'] = "ajax_interface/addToPotentialBy";
$route['remove-to-potential-by'] = "ajax_interface/removeToPotentialBy";
$route['get-property-zillow-api'] = "ajax_interface/getPropertyZillowAPI";
/*************************************************** USERS INTRERFACE ***********************************************/

$route['login']				= "users_interface/login";
$route['signup']			= "users_interface/signup";

$route['search']			= "users_interface/search";
$route['how-it-works']		= "users_interface/howItWorks";
$route['trading-concepts'] 	= "users_interface/tradingConcepts";
$route['about-us']			= "users_interface/aboutUs";
$route['contacts']			= "users_interface/contacts";
// ***************************************************************** footer
$route['search-for-one']	= "users_interface/searchForOne";
$route['advanced-search']	= "users_interface/advancedSearch";
$route['lastest-offers']	= "users_interface/lastestOffers";
$route['properties-for-sale']= "users_interface/propertiesForSale";
$route['company']			= "users_interface/company";
$route['step-by-step']		= "users_interface/stepByStep";
$route['virtual-tour']		= "users_interface/virtualTour";

$route['password-recovery']	= "users_interface/pswdRecovery";
$route['logout']			= "users_interface/logout";
$route['confirm-registering/:any/activation-code/:any'] = "users_interface/confirm_registering";
$route['password-recovery/:any/temporary-code/:any'] = "users_interface/confirm_temporary_code";

/*************************************************** BROKERS INTRERFACE ***********************************************/

$route[BROKER_START_PAGE] = "broker_interface/properties";
$route['broker/:any/information'] = "broker_interface/property";
$route['broker/:any/information/:num'] = "broker_interface/property";
$route['broker/register-properties'] = "broker_interface/register_properties";
$route[BROKER_START_PAGE.'/edit'] = "broker_interface/edit_property";
$route[BROKER_START_PAGE.'/edit/:num'] = "broker_interface/edit_property";
$route['broker/search'] = "broker_interface/searchProperty";
$route['broker/search/result'] = "broker_interface/searchProperty";
$route['broker/search/result/from'] = "broker_interface/searchProperty";
$route['broker/search/result/from/:num'] = "broker_interface/searchProperty";
$route['broker/favorite'] = "broker_interface/favoriteProperty";
$route['broker/favorite/from'] = "broker_interface/favoriteProperty";
$route['broker/favorite/from/:num'] = "broker_interface/favoriteProperty";
$route['broker/potential-by'] = "broker_interface/potentialByProperty";
$route['broker/potential-by/from'] = "broker_interface/potentialByProperty";
$route['broker/potential-by/from/:num'] = "broker_interface/potentialByProperty";

$route['broker/profile'] = "broker_interface/profile";
$route['broker/set-password'] = "broker_interface/setPassword";

/*************************************************** OWNERS INTRERFACE ***********************************************/

$route['homeowner/search'] = "owner_interface/searchProperty";
$route['homeowner/search/result'] = "owner_interface/searchProperty";
$route['homeowner/search/result/from'] = "owner_interface/searchProperty";
$route['homeowner/search/result/from/:num'] = "owner_interface/searchProperty";

$route[OWNER_START_PAGE] = "owner_interface/properties";
$route['homeowner/:any/information'] = "owner_interface/property";
$route['homeowner/properties/information/:num'] = "owner_interface/property";
$route[OWNER_START_PAGE.'/edit'] = "owner_interface/edit_property";
$route[OWNER_START_PAGE.'/edit/:num'] = "owner_interface/edit_property";

$route['homeowner/register-properties'] = "owner_interface/register_properties";

$route['homeowner/favorite'] = "owner_interface/favoriteProperty";
$route['homeowner/favorite/from'] = "owner_interface/favoriteProperty";
$route['homeowner/favorite/from/:num'] = "owner_interface/favoriteProperty";
$route['homeowner/potential-by'] = "owner_interface/potentialByProperty";
$route['homeowner/potential-by/from'] = "owner_interface/potentialByProperty";
$route['homeowner/potential-by/from/:num'] = "owner_interface/potentialByProperty";

$route['homeowner/profile'] = "owner_interface/profile";
$route['homeowner/set-password'] = "owner_interface/setPassword";

/*************************************************** ADMIN INTRERFACE ***********************************************/

$route['admin'] = "users_interface/login";
$route[ADM_START_PAGE] = "admin_interface/control_panel";
$route[ADM_START_PAGE.'/pages'] = "admin_interface/control_pages";
$route[ADM_START_PAGE.'/pages/:any'] = "admin_interface/control_pages";
$route['administrator/:any/accounts'] = "admin_interface/control_accounts";
$route['administrator/:any/accounts/from'] = "admin_interface/control_accounts";
$route['administrator/:any/accounts/from/:num'] = "admin_interface/control_accounts";

$route['administrator/control-panel/mails'] = "admin_interface/mailsText";
$route['administrator/control-panel/mails/edit/:num'] = "admin_interface/mailsTextEdit";
$route['administrator/account/:num'] = "admin_interface/account_profile";
$route['administrator/profile'] = "admin_interface/profile";
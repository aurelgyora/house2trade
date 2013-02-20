<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "users_interface";
$route['404_override'] = '';

/*************************************************** AJAX INTRERFACE ***********************************************/

$route['login-in']				= "ajax_interface/login";
$route['signup-account']		= "ajax_interface/signup_account";
$route['signup-properties']		= "ajax_interface/signup_properties";
$route['change-user-status']	= "ajax_interface/change_user_status";
$route['save-property-info']	= "ajax_interface/save_property_info";
$route['send-forgot-password']	= "ajax_interface/send_forgot_password";
$route['multi-upload']			= "ajax_interface/multiUpload";
$route['delete-property-images']= "ajax_interface/deletePropertyImages";
$route['save-profile']			= "ajax_interface/saveProfile";
$route['text-load/:any/from/:num']	= "ajax_interface/text_load";

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
$route[BROKER_START_PAGE.'/from'] 	= "owner_interface/properties";
$route[BROKER_START_PAGE.'/from/:num'] 	= "owner_interface/properties";
$route['broker/register-properties'] = "broker_interface/register_properties";
$route[BROKER_START_PAGE.'/edit/:num'] = "broker_interface/edit_property";
$route['broker/profile'] = "broker_interface/profile";

$route['broker/set-password'] = "broker_interface/setPassword";

/*************************************************** OWNERS INTRERFACE ***********************************************/

$route[OWNER_START_PAGE] = "owner_interface/properties";
$route[OWNER_START_PAGE.'/from'] = "owner_interface/properties";
$route[OWNER_START_PAGE.'/from/:num'] = "owner_interface/properties";
$route[OWNER_START_PAGE.'/edit/:num'] = "owner_interface/edit_property";
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

$route['administrator/account/:num'] = "admin_interface/account_profile";
$route['administrator/profile'] = "admin_interface/profile";
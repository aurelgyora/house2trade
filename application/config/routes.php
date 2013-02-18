<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "users_interface";
$route['404_override'] = '';

/*************************************************** AJAX INTRERFACE ***********************************************/

$route['login-in']				= "ajax_interface/login";
$route['signup-account']		= "ajax_interface/signup_account";
$route['signup-properties']		= "ajax_interface/signup_properties";
$route['change-user-status']	= "ajax_interface/change_user_status";
$route['save-profile']			= "ajax_interface/save_profile";
$route['send-forgot-password']	= "ajax_interface/send_forgot_password";
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
$route['logoff']			= "users_interface/logoff";
$route['comfirm-registering/:any/activation-code/:any'] = "users_interface/comfirm_registering";
$route['password-recovery/:any/temporary-code/:any'] = "users_interface/comfirm_temporary_code";

/*************************************************** BROKERS INTRERFACE ***********************************************/

$route['broker/control-panel'] = "broker_interface/control_panel";
$route['broker/accounts'] = "broker_interface/control_accounts";
$route['broker/register-properties'] = "broker_interface/register_properties";
$route['broker/accounts/profile/:num'] = "broker_interface/account_profile";
$route['broker/profile'] = "broker_interface/profile";

$route['broker/set-password'] = "broker_interface/setPassword";

/*************************************************** OWNERS INTRERFACE ***********************************************/

$route['homeowner/control-panel'] = "owner_interface/control_panel";
$route['homeowner/profile'] = "owner_interface/profile";
$route['homeowner/set-password'] = "owner_interface/setPassword";

/*************************************************** ADMIN INTRERFACE ***********************************************/

$route['admin'] = "users_interface/login";
$route['administrator/control-panel'] = "admin_interface/control_panel";
$route['administrator/control-panel/pages'] = "admin_interface/control_pages";
$route['administrator/control-panel/pages/:any'] = "admin_interface/control_pages";
$route['administrator/:any/accounts'] = "admin_interface/control_accounts";
$route['administrator/:any/accounts/from'] = "admin_interface/control_accounts";
$route['administrator/:any/accounts/from/:num'] = "admin_interface/control_accounts";

$route['administrator/account/:num'] = "admin_interface/account_profile";
$route['administrator/profile'] = "admin_interface/profile";
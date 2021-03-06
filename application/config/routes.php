<?php if(!defined('BASEPATH')) exit('No direct script access allowed');

$route['default_controller'] = "users_interface";
$route['404_override'] = '';

$route['set-db-data'] = 'users_interface/setDbData';
$route['clear-session'] = 'users_interface/clearSession';
$route['valid/exist-email'] = 'ajax_interface/existEmail';
$route['valid/property-exist'] = "ajax_interface/propertyExist";
/*************************************************** CRON INTRERFACE ***********************************************/
$route['csv-export-properties'] = "scripts_interface/csvExportProperties";
$route['remove-images-by-zipcode'] = "scripts_interface/removeImagesByZipcode";
$route['sending-email-about-new-match'] = "crontab_interface/sendingEmailAboutNewMatch";

/*************************************************** AJAX INTRERFACE ***********************************************/

$route['login-in'] = "ajax_interface/login";
$route['signup-account'] = "ajax_interface/signup_account";
$route['signup-property'] = "ajax_interface/signupProperty";
$route['seller-signup-properties'] = "ajax_interface/sellerSignupProperties";
$route['change-user-status'] = "ajax_interface/changeUserStatus";
$route['change-property-status'] = "ajax_interface/changePropertyStatus";
$route['change-down-payment-value'] = "ajax_interface/changeDownPaymentValue";
$route['change-match-statuses'] = "ajax_interface/changeMatchAndPropertyStatuses";

$route['save-main-property'] = "ajax_interface/saveMainProperty";
$route['save-disared-property'] = "ajax_interface/saveDisaredProperty";

$route['send-forgot-password'] = "ajax_interface/send_forgot_password";
$route['multi-upload'] = "ajax_interface/multiUpload";
$route['delete-property-images']= "ajax_interface/deletePropertyImages";
$route['save-profile'] = "ajax_interface/saveProfile";

$route['show-detail-property'] = "ajax_interface/showDetailProperty";
$route['set-active-property'] = "ajax_interface/setActiveProperty";
$route['show-properties-list'] = "ajax_interface/showPropertiesList";
$route['set-current-property'] = "ajax_interface/setCurrentProperty";

$route['text-load/:any/from/:num'] = "ajax_interface/text_load";
$route[BROKER_START_PAGE.'/delete'] = "ajax_interface/deleteProperty";
$route[OWNER_START_PAGE.'/delete/seller'] = "ajax_interface/deletePropertySeller";
$route['search-properties'] = "ajax_interface/searchProperty";
$route['add-to-favorite'] = "ajax_interface/addToFavorite";
$route['exclude-property'] = "ajax_interface/excludeProperty";
$route['remove-to-favorite'] = "ajax_interface/removeToFavorite";
$route['add-to-potential-by'] = "ajax_interface/addToPotentialBy";
$route['remove-to-potential-by'] = "ajax_interface/removeToPotentialBy";
$route['get-property-zillow-api'] = "ajax_interface/getPropertyZillowAPI";

$route['admin-search-properties'] = "ajax_interface/adminSearchProperty";

/*************************************************** USERS INTRERFACE ***********************************************/

$route['login'] = "users_interface/login";
$route['signup'] = "users_interface/signup";

$route['search'] = "users_interface/search";
$route['how-it-works'] = "users_interface/howItWorks";
$route['trading-concepts'] = "users_interface/tradingConcepts";
$route['about-us'] = "users_interface/aboutUs";
$route['contacts'] = "users_interface/contacts";
// ***************************************************************** footer
$route['search-for-one'] = "users_interface/searchForOne";
$route['advanced-search'] = "users_interface/advancedSearch";
$route['lastest-offers'] = "users_interface/lastestOffers";
$route['properties-for-sale'] = "users_interface/propertiesForSale";
$route['company'] = "users_interface/company";
$route['step-by-step'] = "users_interface/stepByStep";
$route['virtual-tour'] = "users_interface/virtualTour";

$route['password-recovery'] = "users_interface/pswdRecovery";
$route['logout'] = "users_interface/logout";
$route['confirm-registering/:any/activation-code/:any'] = "users_interface/confirm_registering";
$route['password-recovery/:any/temporary-code/:any'] = "users_interface/confirm_temporary_code";

/********** loading image *************/
$route['loadimage/:any/:num'] = "users_interface/loadimage";
/*************************************************** BROKERS INTRERFACE ***********************************************/

$route[BROKER_START_PAGE] = "broker_interface/properties";
$route[BROKER_START_PAGE.'/full-list(\/:any)*?'] = "broker_interface/propertiesFullList";

$route['broker/:any/information'] = "broker_interface/propertyDetail";
$route['broker/:any/information/:num'] = "broker_interface/propertyDetail";

$route['broker/register-properties'] = "broker_interface/register_properties";

$route[BROKER_START_PAGE.'/edit'] = "broker_interface/editProperty";
$route[BROKER_START_PAGE.'/edit/:num'] = "broker_interface/editProperty";

$route['broker/search'] = "broker_interface/searchProperty";
$route['broker/search/result(\/:any)*?'] = "broker_interface/searchProperty";
$route['broker/favorite(\/:any)*?'] = "broker_interface/favoriteProperty";
$route['broker/recommended(\/:any)*?'] = "broker_interface/recommendedProperty";
$route['broker/potential-by(\/:any)*?'] = "broker_interface/potentialByProperty";

$route['broker/profile'] = "broker_interface/profile";
$route['broker/set-password'] = "broker_interface/setPassword";

$route['broker/instant-trade'] = "broker_interface/instantTrade";
$route['broker/match'] = "broker_interface/match";

/*************************************************** OWNERS INTRERFACE ***********************************************/

$route['homeowner/search'] = "owner_interface/searchProperty";
$route['homeowner/search/result(\/:any)*?'] = "owner_interface/searchProperty";

$route[OWNER_START_PAGE] = "owner_interface/properties";

$route['homeowner/recommended(\/:any)*?'] = "owner_interface/recommendedProperty";

$route['homeowner/:any/information'] = "owner_interface/propertyDetail";
$route['homeowner/:any/information/:num'] = "owner_interface/propertyDetail";

$route[OWNER_START_PAGE.'/edit'] = "owner_interface/editProperty";
$route[OWNER_START_PAGE.'/edit/:num'] = "owner_interface/editProperty";

$route['homeowner/register-properties'] = "owner_interface/register_properties";

$route['homeowner/favorite(\/:any)*?'] = "owner_interface/favoriteProperty";
$route['homeowner/potential-by(\/:any)*?'] = "owner_interface/potentialByProperty";

$route['homeowner/instant-trade'] = "owner_interface/instantTrade";
$route['homeowner/match'] = "owner_interface/match";

$route['homeowner/profile'] = "owner_interface/profile";
$route['homeowner/set-password'] = "owner_interface/setPassword";

/*************************************************** ADMIN INTRERFACE ***********************************************/

$route[ADM_START_PAGE] = "admin_interface/control_panel";
$route[ADM_START_PAGE.'/pages'] = "admin_interface/control_pages";
$route[ADM_START_PAGE.'/pages/:any'] = "admin_interface/control_pages";

$route[ADM_START_PAGE.'/companies(\/:any)*?'] = "admin_interface/companies";
$route[ADM_START_PAGE.'/companies/insert'] = "admin_interface/insertCompany";
$route[ADM_START_PAGE.'/companies/edit/:num'] = "admin_interface/editCompany";
$route[ADM_START_PAGE.'/companies/delete/:num'] = "admin_interface/deleteCompany";

$route[ADM_START_PAGE.'/:any/accounts(\/:any)*?'] = "admin_interface/control_accounts";

$route[ADM_START_PAGE.'/properties/full-list'] = "admin_interface/propertiesSetFullList";
$route[ADM_START_PAGE.'/properties(\/:any)*?'] = "admin_interface/properties";
$route[ADM_START_PAGE.'/properties/information/:num'] = "admin_interface/propertyDetail";

$route[ADM_START_PAGE.'/control-panel/mails'] = "admin_interface/mailsText";
$route[ADM_START_PAGE.'/control-panel/mails/edit/:num'] = "admin_interface/mailsTextEdit";
$route[ADM_START_PAGE.'/account/:num'] = "admin_interface/account_profile";
$route[ADM_START_PAGE.'/profile'] = "admin_interface/profile";
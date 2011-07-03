<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------
| DATABASE CONNECTIVITY SETTINGS
| -------------------------------------------------------------------
| This file will contain the settings needed to access your database.
|
| For complete instructions please consult the "Database Connection"
| page of the User Guide.
|
| -------------------------------------------------------------------
| EXPLANATION OF VARIABLES
| -------------------------------------------------------------------
|
|	['hostname'] The hostname of your database server.
|	['username'] The username used to connect to the database
|	['password'] The password used to connect to the database
|	['database'] The name of the database you want to connect to
|	['dbdriver'] The database type. ie: mysql.  Currently supported:
				 mysql, mysqli, postgre, odbc, mssql, sqlite, oci8
|	['dbprefix'] You can add an optional prefix, which will be added
|				 to the table name when using the  Active Record class
|	['pconnect'] TRUE/FALSE - Whether to use a persistent connection
|	['db_debug'] TRUE/FALSE - Whether database errors should be displayed.
|	['cache_on'] TRUE/FALSE - Enables/disables query caching
|	['cachedir'] The path to the folder where cache files should be stored
|	['char_set'] The character set used in communicating with the database
|	['dbcollat'] The character collation used in communicating with the database
|
| The $active_group variable lets you choose which connection group to
| make active.  By default there is only one group (the "default" group).
|
| The $active_record variables lets you determine whether or not to load
| the active record class
*/

$active_group = 'local';
$active_record = TRUE;

$db['local']['hostname'] = "localhost";
$db['local']['username'] = 'root';
$db['local']['password'] = '';
$db['local']['database'] = 'exambuff';
$db['local']['dbdriver'] = "mysql";
$db['local']['dbprefix'] = "";
$db['local']['pconnect'] = FALSE;
$db['local']['db_debug'] = TRUE;
$db['local']['cache_on'] = FALSE;
$db['local']['cachedir'] = "";
$db['local']['char_set'] = "utf8";
$db['local']['dbcollat'] = "utf8_general_ci";

$db['testing']['hostname'] = "localhost";
$db['testing']['username'] = 'root';
$db['testing']['password'] = '';
$db['testing']['database'] = 'test';
$db['testing']['dbdriver'] = "mysql";
$db['testing']['dbprefix'] = "";
$db['testing']['pconnect'] = FALSE;
$db['testing']['db_debug'] = TRUE;
$db['testing']['cache_on'] = FALSE;
$db['testing']['cachedir'] = "";
$db['testing']['char_set'] = "utf8";
$db['testing']['dbcollat'] = "utf8_general_ci";



/* End of file database.php */
/* Location: ./system/application/config/database.php */

<?php

/**
 *
 * Constants
 *
 */
define('PATH_APP',dirname(__FILE__).'/../app');
define('PATH_ROOT',dirname(__FILE__));
define('PATH_PAGES',dirname(__FILE__).'/pages');
define('PATH_LAYOUTS',PATH_PAGES.'/_layout');
define('PATH_PLUGINS',PATH_APP.'/Gregory/plugins');
define('PATH_LIB',PATH_APP.'/lib');
define('PATH_MODELS',PATH_APP.'/models');

/**
 *
 * Incudes
 *
 */
require PATH_APP.'/Bob/Bob.php';
require PATH_APP.'/Gregory/Gregory.php';
require PATH_APP.'/Kate/Kate.php';

require PATH_APP.'/lib/functions.php';

/**
 *
 * Gregory
 *
 */
$config  = include PATH_APP.'/config.php';
$app = new Gregory($config);

/**
 *
 * PHP Config
 *
 */
date_default_timezone_set($app->getConfig('php.timezone'));
ini_set('magic_quotes_gpc',0);

/**
 *
 * Plugins
 *
 */
$app->addPlugin('db',$app->getConfig('db'));
$app->addPlugin('auth',$app->getConfig('auth'));
$app->addPlugin('mail',$app->getConfig('mail'));
$app->addPlugin('cache',$app->getConfig('cache'));
$app->addPlugin('resizer',$app->getConfig('resizer'),false);

/**
 *
 * Set cache for Kate
 *
 */
Kate::setCache($app->cache->getCache('kate'));

/**
 *
 * Routes
 *
 */
$routes  = include PATH_APP.'/routes.php';
$app->addRoute($routes);

/**
 *
 * Load Data
 *
 */
include PATH_APP.'/data.php';

/**
 *
 * Layout
 *
 */
$app->setLayout(PATH_LAYOUTS.'/layout.php');
$app->setData('title','Site web');
$app->setData('description','Description du site web');
$app->setData('fbappid',$app->getConfig('facebook.appId'));

/**
 *
 * General stylesheets and scripts
 *
 */

//Stylesheets
$app->addStylesheet('/statics/css/commons.css');
$app->addStylesheet('/statics/css/styles.css');



/**
 *
 * Run application
 *
 */
$app->bootstrap();
$app->run();
$app->render();
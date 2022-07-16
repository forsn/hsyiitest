<?php
$db_host='localhost';
$db_name="proposal";
$db_user="root";
$db_pass='';
Yii::setPathOfAlias('rootpath', ROOT_PATH);
return array(
    'name' => '管理系统',
    'defaultController' => 'index',
    'preload' => array(
        'log'
    ),
    'import' => array(
        'rootpath.models.*',
        'application.components.*',
    ),
    'modules' => array(
// uncomment the following to enable the Gii tool
        'gii' => array(
            'class' => 'system.gii.GiiModule',
            'password' => '',
            // If removed, Gii defaults to localhost only. Edit carefully to taste.
            'ipFilters' => array('127.0.0.1', '::1'),
        ),
    ),
  'components' => array(
        'db' => array(
            'class' => 'system.db.CDbConnection',
            'connectionString' => 'mysql:host='.$db_host.';port=3306;dbname='.$db_name,
            'emulatePrepare' => true,
            'username' => $db_user,
            'password' => $db_pass,
            'charset' => 'utf8',
            'tablePrefix' => '',
            ),
        'log' => array(
            'class' => 'CLogRouter',
            'routes' => array(
                array(
                    'class' => 'CFileLogRoute',
                    'levels' => 'info,error, warning'
                ),
                array(
                    'class' => 'CWebLogRoute',
                    'levels' => 'trace'
                ),
            ),
        ),
        'urlManager' => array(
            'urlFormat' => 'path',
            'showScriptName' => false,
        ),
        'theme' => 'classic',
    ),
    'language' => 'zh_cn',
    'params' => array(
        'uploadUrl' => 'http://127.0.0.1/fileUpload',

    ),
);

?>
<?php
# Created on 30 Now 2011
# @author: PL Young
#=======================================================================================================================

return array(

	// Look for CHANGE_ME below and make changes as needed
	
	'name'=>'Unity PHP sample app',						# CHANGE_ME if you care to	
	'params'=>array(									# Yii::app()->params['paramName']	
        'VERSION'=>         '000',                  	# server/client version of game
        'AUTHOR'=>          'dubreu_j',            		# CHANGE_ME if you care to
        'COMPANY'=>         'GladiaInc',       	# CHANGE_ME if you care to
        'EMAIL_REPLY'=>     'dubreu_j@epitech.eu',	# CHANGE_ME
        'URL'=>				'http://www.gameurl.com/', 	# CHANGE_ME if you care to
		'baseTimeZone'=>	'UTC'  
	),

	'basePath'=>dirname(__FILE__).DIRECTORY_SEPARATOR.'..',
	
	'defaultController'=>'main',
	
	// preloading 'log' component
	'preload'=>array('log'),
	
	// autoloading model and component classes
	'import'=>array(
		'application.models.*',
		'application.components.*',
	),

	'modules'=>array(),

	// application components
	'components'=>array(
	
		//'clientScript'=>array(
		//	'class' => 'CClientScript',
		//),
    
		'user'=>array(
			// enable cookie-based authentication
			'allowAutoLogin'=>true,
		),
		
		'urlManager'=>array(
			'urlFormat'=>'path',
			'showScriptName'=>false,
			//'rules'=>array(
			//	'<_a>'=>'main/<_a>',
			//),
		),
	
		'db'=>array(
			# CHANGE_ME Change these to what is needed to connect to your database
			'connectionString' => 'mysql:host=localhost;dbname=gladiawar',
			'username' => 'root',
			'password' => 'plout',
			'charset' => 'utf8',
			'emulatePrepare' => true,
		),
		
		'errorHandler'=>array(
			// use 'site/error' action to display errors
			'errorAction'=>'main/error',
		),
	
		'log'=>array(
			'class'=>'CLogRouter',
			'routes'=>array(
				array('class'=>'CFileLogRoute','levels'=>'error, warning',),		
				// uncomment the following to show log messages on web pages				
				//array( 'class'=>'CWebLogRoute', ),			
			),
		),
	),

);
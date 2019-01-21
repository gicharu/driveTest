<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
	'name' => 'Drive Test',
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
    	'urlManager' => [
    		'enablePrettyUrl' => true,
    		'showScriptName' => false,
    		'enableStrictParsing' => false,
    		'rules' => [
    			'<controller:[\w\-]+>/<id:\d+>' => '<controller>/view',
    			'<controller:[\w\-]+>/<action:[\w\-]+>/<id:\d+>' => '<controller>/<action>',
    			'<controller>/<action:[\w\-]+>/ajax/<ajax:\d+>/systemId/<systemId:\d+>' => '<controller>/<action>',
    			'<controller>/<action:[\w\-]+>/ajax/<ajax:\d+>' => '<controller>/<action>',
    			'<controller:[\w\-]+>/<action:[\w\-]+>' => '<controller>/<action>',
    			'<controller:[\w\-]+>/<action:\w+(-\w+)*>' => '<controller>/<action>',
    			
    			//				'debug/<module:\w+>/<controller:\w+>/<action:[\w\-]+>' => '<module>/<controller>/<action>',
    			'<module:\w+>/<controller:\w+>/<action:[\w\-]+>' => '<module>/<controller>/<action>',
    			'<module:\w+>/<controller:\w+>/<action:[\w\-]+>/<id:\d+>' => '<module>/<controller>/<action>',
    			'<controller:\w+>/<id:\d+>-<slug:[A-Za-z0-9 -_.]+>' => '<controller>/view>',
    			'' => ''
    		],
    	],
    ],
	'modules' => [
		'user' => [
			'class' => 'dektrium\user\Module',
			'enableUnconfirmedLogin' => true,
			'enableRegistration' => true,
			'enableConfirmation' => false,
			'enableFlashMessages' => false,
			'confirmWithin' => 21600,
			'cost' => 12,
			'admins' => ['admin'],
			'adminPermission' => 'ADMIN',
		],
		'gridview' =>  [
			'class' => '\kartik\grid\Module'
		]
	]
];

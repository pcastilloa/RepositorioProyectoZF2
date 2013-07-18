<?php
return array(
    'controllers' => array(
        'invokables' => array(
            'Cargo\Controller\Cargo' => 'Cargo\Controller\CargoController',
        ),
    ),
    
    'router' => array(
    		'routes' => array(
    				'cargo' => array(
    						'type'    => 'segment',
    						'options' => array(
    								'route'    => '/cargo[/][:action][/:id]',
    								'constraints' => array(
    										'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
    										'id'     => '[0-9]+',
    								),
    								'defaults' => array(
    										'controller' => 'Cargo\Controller\Cargo',
    										'action'     => 'index',
    								),
    						),
    				),
    		),
    ),
    
    'view_manager' => array(
        'template_path_stack' => array(
            'album' => __DIR__ . '/../view',
        ),
    ),
);
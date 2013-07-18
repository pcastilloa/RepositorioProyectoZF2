<?php
namespace Cargo;

use Cargo\Model\Cargo;
use Cargo\Model\CargoTable;
use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

class Module
{
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }

    public function getServiceConfig()
    {
    	return array(
    			'factories' => array(
    					'Cargo\Model\CargoTable' =>  function($sm) {
    						$tableGateway = $sm->get('CargoTableGateway');
    						$table = new CargoTable($tableGateway);
    						return $table;
    					},
    					'CargoTableGateway' => function ($sm) {
    						$dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
    						$resultSetPrototype = new ResultSet();
    						$resultSetPrototype->setArrayObjectPrototype(new Cargo());
    						return new TableGateway('cargo', $dbAdapter, null, $resultSetPrototype);
    					},
    			),
    	);
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

}
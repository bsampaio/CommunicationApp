<?php
/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2015 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */

namespace Users;

use Zend\Mvc\ModuleRouteListener;
use Zend\Mvc\MvcEvent;

use Users\Model\User;
use Users\Model\UserTable;

use Users\Form\LoginFilter;
use Users\Form\LoginForm;

use Users\Form\RegisterFilter;
use Users\Form\RegisterForm;

use Users\Form\UserEditFilter;
use Users\Form\UserEditForm;

use Zend\Db\ResultSet\ResultSet;
use Zend\Db\TableGateway\TableGateway;

use Zend\Authentication\Adapter\DbTable as DbTableAuthAdapter;
use Zend\Authentication\AuthenticationService;

class Module {
    public function onBootstrap(MvcEvent $e) {
        $eventManager        = $e->getApplication()->getEventManager();
        $moduleRouteListener = new ModuleRouteListener();
        $moduleRouteListener->attach($eventManager);
    }

    public function getConfig() {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig() {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
    
    public function getServiceConfig() {
        return [
            'abstract_factories' => [],
            'aliases'            => [],
            'factories'          => [
                
                //Database
                'UserTable'         => function ($sm) {
                    $tableGateway = $sm->get('UserTableGateway');
                    $table = new UserTable($tableGateway);
                    return $table;
                },
                'UserTableGateway'  => function ($sm) {
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    $resultSetPrototype = new ResultSet();
                    $resultSetPrototype->setArrayObjectPrototype(new User());
                    return new TableGateway('user', $dbAdapter, null, $resultSetPrototype);
                },
                
                //Forms
                'LoginForm'         => function ($sm) {
                    $form = new LoginForm();
                    $form->setInputFilter($sm->get('LoginFilter'));
                    return $form;
                },
                'RegisterForm'      => function ($sm) {
                    $form = new RegisterForm();
                    $form->setInputFilter($sm->get('RegisterFilter'));
                    return $form;
                },
                'UserEditForm'      => function ($sm) {
                    $form = new UserEditForm();
                    $form->setInputFilter($sm->get('UserEditFilter'));
                    return $form;
                },
                        
                //Filters
                'LoginFilter'       => function ($sm) {
                    return new LoginFilter();
                },
                'RegisterFilter'    => function ($sm) {
                    return new RegisterFilter();
                },
                'UserEditFilter'    => function ($sm) {
                    return new UserEditFilter();
                },
                        
                //Auth
                'AuthService'       => function($sm) {
                    $authService = new AuthenticationService();
                    $authService->setAdapter($sm->get('TableAuthAdapter'));
                    
                    return $authService;
                },
                'TableAuthAdapter'  => function($sm){
                    $dbAdapter = $sm->get('Zend\Db\Adapter\Adapter');
                    return new DbTableAuthAdapter($dbAdapter, 'user', 'email', 'password', 'MD5(?)');
                }
            ],
            'invokables'        => [],
            'services'          => [],
            'shared'            => []
        ];
    }
}

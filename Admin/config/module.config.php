<?php

namespace Admin;

/**
 * Zend Framework (http://framework.zend.com/)
 *
 * @link      http://github.com/zendframework/ZendSkeletonApplication for the canonical source repository
 * @copyright Copyright (c) 2005-2013 Zend Technologies USA Inc. (http://www.zend.com)
 * @license   http://framework.zend.com/license/new-bsd New BSD License
 */
return array(
    'controllers' => array(
        'invokables' => array(
            'Admin\Controller\Admin' => 'Admin\Controller\AdminController',
            'Admin\Controller\Portfolio' => 'Admin\Controller\PortfolioController',
            'Admin\Controller\Category' => 'Admin\Controller\CategoryController',
            'Admin\Controller\Activity' => 'Admin\Controller\ActivityController',
            'Admin\Controller\User' => 'Admin\Controller\UserController',
            'Admin\Controller\Photomanagement' => 'Admin\Controller\PhotomanagementController',
            'Admin\Controller\Interest' => 'Admin\Controller\InterestController',
            'Admin\Controller\Contentmanagement' => 'Admin\Controller\ContentmanagementController',
            'Admin\Controller\Labor' => 'Admin\Controller\LaborController',
            'Admin\Controller\Reviewlabor' => 'Admin\Controller\ReviewlaborController',
            'Admin\Controller\Promocodes' => 'Admin\Controller\PromocodesController',
            'Admin\Controller\Reports' => 'Admin\Controller\ReportsController',
            'Admin\Controller\Charity' => 'Admin\Controller\CharityController',
            'Admin\Controller\Systemholding' => 'Admin\Controller\SystemholdingController',
            'Admin\Controller\Systemdonation' => 'Admin\Controller\SystemdonationController',
            'Admin\Controller\Donationreport' => 'Admin\Controller\DonationreportController',
            'Admin\Controller\Donationsummary' => 'Admin\Controller\DonationsummaryController',
            'Admin\Controller\Salereport' => 'Admin\Controller\SalereportController',
            'Admin\Controller\Salesummary' => 'Admin\Controller\SalesummaryController',
            'Admin\Controller\Usermanagement' => 'Admin\Controller\UsermanagementController',
            'Admin\Controller\Managevideos' => 'Admin\Controller\ManagevideosController',
            'Admin\Controller\Products' => 'Admin\Controller\ProductsController',
        ),
    ),
    // The following section is new and should be added to your file
    'router' => array(
        'routes' => array(
            'admin' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/admin[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Admin',
                        'action' => 'index',
                    ),
                ),
            ),
            'portfolio' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/portfolio[/][:action][/:id][/:name]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'name' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'page' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Portfolio',
                        'action' => 'index',
                    ),
                ),
            ),
            'systemdonation' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/systemdonation[/][:action][/:id][/:name]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'name' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'page' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Systemdonation',
                        'action' => 'index',
                    ),
                ),
            ),
            'systemholding' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/systemholding[/][:action][/:id][/:name]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'name' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'page' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Systemholding',
                        'action' => 'index',
                    ),
                ),
            ),
            'donationreport' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/donationreport[/][:action][/:id][/:name]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'name' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'page' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Donationreport',
                        'action' => 'index',
                    ),
                ),
            ),
            'donationsummary' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/donationsummary[/][:action][/:id][/:name]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'name' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'page' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Donationsummary',
                        'action' => 'index',
                    ),
                ),
            ),
            'charity' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/charity[/][:action][/:id][/:name]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'name' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'page' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Charity',
                        'action' => 'index',
                    ),
                ),
            ),
            'activity' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/activity[/][:action][/:id][/:page]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'page' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Activity',
                        'action' => 'index',
                    ),
                ),
            ),
            'interest' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/interest[/][:action][/:id][/:page]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'page' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Interest',
                        'action' => 'index',
                    ),
                ),
            ),
            'labor' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/labor[/][:action][/:id][/:page]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'page' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Labor',
                        'action' => 'index',
                    ),
                ),
            ),
            'reviewlabor' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/reviewlabor[/][:action][:id][:page]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'page' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Reviewlabor',
                        'action' => 'index',
                    ),
                ),
            ),
            'promocodes' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/promocodes[/][:action][/:id][/:page]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'page' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Promocodes',
                        'action' => 'index',
                    ),
                ),
            ),
            'category' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/category[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Category',
                        'action' => 'index',
                    ),
                ),
            ),
            'user' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/user[/][:action][/:id]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\User',
                        'action' => 'index',
                    ),
                ),
            ),
            'photomanagement' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/photomanagement[/][:action][/:id][/:page]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'page' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Photomanagement',
                        'action' => 'index',
                    ),
                ),
            ),
            'managevideos' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/managevideos[/][:action][/:id][/:page]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'page' => '[a-zA-Z][a-zA-Z0-9_-]*',
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Managevideos',
                        'action' => 'index'
                    )
                )
            ),
            'contentmanagement' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/contentmanagement[/][:action][/:id][/:page]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'page' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Contentmanagement',
                        'action' => 'index'
                    )
                )
            ),
            'reports' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/reports[/][:action][/:id][/:page]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'page' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Reports',
                        'action' => 'index'
                    )
                )
            ),
            'salereport' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/salereport[/][:action][/:id][/:page]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'page' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Salereport',
                        'action' => 'index'
                    )
                )
            ),
            'salesummary' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/salesummary[/][:action][/:id][/:page]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'page' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Salesummary',
                        'action' => 'index'
                    )
                )
            ),
            'usermanagement' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/usermanagement[/][:action][/:id][/:page]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'page' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Usermanagement',
                        'action' => 'index'
                    )
                )
            ),
            
            'products' => array(
                'type' => 'segment',
                'options' => array(
                    'route' => '/products[/][:action][/:id][/:page]',
                    'constraints' => array(
                        'action' => '[a-zA-Z][a-zA-Z0-9_-]*',
                        'id' => '[0-9]+',
                        'page' => '[a-zA-Z][a-zA-Z0-9_-]*'
                    ),
                    'defaults' => array(
                        'controller' => 'Admin\Controller\Products',
                        'action' => 'index'
                    )
                )
            )
        )
    ),
    'view_manager' => array(
        'template_map' => array(
            'layout/layout' => __DIR__ . '/../view/layout/layout.phtml',
            'layout/ajax' => __DIR__ . '/../view/layout/ajax.phtml',
            'layout/adminlayout' => __DIR__ . '/../view/layout/adminlayout.phtml'
        ),
        'template_path_stack' => array(
            'admin' => __DIR__ . '/../view'
        )
    ),
    'controller_plugins' => array(
        'invokables' => array(
            'AdminPlugin' => 'Admin\Controller\Plugin\AdminPlugin'
        )
    ),
    'doctrine' => array(
        'driver' => array(
            __NAMESPACE__ . '_driver' => array(
                'class' => 'Doctrine\ORM\Mapping\Driver\AnnotationDriver',
                'cache' => 'array',
                'paths' => array(__DIR__ . '/../src/' . __NAMESPACE__ . '/Entity')
            ),
            'orm_default' => array(
                'drivers' => array(
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver'
                )
            )
        ),
        'authentication' => array(
            'orm_admin' => array(
                'object_manager' => 'Doctrine\ORM\EntityManager',
                'identity_class' => 'Admin\Entity\AdminLogin',
                'identity_property' => 'user_name',
                'credential_property' => 'password'
            )
        )
    )
);

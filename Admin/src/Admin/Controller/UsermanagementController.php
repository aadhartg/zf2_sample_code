<?php

/*
 * 
 * ******************************************************************************
 * Dating Family is a social networking and dating application developed by
 * Dating Family, Inc. Copyright (C) 2013 Dating Family Inc.
 *
 * You can contact Dating Family, Inc. with a mailing address at Riverside
 * California, CA 92504. or at email address contact@datingfamily.com.
 *
 * The interactive user interfaces in original and modified versions
 * of this program must display Appropriate Legal Notices, as required under
 * Section 5 of the GNU Affero General Public License version 3.
 *
 * In accordance with Section 7(b) of the GNU Affero General Public License version 3,
 * these Appropriate Legal Notices must retain the display of the Dating Family
 * logo and Dating Family copyright notice. If the display of the logo is not reasonably
 * feasible for technical reasons, the Appropriate Legal Notices must display the words
 * "Copyright Dating Family Inc. 2014. All rights reserved".
 * 
 * *****************************************************************************
 */

/**
 * Contains Reports for admin management.
 *
 * This includes Reports Management.
 */

namespace Admin\Controller;

use Zend\Mvc\Controller\ActionController;
use Zend\Mvc\Controller\AbstractActionController;
use DoctrineORMModule\Paginator\Adapter\DoctrinePaginator as PaginatorAdapter;
use Doctrine\ORM\Tools\Pagination\Paginator as ORMPaginator;
use Zend\Paginator\Paginator as ZendPaginator;
use Zend\View\Model\ViewModel;
use Admin\Form\PromoCodeForm;
use Admin\Form\SpinBottlePrizeForm;
use Admin\Form\SearchPromoForm;
use Admin\Form\SearchReportForm;
use Admin\Form\SearchUserForm;
use Doctrine\ORM\EntityManager;
use Admin\Entity\InterestActionPanel;
use Zend\View\Renderer\PhpRenderer;
use Admin\Entity\ActivitiesOptions;
use Admin\Entity\PlacesData;
use Zend\Session\Container;
use Doctrine\Common\Collections\ArrayCollection;
use DoctrineModule\Paginator\Adapter\Collection as Adapter;
use Zend\EventManager\EventManagerInterface;
use Admin\Form\SaleForm;
use Admin\Form\AdminReportForm;
use Admin\Controller\Plugin\AdminPlugin;

class UsermanagementController extends AbstractActionController {

    /**
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * @var Admin\Entity\Application
     */
    protected $applicationManager;

    /**
     * Prevents from accessing inner pages without login
     */
    public function setEventManager(EventManagerInterface $events) {
        parent::setEventManager($events);

        $controller = $this;
        $events->attach('dispatch', function ($e) use ($controller) {
            if (isset($_SESSION['Zend_Auth']->storage['admin_id'])) {
                $authService = $controller->getServiceLocator()->get('AuthenticationService');

                if ($authService->hasIdentity()) {
                    $auth = $authService->getIdentity();
                } else {
                    return $controller->redirect()->toRoute('adminlogin', array(
                                'action' => 'index'
                    ));
                }
            } else {
                return $controller->redirect()->toRoute('adminlogin', array(
                            'action' => 'index'
                ));
            }
        }, 100); // execute before executing action logic

        return $this;
    }

    /**
     * Set EntityManager for each entity used in the controller.
     * Get EntityManager for each entity used in current class.
     */
    public function setEntityManager(EntityManager $em) {
        $this->em = $em;
    }

    public function getEntityManager() {
        if (null === $this->em) {
            $this->em = $this->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }

    /**
     * Get all the sites
     */
    public function getSites() {
        $sites = array();
        $site_data = $this->getEntityManager()->getRepository('Admin\Entity\Application')->findAll();
        $sites [''] = 'Please Select';
        $sites ['0'] = 'All';
        if (!empty($site_data)) {
            foreach ($site_data as $site) {
                $sites[$site->application_id] = $site->application;
            }
        }

        return $sites;
    }

    /**
     * Get all the sites
     */
    public function getReportType() {
        $report = array();
        $report_type = $this->getEntityManager()->getRepository('Admin\Entity\ReportType')->findAll();
        $report [''] = 'Please Select';
        $report ['0'] = 'All';
        if (!empty($report_type)) {
            foreach ($report_type as $data) {
                $report[$data->id] = $data->type;
            }
        }

        return $report;
    }

    public function getAboutMeDataAction($user_id) {
        $this->layout('layout/ajax');
        $aboutme_data = $this->getEntityManager()->getRepository('Admin\Entity\AboutMe')->findBy(array('login_id' => $user_id));

        return '$aboutme_data';
    }

    /**
     * show all promocodes list, add promocodes, show all activities
     */
    public function indexAction() {

        $this->layout('layout/adminlayout');

        $q = $this->getEntityManager()->createQueryBuilder();
        $q->select(array('l.login_id', 'l.username', 'u.first_name', 'u.last_name', 'u.country', 'u.gender', 'c.country as countryname', 's.state as statename', 'ct.city as city_name', 'us.created', 'u.user_block_status'))
                ->from('User\Entity\LoginDetails', 'l')
                ->leftJoin('User\Entity\UserDetails', 'u', 'WITH', 'u.login_id= l.login_id')
                ->leftJoin('User\Entity\UserSiteInfo', 'us', 'WITH', 'l.login_id= us.user_id')
                ->leftJoin('User\Entity\Country', 'c', 'WITH', 'u.country= c.country_id')
                ->leftJoin('User\Entity\City', 'ct', 'WITH', 'u.city= ct.city_id')
                ->leftJoin('User\Entity\State', 's', 'WITH', 'u.state= s.state_id')
                ->where('u.user_block_status != 2')
                ->groupBy('l.login_id')
                ->orderBy('l.login_id', 'DESC')
                ->addOrderBy('us.created', 'ASC');
        $allusers = $q->getQuery()->getResult();

        $page = count($allusers);

        $paginator = new \Zend\Paginator\Paginator(new
                \Zend\Paginator\Adapter\ArrayAdapter($allusers)
               ); 

        if (isset($data['pg_id'])) {
            $paginator->setCurrentPageNumber($data['pg_id']);
        } else {
            $paginator->setCurrentPageNumber(1);
        }

        $paginator->setDefaultItemCountPerPage(20); 

        /* -----search form -------- */

        $search_form = new SearchUserForm();
        /* -------end search form------- */

        return new ViewModel(array(
            'allusers' => $allusers,
            'search_form' => $search_form,
            'page' => $page,
            'paginator' => $paginator,
        ));
    }

    /**
     * Ajax get promocodes list based on search.
     */
    public function deleteuserAction() {
        $this->layout('layout/ajax');


        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            $login_id = $data['login_id'];
            $userdetail = $this->getEntityManager()->getRepository('User\Entity\UserDetailsrelation')->findOneBy(array('login_id' => $login_id));
            $userdetail->__set('user_block_status', 2);
            $this->getEntityManager()->persist($userdetail);
            $this->getEntityManager()->flush();

            $q = $this->getEntityManager()->createQueryBuilder();
            $q->select(array('l.login_id', 'l.username', 'u.first_name', 'u.last_name', 'u.country', 'u.gender', 'c.country as countryname', 's.state as statename', 'ct.city as city_name', 'us.created', 'u.user_block_status'))
                    ->from('User\Entity\LoginDetails', 'l')
                    ->leftJoin('User\Entity\UserDetails', 'u', 'WITH', 'u.login_id= l.login_id')
                    ->leftJoin('User\Entity\UserSiteInfo', 'us', 'WITH', 'l.login_id= us.user_id')
                    ->leftJoin('User\Entity\Country', 'c', 'WITH', 'u.country= c.country_id')
                    ->leftJoin('User\Entity\City', 'ct', 'WITH', 'u.city= ct.city_id')
                    ->leftJoin('User\Entity\State', 's', 'WITH', 'u.state= s.state_id')
                    ->where('u.user_block_status != 2')
                    ->groupBy('l.login_id')
                    ->orderBy('l.login_id', 'DESC')
                    ->addOrderBy('us.created', 'ASC');
            $allusers = $q->getQuery()->getResult();
            $page = count($allusers);
            $paginator = new \Zend\Paginator\Paginator(new
                \Zend\Paginator\Adapter\ArrayAdapter($allusers)
               ); 


            if (isset($data['pg_id'])) {
                $paginator->setCurrentPageNumber($data['pg_id']);
            } else {
                $paginator->setCurrentPageNumber(1);
            }

            $paginator->setDefaultItemCountPerPage(20); 
        }

        $result = new ViewModel(array(
            'allusers' => $allusers,
             'paginator' => $paginator,
        ));
        $result->setTerminal(true);
        return $result;
    }

    /**
     * Ajax get promocodes list based on search.
     */
    public function blockuserAction() {
        $this->layout('layout/ajax');


        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            $login_id = $data['login_id'];
            $userdetail = $this->getEntityManager()->getRepository('User\Entity\UserDetailsrelation')->findOneBy(array('login_id' => $login_id));
            $userdetail->__set('user_block_status', 1);
            $this->getEntityManager()->persist($userdetail);
            $this->getEntityManager()->flush();

            $q = $this->getEntityManager()->createQueryBuilder();
            $q->select(array('l.login_id', 'l.username', 'u.first_name', 'u.last_name', 'u.country', 'u.gender', 'c.country as countryname', 's.state as statename', 'ct.city as city_name', 'us.created', 'u.user_block_status'))
                    ->from('User\Entity\LoginDetails', 'l')
                    ->leftJoin('User\Entity\UserDetails', 'u', 'WITH', 'u.login_id= l.login_id')
                    ->leftJoin('User\Entity\UserSiteInfo', 'us', 'WITH', 'l.login_id= us.user_id')
                    ->leftJoin('User\Entity\Country', 'c', 'WITH', 'u.country= c.country_id')
                    ->leftJoin('User\Entity\City', 'ct', 'WITH', 'u.city= ct.city_id')
                    ->leftJoin('User\Entity\State', 's', 'WITH', 'u.state= s.state_id')
                    ->where('u.user_block_status != 2')
                    ->groupBy('l.login_id')
                    ->orderBy('l.login_id', 'DESC')
                    ->addOrderBy('us.created', 'ASC');
            $allusers = $q->getQuery()->getResult();
            
            $page = count($allusers);

            $paginator = new \Zend\Paginator\Paginator(new
                \Zend\Paginator\Adapter\ArrayAdapter($allusers)
               ); 



            if (isset($data['pg_id'])) {
                $paginator->setCurrentPageNumber($data['pg_id']);
            } else {
                $paginator->setCurrentPageNumber(1);
            }

            $paginator->setDefaultItemCountPerPage(20);
        }

        $result = new ViewModel(array(
            'allusers' => $allusers,
            'paginator' => $paginator,
        ));
        $result->setTerminal(true);
        return $result;
    }

    /**
     * Ajax get promocodes list based on search.
     */
    public function unblockuserAction() {
        $this->layout('layout/ajax');


        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            $login_id = $data['login_id'];
            $userdetail = $this->getEntityManager()->getRepository('User\Entity\UserDetailsrelation')->findOneBy(array('login_id' => $login_id));
            $userdetail->__set('user_block_status', 0);
            $this->getEntityManager()->persist($userdetail);
            $this->getEntityManager()->flush();

            $q = $this->getEntityManager()->createQueryBuilder();
            $q->select(array('l.login_id', 'l.username', 'u.first_name', 'u.last_name', 'u.country', 'u.gender', 'c.country as countryname', 's.state as statename', 'ct.city as city_name', 'us.created', 'u.user_block_status'))
                    ->from('User\Entity\LoginDetails', 'l')
                    ->leftJoin('User\Entity\UserDetails', 'u', 'WITH', 'u.login_id= l.login_id')
                    ->leftJoin('User\Entity\UserSiteInfo', 'us', 'WITH', 'l.login_id= us.user_id')
                    ->leftJoin('User\Entity\Country', 'c', 'WITH', 'u.country= c.country_id')
                    ->leftJoin('User\Entity\City', 'ct', 'WITH', 'u.city= ct.city_id')
                    ->leftJoin('User\Entity\State', 's', 'WITH', 'u.state= s.state_id')
                    ->where('u.user_block_status != 2')
                    ->groupBy('l.login_id')
                    ->orderBy('l.login_id', 'DESC')
                    ->addOrderBy('us.created', 'ASC');
            $allusers = $q->getQuery()->getResult();
            $page = count($allusers);

            $paginator = new \Zend\Paginator\Paginator(new
                \Zend\Paginator\Adapter\ArrayAdapter($allusers)
               ); 



            if (isset($data['pg_id'])) {
                $paginator->setCurrentPageNumber($data['pg_id']);
            } else {
                $paginator->setCurrentPageNumber(1);
            }

            $paginator->setDefaultItemCountPerPage(20);
        }

        $result = new ViewModel(array(
            'allusers' => $allusers,
            'paginator' => $paginator,
        ));
        $result->setTerminal(true);
        return $result;
    }

    /**
     * Action to show reports from the user to the admin 
     * 
     */
    public function adminAction() {

        $this->layout('layout/adminlayout');

        $report_manager_data = $this->getEntityManager()->getRepository('Admin\Entity\ReportManager')->findAll();

        /* -----search form -------- */

        $search_form = new AdminReportForm();
        $search_form->get('siteId')->setValueOptions($this->getSites());
        $search_form->get('report')->setValueOptions($this->getReportType());
        /* -------end search form------- */
        return new ViewModel(array(
            'report_manager_data' => $report_manager_data,
            'search_form' => $search_form,
        ));
    }

    /**
     * Ajax get search promo codes.
     */
    public function reportlistAction() {
        $this->layout('layout/ajax');


        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            $current_date = date('Y-m-d');
            $dq = $this->getEntityManager()->createQueryBuilder();
            $dq->select(array('l.login_id', 'l.username', 'u.first_name', 'u.last_name', 'u.country', 'u.gender', 'c.country as countryname', 's.state as statename', 'ct.city as city_name', 'us.created', 'u.user_block_status'))
                    ->from('User\Entity\LoginDetails', 'l')
                    ->leftJoin('User\Entity\UserDetails', 'u', 'WITH', 'u.login_id= l.login_id')
                    ->leftJoin('User\Entity\UserSiteInfo', 'us', 'WITH', 'l.login_id= us.user_id')
                    ->leftJoin('User\Entity\Country', 'c', 'WITH', 'u.country= c.country_id')
                    ->leftJoin('User\Entity\City', 'ct', 'WITH', 'u.city= ct.city_id')
                    ->leftJoin('User\Entity\State', 's', 'WITH', 'u.state= s.state_id')
                    ->where('u.user_block_status != 2');

            if (empty($data->today_report) && !empty($data->from_date) && !empty($data->to_date)) {

                $dq = $dq->andWhere('us.created BETWEEN :monday AND :sunday')
                        ->setParameter('monday', $data->from_date)
                        ->setParameter('sunday', $data->to_date);
            } else if (!empty($data->today_report) && empty($data->from_date) && empty($data->to_date)) {

                if ($data->today_report == 'today') {
                    $dq = $dq->andWhere($dq->expr()->gte('us.created', 'CURRENT_DATE()'));
                } else if ($data->today_report == 'WTD') {
                    $current_dayname = date("l");

                    $weeks_first_day = date("Y-m-d", strtotime('monday this week'));

                    $dq->andWhere('us.created BETWEEN :monday AND :sunday')
                            ->setParameter('monday', $weeks_first_day)
                            ->setParameter('sunday', $current_date);
                } else if ($data->today_report == 'MTD') {
                    $month_first_date = date("Y-m-01");

                    $dq->andWhere('us.created BETWEEN :monday AND :sunday')
                            ->setParameter('monday', $month_first_date)
                            ->setParameter('sunday', $current_date);
                } else if ($data->today_report == 'YTD') {
                    $year_first_date = date("Y-01-01");

                    $dq->andWhere('us.created BETWEEN :monday AND :sunday')
                            ->setParameter('monday', $year_first_date)
                            ->setParameter('sunday', $current_date);
                } else {
                    
                }
            } else {
                
            }

            $dq = $dq->groupBy('l.login_id')
                    ->orderBy('l.login_id', 'DESC')
                    ->addOrderBy('us.created', 'ASC');


            $allusers = $dq->getQuery()->getResult();
            
            $page = count($allusers);

            $paginator = new \Zend\Paginator\Paginator(new
                \Zend\Paginator\Adapter\ArrayAdapter($allusers)
               ); 

            if (isset($data['pg_id'])) {
                $paginator->setCurrentPageNumber($data['pg_id']);
            } else {
                $paginator->setCurrentPageNumber(1);
            }

            $paginator->setDefaultItemCountPerPage(20); 
            }

            $result = new ViewModel(array(
                'allusers' => $allusers,
                'paginator'=> $paginator,
            ));
            $result->setTerminal(true);
            return $result;
       }

    /**
     * Ajax get promocodes list based on search.
     */
    public function sortedreportlistAction() {
        $this->layout('layout/ajax');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();

            $dq = $this->getEntityManager()->createQueryBuilder();
            $dq->select(array('l.login_id', 'l.username', 'u.first_name', 'u.last_name', 'u.country', 'u.gender', 'c.country as countryname', 's.state as statename', 'ct.city as city_name', 'us.created', 'u.user_block_status'))
                    ->from('User\Entity\LoginDetails', 'l')
                    ->leftJoin('User\Entity\UserDetails', 'u', 'WITH', 'u.login_id= l.login_id')
                    ->leftJoin('User\Entity\UserSiteInfo', 'us', 'WITH', 'l.login_id= us.user_id')
                    ->leftJoin('User\Entity\Country', 'c', 'WITH', 'u.country= c.country_id')
                    ->leftJoin('User\Entity\City', 'ct', 'WITH', 'u.city= ct.city_id')
                    ->leftJoin('User\Entity\State', 's', 'WITH', 'u.state= s.state_id')
                    ->where('u.user_block_status != 2');
            if (!empty($data->user_by)) {
                if ($data->user_by == 'blocked') {
                    $dq = $dq->andWhere('u.user_block_status = 1');
                }
                if ($data->user_by == 'unblocked') {
                    $dq = $dq->andWhere('u.user_block_status = 0');
                }
            }
            if (!empty($data->location)) {
                if ($data->location == 'state') {
                    $dq = $dq->orderBy('s.state', 'DESC');
                }
                if ($data->location == 'city') {
                    $dq = $dq->orderBy('ct.city', 'DESC');
                }
                if ($data->location == 'country') {
                    $dq = $dq->orderBy('c.country', 'DESC');
                }
            }
            if (!empty($data->sort_by)) {
                if ($data->sort_by == 'newest') {
                    $dq = $dq->addOrderBy('l.login_id', 'DESC');
                }
                if ($data->sort_by == 'oldest') {
                    $dq = $dq->addOrderBy('l.login_id', 'ASC');
                }
            }
            if ($data->user_by == '' && $data->location == '' && $data->sort_by == '') {
                $dq = $dq->orderBy('l.login_id', 'DESC')
                        ->addOrderBy('us.created', 'ASC');
            }
            $dq = $dq->groupBy('l.login_id');

            $allusers = $dq->getQuery()->getResult();
            
            $page = count($allusers);

            $paginator = new \Zend\Paginator\Paginator(new
                \Zend\Paginator\Adapter\ArrayAdapter($allusers)
               ); 



        if (isset($data['pg_id'])) {
            $paginator->setCurrentPageNumber($data['pg_id']);
        } else {
            $paginator->setCurrentPageNumber(1);
        }

        $paginator->setDefaultItemCountPerPage(20); 
        
        }

        $result = new ViewModel(array(
            'allusers' => $allusers,
             'paginator'=>$paginator,
        ));
        $result->setTerminal(true);
        return $result;
    }

    /**
     * Ajax get promocodes list based on search.
     */
    public function getsortedreportsAction() {
        $this->layout('layout/ajax');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();

            $dq = $this->getEntityManager()->createQueryBuilder();
            $dq->select('main', 'rt', 'ars')->from('Admin\Entity\ReportManager', 'main')
                    ->LeftJoin('Admin\Entity\ReportType', 'rt', \Doctrine\ORM\Query\Expr\Join::WITH, 'main.reportTypeId=rt.id')
                    ->LeftJoin('Admin\Entity\ActivityReportStatus', 'ars', \Doctrine\ORM\Query\Expr\Join::WITH, 'main.status=ars.id');

            if (!empty($data->site_id) && $data->site_id != 0) {
                $dq = $dq->andWhere('main.siteId =' . $data->site_id);
            }

            if ($data->report != 0 && $data->report != '') {

                $dq = $dq->andWhere('main.reportTypeId =' . $data->report);
            }

            if (!empty($data->status)) {

                $dq = $dq->andWhere('main.status =' . $data->status);
            }

            if (!empty($data->sort_second) && $data->sort_second != 0) {
                $dq = $dq->andWhere('main.type =' . $data->sort_second);
            }

            if (!empty($data->sort_first)) {
                if ($data->sort_first == '1') {
                    $dq = $dq->orderBy('main.reporTDate', 'DESC');
                } else if ($data->sort_first == '2') {
                    $dq = $dq->orderBy('main.reporTDate', 'ASC');
                } else if ($data->sort_first == '3') {
                    $dq = $dq->orderBy('main.reportByUserId', 'DESC');
                } else if ($data->sort_first == '4') {
                    $dq = $dq->orderBy('main.type', 'DESC');
                } else if ($data->sort_first == '5') {
                    $dq = $dq->orderBy('main.id', 'DESC');
                } else if ($data->sort_first == '6') {
                    $dq = $dq->orderBy('main.name', 'DESC');
                } else {
                    $dq = $dq->orderBy('main.contentPhotoId', 'DESC');
                }
            }

            if (!empty($data->sort_third)) {

                $dq = $dq->orderBy('main.reportByUserId', 'ASC');
            }

            $report_manager_data = $dq->getQuery()->getScalarResult();
        }

        $result = new ViewModel(array(
            'report_manager_data' => $report_manager_data,
        ));
        $result->setTerminal(true);
        return $result;
    }

    /**
     * Ajax get search promo codes.
     */
    public function datesortreportlistAction() {
        $this->layout('layout/ajax');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            $current_date = date('Y-m-d');
            $dq = $this->getEntityManager()->createQueryBuilder();
            $dq->select('main', 'rt', 'ars')->from('Admin\Entity\ReportManager', 'main')
                    ->LeftJoin('Admin\Entity\ReportType', 'rt', \Doctrine\ORM\Query\Expr\Join::WITH, 'main.reportTypeId=rt.id')
                    ->LeftJoin('Admin\Entity\ActivityReportStatus', 'ars', \Doctrine\ORM\Query\Expr\Join::WITH, 'main.status=ars.id');


            if (!empty($data->from_date) && !empty($data->to_date)) {

                $dq = $dq->Where('main.reporTDate BETWEEN :monday AND :sunday')
                        ->setParameter('monday', $data->from_date)
                        ->setParameter('sunday', $data->to_date);
            }
            $report_manager_data = $dq->getQuery()->getScalarResult();
        }

        $result = new ViewModel(array(
            'report_manager_data' => $report_manager_data,
        ));
        $result->setTerminal(true);
        return $result;
    }

    /**
     * Ajax get search promo codes.
     */
    public function keywordreposearchAction() {
        $this->layout('layout/ajax');

        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            $match_param = $data->search_param;
            $dq = $this->getEntityManager()->createQueryBuilder();
            $dq->select('main', 'rt', 'ars')->from('Admin\Entity\ReportManager', 'main')
                    ->LeftJoin('Admin\Entity\ReportType', 'rt', \Doctrine\ORM\Query\Expr\Join::WITH, 'main.reportTypeId=rt.id')
                    ->LeftJoin('Admin\Entity\ActivityReportStatus', 'ars', \Doctrine\ORM\Query\Expr\Join::WITH, 'main.status=ars.id');


            if (!empty($match_param) || $match_param != '') {
                $dq = $dq->Where("rt.type LIKE " . "'%" . $match_param . "%'" . " OR main.name LIKE " . "'%" . $match_param . "%'" . " OR main.type LIKE " . "'%" . $match_param . "%'" . " OR main.userEmail LIKE " . "'%" . $match_param . "%'" . " OR ars.status LIKE " . "'%" . $match_param . "%'");
            }
            $report_manager_data = $dq->getQuery()->getScalarResult();
        }

        $result = new ViewModel(array(
            'report_manager_data' => $report_manager_data,
        ));
        $result->setTerminal(true);
        return $result;
    }

    public function getmoreuserAction() {

        $this->layout('layout/ajax');
        $request = $this->getRequest();
         if ($request->isPost()) {
            $data = $request->getPost();


        $q = $this->getEntityManager()->createQueryBuilder();
        $q->select(array('l.login_id', 'l.username', 'u.first_name', 'u.last_name', 'u.country', 'u.gender', 'c.country as countryname', 's.state as statename', 'ct.city as city_name', 'us.created', 'u.user_block_status'))
                ->from('User\Entity\LoginDetails', 'l')
                ->leftJoin('User\Entity\UserDetails', 'u', 'WITH', 'u.login_id= l.login_id')
                ->leftJoin('User\Entity\UserSiteInfo', 'us', 'WITH', 'l.login_id= us.user_id')
                ->leftJoin('User\Entity\Country', 'c', 'WITH', 'u.country= c.country_id')
                ->leftJoin('User\Entity\City', 'ct', 'WITH', 'u.city= ct.city_id')
                ->leftJoin('User\Entity\State', 's', 'WITH', 'u.state= s.state_id')
                ->where('u.user_block_status != 2')
                ->groupBy('l.login_id')
                ->orderBy('l.login_id', 'DESC')
                ->addOrderBy('us.created', 'ASC');
        $allusers = $q->getQuery()->getResult();
        
        $page = count($allusers);

        $paginator = new \Zend\Paginator\Paginator(new
                \Zend\Paginator\Adapter\ArrayAdapter($allusers)
        );



        if (isset($data['pg_id'])) {
            $paginator->setCurrentPageNumber($data['pg_id']);
        } else {
            $paginator->setCurrentPageNumber(1);
        }
        $paginator->setDefaultItemCountPerPage(20);




        /* -----search form -------- */

        $search_form = new SearchUserForm();
        /* -------end search form------- */
         }
        $result= new ViewModel(array(
            'allusers' => $allusers,
            'search_form' => $search_form,
            'page' => $page,
            'paginator' => $paginator,
        ));
         $result->setTerminal(true);
        return $result;
    }
   
    
    public function getsortmoreuserAction() {

        $this->layout('layout/ajax');
        $request = $this->getRequest();
        if ($request->isPost()) {
        $data = $request->getPost();


        $dq = $this->getEntityManager()->createQueryBuilder();
            $dq->select(array('l.login_id', 'l.username', 'u.first_name', 'u.last_name', 'u.country', 'u.gender', 'c.country as countryname', 's.state as statename', 'ct.city as city_name', 'us.created', 'u.user_block_status'))
                    ->from('User\Entity\LoginDetails', 'l')
                    ->leftJoin('User\Entity\UserDetails', 'u', 'WITH', 'u.login_id= l.login_id')
                    ->leftJoin('User\Entity\UserSiteInfo', 'us', 'WITH', 'l.login_id= us.user_id')
                    ->leftJoin('User\Entity\Country', 'c', 'WITH', 'u.country= c.country_id')
                    ->leftJoin('User\Entity\City', 'ct', 'WITH', 'u.city= ct.city_id')
                    ->leftJoin('User\Entity\State', 's', 'WITH', 'u.state= s.state_id')
                    ->where('u.user_block_status != 2');
            if (!empty($data->user_by)) {
                if ($data->user_by == 'blocked') {
                    $dq = $dq->andWhere('u.user_block_status = 1');
                }
                if ($data->user_by == 'unblocked') {
                    $dq = $dq->andWhere('u.user_block_status = 0');
                }
            }
            if (!empty($data->location)) {
                if ($data->location == 'state') {
                    $dq = $dq->orderBy('s.state', 'DESC');
                }
                if ($data->location == 'city') {
                    $dq = $dq->orderBy('ct.city', 'DESC');
                }
                if ($data->location == 'country') {
                    $dq = $dq->orderBy('c.country', 'DESC');
                }
            }
            if (!empty($data->sort_by)) {
                if ($data->sort_by == 'newest') {
                    $dq = $dq->addOrderBy('l.login_id', 'DESC');
                }
                if ($data->sort_by == 'oldest') {
                    $dq = $dq->addOrderBy('l.login_id', 'ASC');
                }
            }
            if ($data->user_by == '' && $data->location == '' && $data->sort_by == '') {
                $dq = $dq->orderBy('l.login_id', 'DESC')
                        ->addOrderBy('us.created', 'ASC');
            }
            $dq = $dq->groupBy('l.login_id');

            $allusers = $dq->getQuery()->getResult();
            
            $page = count($allusers);

            $paginator = new \Zend\Paginator\Paginator(new
                \Zend\Paginator\Adapter\ArrayAdapter($allusers)
               ); 



        if (isset($data['pg_id'])) {
            $paginator->setCurrentPageNumber($data['pg_id']);
        } else {
            $paginator->setCurrentPageNumber(1);
        }

        $paginator->setDefaultItemCountPerPage(20); 
        
        }

        $result= new ViewModel(array(
            'allusers' => $allusers,
             'paginator'=>$paginator,
        ));
         $result->setTerminal(true);
        return $result;
    }
    
     /**
     * Ajax get search promo codes.
     */
    public function reportlistsortAction() {
        $this->layout('layout/ajax');


        $request = $this->getRequest();
        if ($request->isPost()) {
            $data = $request->getPost();
            $current_date = date('Y-m-d');
            $dq = $this->getEntityManager()->createQueryBuilder();
            $dq->select(array('l.login_id', 'l.username', 'u.first_name', 'u.last_name', 'u.country', 'u.gender', 'c.country as countryname', 's.state as statename', 'ct.city as city_name', 'us.created', 'u.user_block_status'))
                    ->from('User\Entity\LoginDetails', 'l')
                    ->leftJoin('User\Entity\UserDetails', 'u', 'WITH', 'u.login_id= l.login_id')
                    ->leftJoin('User\Entity\UserSiteInfo', 'us', 'WITH', 'l.login_id= us.user_id')
                    ->leftJoin('User\Entity\Country', 'c', 'WITH', 'u.country= c.country_id')
                    ->leftJoin('User\Entity\City', 'ct', 'WITH', 'u.city= ct.city_id')
                    ->leftJoin('User\Entity\State', 's', 'WITH', 'u.state= s.state_id')
                    ->where('u.user_block_status != 2');

            if (empty($data->today_report) && !empty($data->from_date) && !empty($data->to_date)) {

                $dq = $dq->andWhere('us.created BETWEEN :monday AND :sunday')
                        ->setParameter('monday', $data->from_date)
                        ->setParameter('sunday', $data->to_date);
            } else if (!empty($data->today_report) && empty($data->from_date) && empty($data->to_date)) {

                if ($data->today_report == 'today') {
                    $dq = $dq->andWhere($dq->expr()->gte('us.created', 'CURRENT_DATE()'));
                } else if ($data->today_report == 'WTD') {
                    $current_dayname = date("l");

                    $weeks_first_day = date("Y-m-d", strtotime('monday this week'));

                    $dq->andWhere('us.created BETWEEN :monday AND :sunday')
                            ->setParameter('monday', $weeks_first_day)
                            ->setParameter('sunday', $current_date);
                } else if ($data->today_report == 'MTD') {
                    $month_first_date = date("Y-m-01");

                    $dq->andWhere('us.created BETWEEN :monday AND :sunday')
                            ->setParameter('monday', $month_first_date)
                            ->setParameter('sunday', $current_date);
                } else if ($data->today_report == 'YTD') {
                    $year_first_date = date("Y-01-01");

                    $dq->andWhere('us.created BETWEEN :monday AND :sunday')
                            ->setParameter('monday', $year_first_date)
                            ->setParameter('sunday', $current_date);
                } else {
                    
                }
            } else {
                
            }

            $dq = $dq->groupBy('l.login_id')
                    ->orderBy('l.login_id', 'DESC')
                    ->addOrderBy('us.created', 'ASC');


            $allusers = $dq->getQuery()->getResult();
            
            $page = count($allusers);

            $paginator = new \Zend\Paginator\Paginator(new
                \Zend\Paginator\Adapter\ArrayAdapter($allusers)
               ); 



            if (isset($data['pg_id'])) {
                $paginator->setCurrentPageNumber($data['pg_id']);
            } else {
                $paginator->setCurrentPageNumber(1);
            }

            $paginator->setDefaultItemCountPerPage(20); 
            }

            $result = new ViewModel(array(
                'allusers' => $allusers,
                'paginator'=> $paginator,
            ));
            $result->setTerminal(true);
            return $result;
       }
    
}

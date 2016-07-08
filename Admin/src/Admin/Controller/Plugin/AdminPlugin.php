<?php

/*
 * 
 * ******************************************************************************
 * 
 * Plugin:- gloabal method
 * 
 * *****************************************************************************
 */

namespace Admin\Controller\Plugin;

use Zend\Mvc\Controller\Plugin\AbstractPlugin;
use Zend\Mvc\Controller\AbstractActionController;
use Zend\View\Model\ViewModel;
use Doctrine\ORM\EntityManager;
use Zend\Session\Container;
use Doctrine\ORM\Query\AST\Functions\Month;
use Admin\ENtity\ConvertUsing;
class AdminPlugin extends AbstractPlugin {

    protected $form;
    protected $storage;
    protected $authservice;

    /**
     * Entity manager instance
     *           
     * @var Doctrine\ORM\EntityManager
     */
    protected $em;

    /**
     * *
     * * Type: Function 
     * *
     * *  Short Description: Set entity manager
     * *
     */
    public function setEntityManager(EntityManager $em) {
        $this->em = $em;
    }

    /**
     * Returns an instance of the Doctrine entity manager loaded from the service 
     * locator
     * 
     * @return Doctrine\ORM\EntityManager
     */
    public function getEntityManager() {

        if (null === $this->em) {
            $this->em = $this->getController()->getServiceLocator()->get('Doctrine\ORM\EntityManager');
        }
        return $this->em;
    }
    
    /**
     * Return the All site user registered
     * 
     * */
    public function getAllsiteinfo() {

        $photo_count = array();
        $phot = array();
        $applications = $this->getEntityManager()->getRepository('Admin\Entity\Application')->findAll();

        foreach ($applications as $app)
        {
            $dq = $this->getEntityManager()->createQueryBuilder();
            $dq->select(array('count(c.user_photograph_id)', 'ap.application_id', 'ap.application'))
                    ->from('Admin\Entity\UserPhotographs', 'c')
                    ->leftJoin('Admin\Entity\Application', 'ap', 'WITH', 'c.app_id= ap.application_id')
                    ->where('ap.application_id =' . $app->application_id)
                    ->andWhere('c.status=0');
            $count = $dq->getQuery()->getArrayResult();
            array_push($photo_count, array('app' => $count[0]['application'], 'count' => $count[0][1], 'appid' => $count[0]['application_id']));
        }
        return $photo_count;
    }
    
    
   public function getPaymentsummary(){
     $emConfig = $this->getEntityManager()->getConfiguration();
     $emConfig->addCustomDatetimeFunction('MONTH', 'Doctrine\ORM\Query\AST\Functions\Month');
     $emConfig->addCustomDatetimeFunction('YEAR', 'Doctrine\ORM\Query\AST\Functions\Year');
     $emConfig->addCustomDatetimeFunction('WEEK', 'Doctrine\ORM\Query\AST\Functions\Week');
     $emConfig->addCustomDatetimeFunction('DATE', 'Doctrine\ORM\Query\AST\Functions\Date');
    $q=$this->getEntityManager()->createQueryBuilder();
    $q->select('p','trans','transtype','SUM(p.paidAmount) as paidamount','SUM(mtd.paidAmount) as MTD','SUM(wtd.paidAmount) as WTD','SUM(ytd.paidAmount) as YTD','SUM(ytdpy.paidAmount) as YTDPY','SUM(td.paidAmount) as today')->from('Admin\Entity\Payment','p')
        ->leftJoin('p.transactions','trans',\Doctrine\ORM\Query\Expr\Join::WITH,'p.transactionId=trans.id')
        ->leftJoin('p.paymentfor','transtype',\Doctrine\ORM\Query\Expr\Join::WITH,'p.transaction_type=transtype.id')
        ->leftJoin('p.today','td',\Doctrine\ORM\Query\Expr\Join::WITH,'td.id=p.id AND DATE(trans.transactionDate)=CURRENT_DATE()')
        ->leftJoin('p.MTD','mtd',\Doctrine\ORM\Query\Expr\Join::WITH,'mtd.id=p.id AND MONTH(trans.transactionDate)='.date('m'))
        ->leftJoin('p.WTD','wtd',\Doctrine\ORM\Query\Expr\Join::WITH,'wtd.id=p.id AND WEEK(trans.transactionDate,1)='.date('W'))
        ->leftJoin('p.YTD','ytd',\Doctrine\ORM\Query\Expr\Join::WITH,'ytd.id=p.id AND YEAR(trans.transactionDate)='.date('Y'))
       ->leftJoin('p.YTDPY','ytdpy',\Doctrine\ORM\Query\Expr\Join::WITH,'ytdpy.id=p.id AND YEAR(trans.transactionDate)='.date('Y',strtotime(date('y-m-d')."-1 YEAR")).' AND  trans.transactionDate<='.date('Y-m-d',strtotime(date('y-m-d')." -1 YEAR")))
       ->groupBy('transtype.id');
   $paymentSummary=$q->getQuery()->getArrayResult();
   return $paymentSummary;
    
   }
   
   public function getSearchSaleSummary($data=null){
    
    $emConfig = $this->getEntityManager()->getConfiguration();
     $emConfig->addCustomDatetimeFunction('MONTH', 'Doctrine\ORM\Query\AST\Functions\Month');
     $emConfig->addCustomDatetimeFunction('YEAR', 'Doctrine\ORM\Query\AST\Functions\Year');
     $emConfig->addCustomDatetimeFunction('WEEK', 'Doctrine\ORM\Query\AST\Functions\Week');
     $emConfig->addCustomDatetimeFunction('DATE', 'Doctrine\ORM\Query\AST\Functions\Date');
    $q=$this->getEntityManager()->createQueryBuilder();
   
    $q->select('p','trans','transtype','SUM(p.paidAmount) as paidamount','SUM(mtd.paidAmount) as MTD','SUM(wtd.paidAmount) as WTD','SUM(ytd.paidAmount) as YTD','SUM(ytdpy.paidAmount) as YTDPY','SUM(td.paidAmount) as today')->from('Admin\Entity\Payment','p')
        ->leftJoin('p.transactions','trans',\Doctrine\ORM\Query\Expr\Join::WITH,'p.transactionId=trans.id')
        ->leftJoin('p.paymentfor','transtype',\Doctrine\ORM\Query\Expr\Join::WITH,'p.transaction_type=transtype.id')
        ->leftJoin('p.today','td',\Doctrine\ORM\Query\Expr\Join::WITH,'td.id=p.id AND DATE(trans.transactionDate)=CURRENT_DATE()')
        ->leftJoin('p.MTD','mtd',\Doctrine\ORM\Query\Expr\Join::WITH,'mtd.id=p.id AND MONTH(trans.transactionDate)='.date('m'))
        ->leftJoin('p.WTD','wtd',\Doctrine\ORM\Query\Expr\Join::WITH,'wtd.id=p.id AND WEEK(trans.transactionDate,1)='.date('W'))
        ->leftJoin('p.YTD','ytd',\Doctrine\ORM\Query\Expr\Join::WITH,'ytd.id=p.id AND YEAR(trans.transactionDate)='.date('Y'))
       ->leftJoin('p.YTDPY','ytdpy',\Doctrine\ORM\Query\Expr\Join::WITH,'ytdpy.id=p.id AND YEAR(trans.transactionDate)='.date('Y',strtotime(date('y-m-d')."-1 YEAR")).' AND  trans.transactionDate<='.date('Y-m-d',strtotime(date('y-m-d')." -1 YEAR")));
       if(isset($data->reportbysite) && $data->reportbysite!=0 && $data->reportbysite!=''){
          $q->where('p.siteId='.$data->reportbysite);
       }
       if(isset($data->fromdate) && isset($data->todate) && $data->todate!='' ){
          $q->andWhere('DATE(trans.transactionDate) BETWEEN :fromdate AND :todate')
          ->setParameter('fromdate', $data->fromdate)
          ->setParameter('todate', $data->todate);
       }
         if(isset($data->reportbydate) && isset($data->reportbydate) && $data->reportbydate!='' ){
           if($data->reportbydate=='0'){
            $q->andWhere('DATE(trans.transactionDate) = CURRENT_DATE()');
            }else if($data->reportbydate=='1'){
            $q->andWhere('WEEK(trans.transactionDate,1)='.date('W'));
             }else if($data->reportbydate=='2'){
           
             $q->andWhere('MONTH(trans.transactionDate)='.date('m'));
          
           } else if($data->reportbydate=='3'){
            $q->andWhere('YEAR(trans.transactionDate)='.date('Y'));
           }
       }
       if(isset($data->reportbyproduct) && $data->reportbyproduct!=0 && $data->reportbyproduct!=''){
          $q->andWhere('p.transaction_type='.$data->reportbyproduct);
       }
       
      
       $q->groupBy('transtype.id');
   $paymentSummary=$q->getQuery()->getArrayResult();
   return $paymentSummary;
   }
   
   
   
   public function getSaleReport(){
    
    $emConfig = $this->getEntityManager()->getConfiguration();
     $emConfig->addCustomDatetimeFunction('MONTH', 'Doctrine\ORM\Query\AST\Functions\Month');
     $emConfig->addCustomDatetimeFunction('YEAR', 'Doctrine\ORM\Query\AST\Functions\Year');
     $emConfig->addCustomDatetimeFunction('WEEK', 'Doctrine\ORM\Query\AST\Functions\Week');
     $emConfig->addCustomDatetimeFunction('DATE', 'Doctrine\ORM\Query\AST\Functions\Date');
     $emConfig->addCustomDatetimeFunction('CONVERT', 'Admin\Entity\ConvertUsing');
     $q=$this->getEntityManager()->createQueryBuilder();
      $q->select('p','trans','transtype','ud','app','c','st','c.country as country','st.state as state','ud.city as city','ud.login_id as userId','trans.transactionId as transId','app.shortname as site','transtype.transactionType as product','p.paidAmount as sale','(p.paidAmount  - trans.transaction_fee) as netsale','trans.transactionDate as txndate')
         ->from('Admin\Entity\Payment','p')
         ->leftJoin('p.userdetail','ud',\Doctrine\ORM\Query\Expr\Join::WITH,'ud.login_id=p.userId')
         ->leftJoin('ud.countryData','c',\Doctrine\ORM\Query\Expr\Join::WITH,'c.country_id=ud.country')
         ->leftJoin('ud.stateData','st',\Doctrine\ORM\Query\Expr\Join::WITH,'st.state_id=ud.state')
         ->leftJoin('p.transactions','trans',\Doctrine\ORM\Query\Expr\Join::WITH,'p.transactionId=trans.id')
        ->leftJoin('p.paymentfor','transtype',\Doctrine\ORM\Query\Expr\Join::WITH,'p.transaction_type=transtype.id')
        ->leftJoin('p.application','app',\Doctrine\ORM\Query\Expr\Join::WITH,'app.application_id=p.siteId');;
      
        $saleReport=$q->getQuery()->getArrayResult();
          return $saleReport;
   }
   
   
   
  
   
   public function searchSaleReport($data=null){
    
    
    $emConfig = $this->getEntityManager()->getConfiguration();
     $emConfig->addCustomDatetimeFunction('MONTH', 'Doctrine\ORM\Query\AST\Functions\Month');
     $emConfig->addCustomDatetimeFunction('YEAR', 'Doctrine\ORM\Query\AST\Functions\Year');
     $emConfig->addCustomDatetimeFunction('WEEK', 'Doctrine\ORM\Query\AST\Functions\Week');
     $emConfig->addCustomDatetimeFunction('DATE', 'Doctrine\ORM\Query\AST\Functions\Date');
     $q=$this->getEntityManager()->createQueryBuilder();
      $q->select('p','trans','transtype','ud','app','c','st')->from('Admin\Entity\Payment','p')
      ->leftJoin('p.userdetail','ud',\Doctrine\ORM\Query\Expr\Join::WITH,'ud.login_id=p.userId')
      ->leftJoin('ud.country_id','c',\Doctrine\ORM\Query\Expr\Join::WITH,'c.country_id=ud.country')
      ->leftJoin('ud.stateData','st',\Doctrine\ORM\Query\Expr\Join::WITH,'st.state_id=ud.state')
      ->leftJoin('p.transactions','trans',\Doctrine\ORM\Query\Expr\Join::WITH,'p.transactionId=trans.id')
      ->leftJoin('p.paymentfor','transtype',\Doctrine\ORM\Query\Expr\Join::WITH,'p.transaction_type=transtype.id')
      ->leftJoin('p.application','app',\Doctrine\ORM\Query\Expr\Join::WITH,'app.application_id=p.siteId');
       if(isset($data->fromdate) && isset($data->todate) && $data->todate!='' ){
          $q->andWhere('DATE(trans.transactionDate) BETWEEN :fromdate AND :todate')
          ->setParameter('fromdate', $data->fromdate)
          ->setParameter('todate', $data->todate);
       }
       
        if(isset($data->reportbydate) && isset($data->reportbydate) && $data->reportbydate!='' ){
           if($data->reportbydate=='0'){
            $q->andWhere('DATE(trans.transactionDate) = CURRENT_DATE()');
            }else if($data->reportbydate=='1'){
            $q->andWhere('WEEK(trans.transactionDate,1)='.date('W'));
             }else if($data->reportbydate=='2'){
           
             $q->andWhere('MONTH(trans.transactionDate)='.date('m'));
          
           } else if($data->reportbydate=='3'){
            $q->andWhere('YEAR(trans.transactionDate)='.date('Y'));
           }
       }
        if(isset($data->reportbysale) && isset($data->reportbysale) && $data->reportbysale!='' ){
          $q->andWhere('p.transaction_type='.$data->reportbysale);
         
       }
        if(isset($data->reporttype) && isset($data->reporttype) && $data->reporttype!='' ){
          //$q->where('p.siteId='.$data->reporttype);
       }
        if(isset($data->reportbysite) && $data->reportbysite!=0 && $data->reportbysite!=''){
          $q->where('p.siteId='.$data->reportbysite);
       }
       if(isset($data->reportbylocation) && isset($data->reportbylocation) && $data->reportbylocation!='' ){
           if($data->reportbylocation=='all'){
            
           }else if($data->reportbylocation=='country'){
             $q->where('c.country LIKE '."'%".$data->reportlocation."%'");
           }else if($data->reportbylocation=='state'){
             $q->where('st.state LIKE '."'%".$data->reportlocation."%'");
           }else if($data->reportbylocation=='city'){
             $q->where('ud.city LIKE'."'%".$data->reportlocation."%'");
           }
       }
      
      $searchsaleReport=$q->getQuery()->getArrayResult();
      return $searchsaleReport;
    
   }
    
}

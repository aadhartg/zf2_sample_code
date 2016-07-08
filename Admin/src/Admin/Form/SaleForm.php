<?php

namespace Admin\Form;

use Zend\Form\Form;

class SaleForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('sale_report_form');
        $this->setAttribute('method', 'post');
		//$this->setAttribute('onsubmit', 'return validateForm()');
	      
       $this->add(array(
           'name' => 'reportbyproduct',
            'type' => 'Select',
            'options' => array(
              
            ),
			'attributes' => array(
                'id' => 'reportbyproduct',
            ),
       
       ));
       
       $this->add(array(
           'name' => 'reportbysite',
            'type' => 'Select',
            'options' => array(
              
            ),
			'attributes' => array(
                'id' => 'reportbysite',
            ),
       
       ));
          $this->add(array(
           'name' => 'reportbylocation',
            'type' => 'Select',
            'options' => array(
              'value_options'=>array(
                 'all'=>'All',
                 'country'=>'Country',
                 'state'=>'State',
                 'city'=>'City',
              )
            ),
			'attributes' => array(
                'id' => 'reportbylocation',
            ),
       
       ));
          $this->add(array(
           'name' => 'reportlocation',
            'type' => 'Select',
            'options' => array(
              
            ),
			'attributes' => array(
                'id' => 'reportlocation',
                'disabled'=>'disabled',
            ),
       
       ));
          $this->add(array(
           'name' => 'reportsortbydate',
            'type' => 'Select',
            'options' => array(
              'value_options'=>array(''=>'Please Select','txndate_asc'=>'Newest','txndate_desc'=>'Oldest'),
            ),
			'attributes' => array(
                'id' => 'reportsortbydate',
                
            ),
       
       ));
        $this->add(array(
           'name' => 'reportsortbyid',
            'type' => 'Select',
            'options' => array(
            'value_options'=>array(
                                 ''=>'Please Select',
                                'userId_asc'=>'User Id',
                                'transId_asc'=>'Transaction Id',
                                'site_asc'=>'Site',
                                'country_asc'=>'Country',
                                'state_asc'=>'State',
                                'city_asc'=>'City',
                                'product_asc'=>'Product',
                                'sale_desc'=>'Sale',
                                'credit_desc'=>'Credit',
                                'netsale_desc'=>'Net Sale High',
                                'netsale_asc'=>'Net Sale Low',
                                'txndate_asc'=>'Newest',
                                'txndate_desc'=>'Oldest',
                                'approved'=>'Approved',
                                'declined'=>'Declined',
                             
                            ),
            ),
			'attributes' => array(
                'id' => 'reportsortbyid',
            ),
       
       ));
       
          $this->add(array(
           'name' => 'reporttype',
            'type' => 'Select',
            'options' => array(
              'value_options'=>array(
                 ''=>'Please Select',
                 'summary'=>'Summary',
                 'report'=>'Detail',
              ),
            ),
			'attributes' => array(
                'id' => 'reporttype',
            ),
       
       ));
          $this->add(array(
           'name' => 'reportbysale',
            'type' => 'Select',
            'options' => array(
              
            ),
			'attributes' => array(
                'id' => 'reportbysale',
            ),
       
       ));
       
        $this->add(array(
           'name' => 'reportbyuser',
            'type' => 'Select',
            'options' => array(
              
            ),
			'attributes' => array(
                'id' => 'reportbyuser',
            ),
       
       )); 
       
       $this->add(array(
           'name' => 'reportbystatus',
            'type' => 'Select',
            'options' => array(
               'value_options'=>array(
                 ''=>'Please Select',
                 'submitted'=>'Submitted',
                 'validated'=>'Validated',
                 'cleared'=>'Cleared',
              ),
            ),
			'attributes' => array(
                'id' => 'reportbystatus',
            ),
       
       )); 
       
       $this->add(array(
           'name' => 'reportbydate',
            'type' => 'Select',
            'options' => array(
              	'value_options' => array(
				    '' => 'Please Select',
                    '0'=>'Today',
                    '1' => 'Week Till Date',
					'2' => 'Month Till Date',
					'3' => 'Year Till Date',
                ),
            ),
			'attributes' => array(
                'id' => 'reportbydate',
                'style'=>'width:121px; margin-left:6px; float:left;',
            ),
       
       ));
       $this->add(array(
           'name' => 'fromdate',
            'type' => 'Text',
            'options' => array(
              
            ),
			'attributes' => array(
                'id' => 'fromdate',
                'style'=>'width:100px; float:left;',
            ),
       
       ));
       
       $this->add(array(
           'name' => 'reportsearch',
            'type' => 'Text',
            'options' => array(
              
            ),
			'attributes' => array(
                'id' => 'reportsearch',
                'style'=>'width:200px; float:left;',
            ),
       
       ));
       $this->add(array(
           'name' => 'todate',
            'type' => 'Text',
            'options' => array(
              
            ),
			'attributes' => array(
                'id' => 'todate',
                'style'=>'width:100px; float:left;',
            ),
       
       ));
       
         $this->add(array(
           'name' => 'searchbtn',
            'type' => 'Submit',
            'options' => array(
              
            ),
			'attributes' => array(
                'id' => 'searchbtn',
                'value'=>'Search',
                'class'=>'searcho_promo',
                'style'=>'width:100px; margin-left:39px; float:left; padding:6px;',
            ),
       
       ));
    }

}
<?php

namespace Admin\Form;

use Zend\Form\Form;

class SearchReportForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('user_details');
        $this->setAttribute('method', 'post');
		$this->setAttribute('onsubmit', 'return validateForm()');
		
        $this->add(array(
            'name' => 'registrationTypes',
            'type' => 'Select',
            'options' => array(
                //'disable_inarray_validator' => true,
				'value_options' => array(
				    '' => 'Please Select',
					'0' => 'Visitor',
					'1' => 'Free Membership',
					'2'	=> 'Paid Member',
					'3'	=> 'Membership Renewal',
					'4' =>	'Subscription',
					'5' =>	'Advertising',
				),
            ),
			'attributes' => array(
                'id' => 'registration_types',
				
            ),
        ));
        

        $this->add(array(
            'name' => 'reportType',
            'type' => 'Select',
            'options' => array(
                'disable_inarray_validator' => true,
				'value_options' => array(
					'detail' => 'Detail',
					'summary' => 'Summary',
					
				),
            ),
			'attributes' => array(
                'id' => 'report_type',
				
            ),
        ));
        
		
		 $this->add(array(
            'name' => 'siteId',
            'type' => 'Select',
            
			'attributes' => array(
                'id' => 'site_id',
            ),
        ));
		 $this->add(array(
            'name' => 'location',
            'type' => 'Select',
            'options' => array(
                //'disable_inarray_validator' => true,
				'value_options' => array(
				    '' => 'Please Select',
                   'state' => 'State',
                    'city' => 'City',
					'country' => 'Country',
                ),
            ),
			'attributes' => array(
                'id' => 'location',
            ),
        ));
		
		 $this->add(array(
            'name' => 'accountStatus',
            'type' => 'Select',
            'options' => array(
                //'disable_inarray_validator' => true,
				'value_options' => array(
				    '' => 'Please Select',
                   '1' => 'Approved',
                    '2' => 'Declined',
					'0' => 'Pending',
                ),

            ),
			'attributes' => array(
                'id' => 'account_status',
            ),
        ));
		
		$this->add(array(
            'name' => 'sortBy',
            'type' => 'Select',
            'options' => array(
                //'disable_inarray_validator' => true,
				'value_options' => array(
				    '' => 'Please Select',
                    'registration_type' => 'Registration Type',
					'user_id' => 'User Id',
					'app_id' => 'Site',
					'country' => 'Country',
					'state' => 'State',
					'city' => 'City',
					'age' => 'Age',
					'as' => 'AS',
					'maritalstatus' => 'Maritial Status',
					'newest' => 'Newest',
					'oldest' => 'Oldest',
					
                ),

            ),
			'attributes' => array(
                'id' => 'sort_by',
            ),
        ));
		
		
        
    }


}
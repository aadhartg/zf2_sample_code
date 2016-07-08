<?php

namespace Admin\Form;

use Zend\Form\Form;

class AdminReportForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('user_details');
        $this->setAttribute('method', 'post');
		$this->setAttribute('onsubmit', 'return validateForm()');
		
        $this->add(array(
            'name' => 'report',
            'type' => 'Select',
			'attributes' => array(
                'id' => 'report',
				
            ),
        ));
        

        $this->add(array(
            'name' => 'sort_first',
            'type' => 'Select',
            'options' => array(
                'disable_inarray_validator' => true,
				'value_options' => array(
					'' => 'Please Selact',
					'1' => 'Date Newest',
					'2' => 'Date Oldest',
					'3' => 'User Id',
					'4' => 'Report Type',
					'5' => 'Report Id',
					'6' => 'Name',
					'7' => 'Photo/Video Id',
					
				),
            ),
			'attributes' => array(
                'id' => 'sort_first',
				
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
            'name' => 'sort_second',
            'type' => 'Select',
            'options' => array(
                //'disable_inarray_validator' => true,
				'value_options' => array(
				    '' => 'Report Type',
                   '0' => 'All',
                    '1' => 'Photo',
					'2' => 'Content',
					'3' => 'Technology',
                ),
            ),
			'attributes' => array(
                'id' => 'sort_second',
            ),
        ));
		
		 $this->add(array(
            'name' => 'sort_third',
            'type' => 'Select',
            'options' => array(
                //'disable_inarray_validator' => true,
				'value_options' => array(
				    '' => 'Please Select',
                   '1' => 'User Id',
                   
                ),

            ),
			'attributes' => array(
                'id' => 'sort_third',
            ),
        ));
		
		$this->add(array(
            'name' => 'status',
            'type' => 'Select',
            'options' => array(
                //'disable_inarray_validator' => true,
				'value_options' => array(
				    '' => 'Please Select',
                    '9' => 'Validated',
					'1' => 'Submitted',
					'10' => 'Cleared',
                ),

            ),
			'attributes' => array(
                'id' => 'status',
            ),
        ));
		
		
        
    }


}
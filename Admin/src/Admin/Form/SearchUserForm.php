<?php

namespace Admin\Form;

use Zend\Form\Form;

class SearchUserForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('user_details');
        $this->setAttribute('method', 'post');
		$this->setAttribute('onsubmit', 'return validateForm()');
	

        
	
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
            'name' => 'sortBy',
            'type' => 'Select',
            'options' => array(
                //'disable_inarray_validator' => true,
				'value_options' => array(
				    '' => 'Please Select',
					'newest' => 'Newest',
					'oldest' => 'Oldest',
                                        
					
                ),

            ),
			'attributes' => array(
                'id' => 'sort_by',
            ),
        ));
		
	$this->add(array(
            'name' => 'userBy',
            'type' => 'Select',
            'options' => array(
                //'disable_inarray_validator' => true,
				'value_options' => array(
				    '' => 'Please Select',
                                        'blocked' => 'Blocked',
					'unblocked' => 'Unblocked',
					
                ),

            ),
			'attributes' => array(
                'id' => 'user_by',
            ),
        ));	
        
    }


}

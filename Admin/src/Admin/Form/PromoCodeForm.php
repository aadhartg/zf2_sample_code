<?php

namespace Admin\Form;

use Zend\Form\Form;

class PromoCodeForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('promo_code');
        $this->setAttribute('method', 'post');
		$this->setAttribute('onsubmit', 'return validateForm()');
		$this->add(array(
            'name' => 'promocodeId',
            'type' => 'Hidden',
            
        ));
		
        $this->add(array(
            'name' => 'typeId',
            'type' => 'Select',
            'options' => array(
                'disable_inarray_validator' => true,
            ),
			'attributes' => array(
                'id' => 'promo_type',
				
            ),
        ));
        $this->add(array(
            'name' => 'timeId',
            'type' => 'Select',
            'options' => array(
                'disable_inarray_validator' => true,
            ),
			'attributes' => array(
                'id' => 'promo_time',
				
            ),
        ));
        
		 $this->add(array(
            'name' => 'product',
            'type' => 'Select',
			'attributes' => array(
                'id' => 'product',
				
            ),
        ));
		
        $this->add(array(
            'name' => 'siteId',
            'type' => 'Select',
            'options' => array(
                'disable_inarray_validator' => true,
            ),
			'attributes' => array(
                'id' => 'pro_site_id',
				
            ),
        ));
        $this->add(array(
            'name' => 'created',
            'type' => 'Hidden',
			'attributes' => array(
                'id' => 'created_date',
				
            ),
        ));
		 $this->add(array(
            'name' => 'value',
            'type' => 'Hidden',
			'attributes' => array(
                'id' => 'value',
				
            ),
			
        ));
		$this->add(array(
            'name' => 'invoice',
            'type' => 'Hidden',
			'attributes' => array(
                'id' => 'invoice',
				
            ),
			
        ));
		$this->add(array(
            'name' => 'percentage',
            'type' => 'Hidden',
			'attributes' => array(
                'id' => 'percentage',
				
            ),
			
        ));
		 $this->add(array(
            'name' => 'applyTo',
            'type' => 'Select',
            'options' => array(
                //'disable_inarray_validator' => true,
                'value_options' => array(
				     '' => 'Please Select',
					 'alluser' =>'All Users',
					 'user' => 'User',
                    'subscribers' => 'Subscribers',
					'members' => 'Members',
                   ),
				),
				'attributes' => array(
                'id' => 'apply_to',
                
			),
        ));
		$this->add(array(
            'name' => 'userId',
            'type' => 'Text',
			'attributes' => array(
                'id' => 'user_id',
				'class'=>'promo_input-box',
				
            ),
        ));
		$this->add(array(
            'name' => 'name',
            'type' => 'Text',
			'attributes' => array(
                'id' => 'promo_name',
				'class'=>'promo_input-box',
            ),
        ));
		 $this->add(array(
            'name' => 'salesId',
            'type' => 'Select',
            'options' => array(
                'disable_inarray_validator' => true,
            ),
			'attributes' => array(
                'id' => 'sales',
            ),
        ));
		$this->add(array(
            'name' => 'goodFor',
            'type' => 'Select',
            'options' => array(
                //'disable_inarray_validator' => true,
				'value_options' => array(
				    '' => 'Please Select',
                   'one' => '1 Use',
                    'ongoing' => 'Ongoing',
                ),
            ),
			'attributes' => array(
                'id' => 'good_for',
            ),
        ));
		 $this->add(array(
            'name' => 'pay',
            'type' => 'Select',
            'options' => array(
                //'disable_inarray_validator' => true,
				'value_options' => array(
				    'time' => '1 Time',
                    'ongoing' => 'Ongoing',
					'track' => 'Track Only',
                ),
            ),
			'attributes' => array(
                'id' => 'pay',
            ),
        ));
		 $this->add(array(
            'name' => 'currency',
            'type' => 'Select',
            
			'attributes' => array(
                'id' => 'currency',
            ),
        ));
		 $this->add(array(
            'name' => 'amount',
            'type' => 'Text',
            
			'attributes' => array(
                'id' => 'amount',
            ),
        ));
		  $this->add(array(
            'name' => 'sel_month',
            'type' => 'Select',
			
			'attributes' => array(
                'id' => 'm',
				
            ),
        ));
		$this->add(array(
            'name' => 'sel_date',
            'type' => 'Select',
			
			'attributes' => array(
                'id' => 'd',
            ),
        ));
		$this->add(array(
            'name' => 'sel_year',
            'type' => 'Select',
			
			'attributes' => array(
                'id' => 'y',
            ),
        ));
		$this->add(array(
            'name' => 'categoryId',
            'type' => 'Select',
            
			'attributes' => array(
                'id' => 'cat_id',
            ),
        ));
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Save',
                'id' => 'submitbutton',
                'class' => 'btn btn-warning successButton'
            ),
        ));
    }

}
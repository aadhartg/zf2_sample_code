<?php

namespace Admin\Form;

use Zend\Form\Form;

class SearchPromoForm extends Form {

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
                'id' => 'search_promo_type',
				
            ),
        ));
        

        $this->add(array(
            'name' => 'siteId',
            'type' => 'Select',
            'options' => array(
                'disable_inarray_validator' => true,
            ),
			'attributes' => array(
                'id' => 'search_pro_site_id',
				
            ),
        ));
        
		
		 $this->add(array(
            'name' => 'salesId',
            'type' => 'Select',
            'options' => array(
                'disable_inarray_validator' => true,
            ),
			'attributes' => array(
                'id' => 'search_sales',
            ),
        ));
		 $this->add(array(
            'name' => 'pay',
            'type' => 'Select',
            'options' => array(
                //'disable_inarray_validator' => true,
				'value_options' => array(
				    '' => 'Please Select',
                   'time' => '1 Time',
                    'ongoing' => 'Ongoing',
					'track' => 'Track Only',
                ),
            ),
			'attributes' => array(
                'id' => 'search_pay',
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
            'name' => 'sortBy',
            'type' => 'Select',
            'options' => array(
                //'disable_inarray_validator' => true,
				'value_options' => array(
				    '' => 'Please Select',
                    'created' => 'Date Created',
					'percentage' => 'Percentage',
					'amount' => 'Amount',
					'value' => 'Code Value',
					'expiryDate' => 'Expiration',
					'status' => 'Status',
                ),
            ),
			'attributes' => array(
                'id' => 'search_sort',
            ),
        ));
		
		$this->add(array(
            'name' => 'status',
            'type' => 'Select',
            'options' => array(
                //'disable_inarray_validator' => true,
				'value_options' => array(
				    '' => 'Please Select',
                    '0' => 'Open',
					'1' => 'Expired',
					'2' => 'Redeemed',
                ),
            ),
			'attributes' => array(
                'id' => 'search_status',
            ),
        ));
		
		$this->add(array(
            'name' => 'categoryId',
            'type' => 'Select',
            
			'attributes' => array(
                'id' => 'sort_cat_id',
            ),
        ));
        
    }

}
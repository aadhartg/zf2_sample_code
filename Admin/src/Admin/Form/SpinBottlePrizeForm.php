<?php

namespace Admin\Form;

use Zend\Form\Form;

class SpinBottlePrizeForm extends Form {

    public function __construct($name = null) {
        // we want to ignore the name passed
        parent::__construct('spin_bottle_prize');
        $this->setAttribute('method', 'post');
		$this->setAttribute('onsubmit', 'return validateSpinForm()');
		$this->add(array(
            'name' => 'id1',
            'type' => 'Hidden',
            
        ));
		$this->add(array(
            'name' => 'id2',
            'type' => 'Hidden',
            
        ));
        $this->add(array(
            'name' => 'promoId1',
            'type' => 'Select',
            
			'attributes' => array(
                'id' => 'promo_id_1',
				
            ),
        ));
		 $this->add(array(
            'name' => 'promoId2',
            'type' => 'Select',
            
			'attributes' => array(
                'id' => 'promo_id_2',
				
            ),
        ));
       
        $this->add(array(
            'name' => 'spin1',
            'type' => 'text',
			'attributes' => array(
                'id' => 'spin1',
				
            ),
        ));
		$this->add(array(
            'name' => 'spin2',
            'type' => 'text',
			'attributes' => array(
                'id' => 'spin2',
				
            ),
        ));
		 
        $this->add(array(
            'name' => 'submit',
            'type' => 'Submit',
            'attributes' => array(
                'value' => 'Save',
                'id' => 'prizebutton',
                'class' => 'btn btn-warning successButton'
            ),
        ));
    }

}
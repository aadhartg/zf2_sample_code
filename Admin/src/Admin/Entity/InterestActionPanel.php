<?php

namespace Admin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Admin\Entity\Activities;
use Doctrine\Common\Collections\ArrayCollection;
use Zend\Validator\Db\RecordExists;

/**
 * ActivityActionPanel
 *
 * @ORM\Entity
 * @ORM\Table(name="interest_action_panel")
 * @property int $action_id
 * @property string $action_by
 * @property string $interest_id
 * @property string $action
 * @property string $site
 * @property string $in_out
 * @property string $status
 * @property string $notes
 */
class InterestActionPanel implements InputFilterAwareInterface {

    protected $inputFilter;

    /**
     * @ORM\Id
     * @ORM\Column(type="integer");
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $action_id;

    /**
     * @ORM\Column(type="integer")
     */
    protected $emp_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $action_by;

    /**
     * @ORM\Column(type="string")
     */
    protected $interest_id;

    /**
     * @ORM\Column(type="string")
     */
    protected $action;

    /**
     * @ORM\Column(type="string")
     */
    protected $description;

    /**
     * @ORM\Column(type="string")
     */
    protected $site;

    /**
     * @ORM\Column(type="string")
     */
    protected $in_out;

    /**
     * @ORM\Column(type="string")
     */
    protected $status;

    /**
     * @ORM\Column(type="string")
     */
    protected $notes;

    /**
     * @ORM\Column(type="string")
     */
    protected $date_time;

    /**
     * @ORM\Column(type="string")
     */
    protected $cust_name;

    /**
     * Magic getter to expose protected properties.
     *
     * @param string $property
     * @return mixed
     */
    public function __get($property) {
        return $this->$property;
    }

    /**
     * Magic setter to save protected properties.
     *
     * @param string $property
     * @param mixed $value
     */
    public function __set($property, $value) {
        $this->$property = $value;
        return $this;
    }

    /**
     * Convert the object to an array.
     *
     * @return array
     */
    public function getArrayCopy() {
        return get_object_vars($this);
    }

    /**
     * Populate from an array.
     *
     * @param array $data
     */
    public function populate($data = array()) {
        $this->action_by = isset($data['action_by']) ? $data['action_by'] : '';
        $this->emp_id = 1;
        $this->cust_name = isset($data['cust_name']) ? $data['cust_name'] : '';
        $this->action = $data['action'];
        $this->description = $data['description'];
        $this->in_out = isset($data['in_out']) ? $data['in_out'] : '';
        $this->status = isset($data['status']) ? $data['status'] : '';
        $this->notes = isset($data['notes']) ? $data['notes'] : '';
        $this->date_time = date('Y-m-d H:i:s');
    }

    public function setInputFilter(InputFilterInterface $inputFilter) {
        throw new \Exception("Not used");
    }

    public function getInputFilter() {
        if (!$this->inputFilter) {
            $inputFilter = new InputFilter();

            $factory = new InputFactory();

            $inputFilter->add($factory->createInput(array(
                        'name' => 'category',
                        'required' => false,
                    ))->setAllowEmpty(true));
            $inputFilter->add($factory->createInput(array(
                        'name' => 'activity',
                        'required' => false,
                    ))->setAllowEmpty(true));
            $inputFilter->add($factory->createInput(array(
                        'name' => 'application',
                        'required' => false,
                    ))->setAllowEmpty(true));
            $inputFilter->add($factory->createInput(array(
                        'name' => 'activity_id',
                        'required' => false,
                        'filters' => array(
                            array('name' => 'Int'),
                        ),
                    ))->setAllowEmpty(true));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'question',
                        'required' => false,
                    ))->setAllowEmpty(true));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'response',
                        'required' => false,
                    ))->setAllowEmpty(true));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'ques_res',
                        'required' => false,
                    ))->setAllowEmpty(true));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'activity_column',
                        'required' => false,
                    ))->setAllowEmpty(true));

            $inputFilter->add($factory->createInput(array(
                        'name' => 'manual_response',
                        'required' => false,
                    ))->setAllowEmpty(true));
            $inputFilter->add($factory->createInput(array(
                        'name' => 'activity_detail',
                        'required' => false,
                    ))->setAllowEmpty(true));

            $this->inputFilter = $inputFilter;
        }

        return $this->inputFilter;
    }

}

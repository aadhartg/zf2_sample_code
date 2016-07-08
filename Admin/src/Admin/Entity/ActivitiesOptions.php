<?php
 
namespace Admin\Entity;
 
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Doctrine\Common\Collections\ArrayCollection;

 
/**
* Activty Options  for different activities
*
* @ORM\Entity
* @ORM\Table(name="activities_options")
* @property int $activity_option_id
* @property string $options
* @property int $activity_category_id
* @property int $activity_id
*/
class ActivitiesOptions implements InputFilterAwareInterface
{
	protected $inputFilter;
	 
	/**
	* @ORM\Id
	* @ORM\Column(type="integer");
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
		
	protected $activity_option_id;
	
	
	/**
	* @ORM\Column(type="integer")
	*/
	
	
	protected $activity_category_id;
	/**
	* @ORM\Column(type="string")
	*/
	
	
	protected $activity_id;
	/**
	* @ORM\Column(type="string")
	*/
	
	protected $options;
	
        /**
	* @ORM\Column(type="integer")
	*/
	
	
	protected $tab;
        /**
	* @ORM\Column(type="integer")
	*/
	
	
	protected $status;
				
	/**
	* Magic getter to expose protected properties.
	*
	* @param string $property
	* @return mixed
	*/
	public function __get($property)
	{
		return $this->$property;
	}
	
	
	 
	/**
	* Magic setter to save protected properties.
	*
	* @param string $property
	* @param mixed $value
	*/
	public function __set($property, $value)
	{
		$this->$property = $value;
		return $this;
	}
	
	
	public function getId()
	{
	    return $this->activity_option_id;	
	}
	
	/**
	* Convert the object to an array.
	*
	* @return array
	*/
	public function getArrayCopy()
	{
		return get_object_vars($this);
	}
	 
	 
	/**
	* Populate from an array.
	*
	* @param array $data
	*/
	public function populate($data = array())
	{  
		$this->activity_option_id = isset($data['activity_option_id']) ? $data['activity_option_id'] : '' ;
		$this->activity_category_id=$data['activity_category_id'];
		$this->options=$data['options'];
		$this->activity_id=$data['activity_id'];
        $this->tab=$data['tab'];
        $this->status=$data['status'];
		
	}
	 
	public function setInputFilter(InputFilterInterface $inputFilter)
	{
		throw new \Exception("Not used");
	}
	 
	public function getInputFilter()
	{
		if (!$this->inputFilter) {
			$inputFilter = new InputFilter();
			$factory = new InputFactory();
			$this->inputFilter = $inputFilter;
		}
		 
	}

}
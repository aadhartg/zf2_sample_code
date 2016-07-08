<?php
 
namespace Admin\Entity;
 
use Doctrine\ORM\Mapping as ORM;
use Zend\InputFilter\InputFilter;
use Zend\InputFilter\Factory as InputFactory;
use Zend\InputFilter\InputFilterAwareInterface;
use Zend\InputFilter\InputFilterInterface;
use Doctrine\Common\Collections\ArrayCollection;

 
/**
* Places Data Entity  for different activities
*
* @ORM\Entity
* @ORM\Table(name="places_data")
* @property int $place_id
* @property string $place_entity
* @property string $category
* @property string $sub_category
* @property string $name
* @property string $address
* @property string $city
* @property string $state
* @property string $zip
* @property string $phone
* @property string $fax
* @property string $	email
* @property string $	url
* @property string $area_code
* @property string $fips
* @property string $timezone
* @property string $dst
* @property string $latitude
* @property string $longitude
* @property string $	msa
* @property string $pmsa
* @property string $county
* @property string $postal


*/
class PlacesData implements InputFilterAwareInterface
{
	protected $inputFilter;
	 
	/**
	* @ORM\Id
	* @ORM\Column(type="integer");
	* @ORM\GeneratedValue(strategy="AUTO")
	*/
		
	protected $place_id;
	

	/**
	* @ORM\Column(type="string")
	*/
	
	protected $place_entity;
	
/**
	* @ORM\Column(type="string")
	*/
	
	protected $category;
	/**
	* @ORM\Column(type="string")
	*/
	
	protected $sub_category;
	/**
	* @ORM\Column(type="string")
	*/
	
	protected $name;
	/**
	* @ORM\Column(type="string")
	*/
	
	protected $address;
	/**
	* @ORM\Column(type="string")
	*/
	
	protected $city;
/**
	* @ORM\Column(type="string")
	*/
	
	protected $state;
/**
	* @ORM\Column(type="string")
	*/
	
	protected $zip;
/**
	* @ORM\Column(type="string")
	*/
	
	protected $phone;
/**
	* @ORM\Column(type="string")
	*/
	
	protected $fax;
/**
	* @ORM\Column(type="string")
	*/
	
	protected $email;
/**
	* @ORM\Column(type="string")
	*/
	
	protected $url;
/**
	* @ORM\Column(type="string")
	*/
	
	protected $area_code;
/**
	* @ORM\Column(type="string")
	*/
	
	protected $fips;
/**
	* @ORM\Column(type="string")
	*/
	
	protected $timezone;
/**
	* @ORM\Column(type="string")
	*/
	
	protected $dst;
/**
	* @ORM\Column(type="string")
	*/
	
	protected $msa;
/**
	* @ORM\Column(type="string")
	*/
	
	protected $pmsa;
	/**
	* @ORM\Column(type="string")
	*/
	
	protected $county;
/**
	* @ORM\Column(type="string")
	*/
	
	protected $postal;
	/**
	* @ORM\Column(type="string")
	*/
	
	protected $latitude;
	/**
	* @ORM\Column(type="string")
	*/
	
	protected $longitude;

		

				
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
		$this->place_id = isset($data['place_id']) ? $data['place_id'] : '' ;
		$this->place_entity=$data['place_entity'];
		$this->category=$data['category'];
		$this->sub_category=$data['sub_category'];
		$this->name=$data['name'];
		$this->address=$data['address'];
		$this->city=$data['city'];
		$this->state=$data['state'];
		$this->zip=$data['zip'];
		$this->phone=$data['phone'];
		$this->fax=$data['fax'];
		$this->email=$data['email'];
		$this->url=$data['url'];
		$this->area_code=$data['area_code'];
		$this->fips=$data['fips'];
		$this->timezone=$data['timezone'];
		$this->dst=$data['dst'];
		$this->latitude=$data['latitude'];
		$this->longitude=$data['longitude'];
		$this->msa=$data['msa'];
		$this->pmsa=$data['pmsa'];
		$this->county=$data['county'];
		$this->postal=$data['postal'];
		
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
		 
		return $this->inputFilter;
	}
	}
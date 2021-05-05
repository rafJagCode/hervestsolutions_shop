<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;
use Psr\Log\LoggerInterface;

class ClassnamesFunctionExtension extends AbstractExtension
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('classnames', [$this, 'returnClasses']),
        ];
    }

	public function isEmpty($object)
	{
		foreach($object as $value) return false;
		return true;
	}

    public function returnClasses($name, $classTypesObject=null, $class=null)
    {
        if($classTypesObject==null){
            return $name;
        }
        elseif(is_array($classTypesObject)){
            foreach(array_keys($classTypesObject) as $key){
				if(is_object($classTypesObject[$key])){
					if($this->isEmpty($classTypesObject[$key])){
						$name .= ' ' . $key;
					}
				}
                elseif($classTypesObject[$key]===true){
                    $name .= ' ' . $key;
                }
            }
            return $name;
        }
        else{
            // $this->logger->emergency($name);
            return $name . ' ' . $classTypesObject . ' ' . $class;
        }
    }
}
?>
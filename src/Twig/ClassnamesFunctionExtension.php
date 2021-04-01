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

    public function returnClasses($name, $classTypesObject=null)
    {
        if($classTypesObject==null){
            return $name;
        }
        elseif(is_array($classTypesObject)){
            foreach(array_keys($classTypesObject) as $key){
                if(!$classTypesObject[$key]->count()){
                    $this->logger->emergency('ok');
                }
                if($classTypesObject[$key]===true){
                    $name .= ' ' . $key;
                }
            }
            // $this->logger->emergency($name);
            return $name;
        }
        else{
            // $this->logger->emergency($name);
            return $name . ' ' . $classTypesObject;
        }
    }
}
?>
<?php
namespace App\Twig;
use Symfony\Component\HttpFoundation\RequestStack;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class DataFunctionExtension extends AbstractExtension
{
    private $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function getFunctions()
    {
        return [new TwigFunction("data", [$this, "returnData"])];
    }

    public function returnData($name)
    {
        $path = $this->projectDir . "/public/assets/data/" . $name;
        $json = file_get_contents($path);
        $variable = json_decode($json);
        return $variable;
    }
}
?>

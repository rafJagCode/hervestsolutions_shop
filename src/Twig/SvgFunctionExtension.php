<?php
namespace App\Twig;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class SvgFunctionExtension extends AbstractExtension
{
    private $projectDir;

    public function __construct(string $projectDir)
    {
        $this->projectDir = $projectDir;
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('svg', [$this, 'returnPath']),
        ];
    }

    public function returnPath(string $name)
    {
        $path=$this->projectDir . '/assets/svg/' . $name;
        $svg = include($path);
		$final = substr($svg, 0, -1);
        return $final;
    }
}
?>
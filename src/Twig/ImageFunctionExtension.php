<?php
namespace App\Twig;
use Symfony\Component\HttpFoundation\RequestStack;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ImageFunctionExtension extends AbstractExtension
{
    private $projectDir;
    private $baseUrl;

    public function __construct(string $projectDir, RequestStack $requestStack)
    {
        $this->projectDir = $projectDir;
        if($requestStack->getCurrentRequest() === null){
            $this->baseUrl = null;
        }
        else{
            $this->baseUrl = $requestStack->getCurrentRequest()->getSchemeAndHttpHost();
        }
    }
    
    public function getFunctions()
    {
        return [
            new TwigFunction('image', [$this, 'returnPath']),
        ];
    }

    public function returnPath(string $name)
    {
        $path='@base_url/assets/' . $name;
        $asset = `asset($path)`;
        return $asset;
    }
}
?>
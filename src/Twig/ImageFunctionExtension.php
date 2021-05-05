<?php
namespace App\Twig;
use Symfony\Component\HttpFoundation\RequestStack;

use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class ImageFunctionExtension extends AbstractExtension
{
    private $baseUrl;

    public function __construct(RequestStack $requestStack)
    {
        if ($requestStack->getCurrentRequest() === null) {
            $this->baseUrl = null;
        } else {
            $this->baseUrl = $requestStack
                ->getCurrentRequest()
                ->getSchemeAndHttpHost();
        }
    }

    public function getFunctions()
    {
        return [new TwigFunction("image", [$this, "returnPath"])];
    }

    public function returnPath(string $name)
    {
        $path = $this->baseUrl . "/assets/" . $name;
        return $path;
    }
}
?>

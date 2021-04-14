<?php
namespace App\Twig;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

class BreadcrumbsFunctionExtension extends AbstractExtension
{
    public function getFunctions()
    {
        return [new TwigFunction("breadcrumbs", [$this, "breadcrumbs"])];
    }

    public function breadcrumbs($separator = " &raquo; ", $home = "Home")
    {
        $path = array_filter(
            explode("/", parse_url($_SERVER["REQUEST_URI"], PHP_URL_PATH))
        );

        // This will build our "base URL" ... Also accounts for HTTPS :)
        $base =
            (array_key_exists("HTTPS", $_SERVER) ? "https" : "http") .
            "://" .
            $_SERVER["HTTP_HOST"] .
            "/";

        // Initialize a temporary array with our breadcrumbs. (starting with our home page, which I'm assuming will be the base URL)
        $breadcrumbs = [(object) ["title" => $home, "url" => "/"]];

        // Find out the index for the last value in our path array

        // Build the rest of the breadcrumbs
        foreach ($path as $x => $crumb) {
            // Our "title" is the text that will be displayed (strip out .php and turn '_' into a space)
            $title = ucwords(str_replace([".php", "_"], ["", " "], $crumb));
            $url = "/" . strtolower($title);
            array_push(
                $breadcrumbs,
                (object) ["title" => $title, "url" => $url]
            );
        }

        // Build our temporary array (pieces of bread) into one big string :)

        return $breadcrumbs;
    }
}
?>

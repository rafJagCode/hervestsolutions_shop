<?php
namespace App\Service;
use Symfony\Component\HttpFoundation\Request;

class AuthChecker
{
    public function isUserAuthenticated(Request $request)
    {
        $authToken = $request->cookies->get("X-AUTH-TOKEN");
        return $authToken ? true : false;
    }
}
?>

<?php
namespace App\Service;
use Symfony\Component\HttpFoundation\Request;

class AuthChecker
{
    private $jwtDecoder;

    public function __construct(JwtDecoder $jwtDecoder)
    {
        $this->jwtDecoder = $jwtDecoder;
    }

    public function isUserAuthenticated(Request $request)
    {
        $authToken = $request->cookies->get("X-AUTH-TOKEN");
        return $authToken ? true : false;
    }

    public function getRole($request)
    {
        $authToken = $request->cookies->get("X-AUTH-TOKEN");
        $role = $this->jwtDecoder->getPayload($authToken)->roles;
        return $role[0];
    }
}
?>

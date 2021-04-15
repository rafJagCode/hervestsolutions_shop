<?php
namespace App\Service;
use Symfony\Contracts\HttpClient\HttpClientInterface;
use Exception;

class JwtDecoder
{
    public function getPayload($token)
    {
        try {
            $tokenParts = explode(".", $token);
            $tokenPayload = base64_decode($tokenParts[1]);
            $jwtPayload = json_decode($tokenPayload);
        } catch (Exception $exception) {
            throw $exception;
        }

        return $jwtPayload;
    }
}
?>

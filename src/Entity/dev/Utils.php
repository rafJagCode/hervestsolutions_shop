<?php
namespace App\Utils;
class Utils
{
    public function getStatusCodeMessage(int $statusCode)
    {
        if ($statusCode === 200) {
            $message = "Logged successfully";
        } elseif ($statusCode === 401) {
            $message = "Provided credentials were invalid";
        } elseif ($statusCode === 500) {
            $message = "Internal server error";
        } else {
            $message = "Something went wrong, please contact with support";
        }
        return $message;
    }
}

?>

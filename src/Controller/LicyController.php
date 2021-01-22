<?php


namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;


class LicyController
{
    /**
    +      * @Route("/lucky/number")
    +      */
    public function number()
    {
        phpinfo();
    }

}
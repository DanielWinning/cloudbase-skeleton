<?php

declare(strict_types=1);

namespace CloudBase\Skeleton\Controller;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PluginController
{
    #[Route('/my-plugin')]
    public function index(): Response
    {
        return new Response('My Plugin Index');
    }
}

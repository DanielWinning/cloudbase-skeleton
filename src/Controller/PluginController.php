<?php

declare(strict_types=1);

namespace CloudBase\Skeleton\Controller;

use CloudBase\PluginCore\Controller\CloudBaseController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class PluginController extends CloudBaseController
{
    #[Route('/my-plugin')]
    public function index(): Response
    {
        return $this->renderedLatteResponse('@cloudbase/skeleton/index');
    }
}

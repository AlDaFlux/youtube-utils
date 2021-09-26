<?php

namespace Aldaflux\YoutubeUtilsBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class DefaultController extends Controller
{
    /**
     * @Route("/youtube_test")
     */
    public function indexAction()
    {
        return $this->render('AldafluxYoutubeUtils/Default/index.html.twig');
    }
    
    
}


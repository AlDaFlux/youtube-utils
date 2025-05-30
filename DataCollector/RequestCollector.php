<?php

namespace Aldaflux\YoutubeUtilsBundle\DataCollector;

use Symfony\Component\HttpKernel\DataCollector\DataCollector;
use Symfony\Component\HttpKernel\DataCollector\DataCollectorInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\DependencyInjection\ContainerInterface;



use Aldaflux\YoutubeUtilsBundle\Utils\ServiceApiYoutube;


class RequestCollector extends DataCollector implements DataCollectorInterface
{
    
//    private $container;
    private $youtubeService;

    /**
     * Constructor.
     *
      */
    public function __construct(ServiceApiYoutube $youtubeService, ContainerInterface $container)
    {
        $this->youtubeService = $youtubeService;
    }   
    
    
     public function collect(Request $request, Response $response, \Throwable $exception = null) : void
    {
         $this->data = [
            'logs' => $this->youtubeService->getLogs(), 
            'errorLogs' => $this->youtubeService->getErrorLogs(),
            'method' => $request->getMethod(),
            'acceptable_content_types' => $request->getAcceptableContentTypes(),
        ];
    }

    public function reset() : void
    {
        $this->data = [];
    }
   
    public function getName() :string
    {
        return 'aldaflux_youtube_utils.request_collector';
    }

 public function getMethod()
    {
        return $this->data['method'];
    }

     public function getLogs()
    {
        return $this->data['logs'];
    }

     public function getNbLogs()
    {
        return count($this->data['logs']);
    }
    
    public function getErrorLogs()
    {
        return $this->data['errorLogs'];
    }

     public function getNbErrorLogs()
    {
        return count($this->data['errorLogs']);
    }

    public function getAcceptableContentTypes()
    {
        return $this->data['acceptable_content_types'];
    }
    
     
}
<?php



namespace Aldaflux\YoutubeUtilsBundle\Utils;

use Psr\Log\LoggerInterface;

use  Aldaflux\YoutubeUtilsBundle\Utils\ApiYoutube;
use  Aldaflux\YoutubeUtilsBundle\Utils\ApiYoutubeVideo;
use  Aldaflux\YoutubeUtilsBundle\Utils\ServiceApiYoutube;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;



class ApiYoutubeService 
{
    
    private $params;
    private $logger;
    private $serviceApiYoutube;

    public function __construct(ServiceApiYoutube $serviceApiYoutube,ParameterBagInterface $params,LoggerInterface $logger)
    {
        $this->params = $params;
        $this->logger = $logger;
        $this->serviceApiYoutube = $serviceApiYoutube;
    }

    
    function getVideo($code_youtube)
    {
        $video=new ApiYoutubeVideo ($this->serviceApiYoutube,$code_youtube);
        
        /*
        $this->logger->info('I just got the logger');
        $this->logger->error('An error occurred');
        $this->logger->critical('I left the oven on!', [
        // include extra "context" info in your logs
        'cause' => 'in_hurry',
    ]);
    */
        /*
        $container->get('logger')->error('There was an error on the API call.', array(
    'description' => $response->errors[0]->description
);*/
        return($video);
    }
    
    function getChannel($channelId)
    {
        $channel=new ApiYoutubeChannel ($this->serviceApiYoutube,$channelId);
        return($channel);
    }
    
    function getPlaylist($playlistId)
    {
        $playlist=new ApiYoutubePlaylist ($this->serviceApiYoutube,$playlistId);
        return($playlist);
    }
    
    

    public function getYoutubeIdFromUrl($url)
    {
        preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $url, $match);
        if (count($match)>1)
        {
            return($match[1]);
        }
    }
        
    
}


        
        





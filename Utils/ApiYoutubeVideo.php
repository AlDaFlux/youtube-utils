<?php



namespace Aldaflux\YoutubeUtilsBundle\Utils;

use Symfony\Component\Debug\Exception\FatalThrowableError;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;


use Aldaflux\YoutubeUtilsBundle\Utils\ApiYoutube;
use Aldaflux\YoutubeUtilsBundle\Utils\ServiceApiYoutube;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use Symfony\Component\PropertyAccess\PropertyAccess;



class ApiYoutubeVideo
{
    private $videoId;
    private $snippet;
    private $status;
    private $statistics;
    
    private $youtubeApiKey;
    private $videoJson;
    
    
    
    
 public function __debugInfo() 
     { 
         $properties = [ 
             'videoId' => $this->GetVideoId(),
             'title' => $this->GetTitle(),
             'description' => $this->GetDescription(),
             'thumbnail' => $this->GetThumbnail(),
             'publishedAt' => $this->GetPublishedAt()->format('Y-m-d H:i:s.u'),
             'channelId' => $this->GetChannelId(),
             'channelTitle' => $this->GetChannelTitle(),
             'status' => $this->GetStatus(),
             'viewCount' => $this->GetViewCount(),
         ];
        return $properties; 
     }
     
    
    public function __construct(ServiceApiYoutube $youtubeService,$videoId)
    {
        $this->videoId = $videoId;
        
        $youtubeService->config("videos", "id=".$this->videoId."&fields=items(id,snippet,status,statistics)","snippet,status,statistics");
        
        $videoJson=$youtubeService->GetOneItemJson();
        
        if ($videoJson)
        {
            $this->snippet=$videoJson->snippet;
            $this->status=$videoJson->status;
            $this->statistics=$videoJson->statistics;
        }
        else
        {
            throw new NotFoundHttpException("video ".$videoId." dont exist");
        }
    }
    
    
    public function GetSnippet()
    {
        return($this->snippet);
    }

    public function GetStatus()
    {
        return($this->status);
    }

    public function GetStatistics()
    {
        return($this->statistics);
    }

    
    public function GetPrivacyStatus()
    {
        return($this->GetStatus()->privacyStatus);
    }

    public function IsPrivate()
    {
        return($this->GetStatus()->privacyStatus=="private");
    }
    public function IsPublic()
    {
        return($this->GetStatus()->privacyStatus=="public");
    }
    
    public function IsUnlisted()
    {
        return($this->GetStatus()->privacyStatus=="unlisted");
    }
    

    
    
    
    public function GetVideoId()
    {
        return($this->videoId);
    }
     
    public function GetTitle()
    {
        return($this->GetSnippet()->title);
    }
    
    public function GetDescription()
    {
        return($this->GetSnippet()->description);
    }
    
    
    
    
    public function GetPublishedAt()
    {
        $date=New \DateTime($this->GetSnippet()->publishedAt);
        return($date);
    }
    
    public function GetChannelId()
    {
        return($this->GetSnippet()->channelId);
    }
    
    public function GetChannelTitle()
    {
        return($this->GetSnippet()->channelTitle);
    }
    
    
    public function GetThumbnail($size="default")
    {
        return($this->GetSnippet()->thumbnails->{$size}->url);
    }
    
    
    
    
    public function GetViewCount()
    {
        return($this->GetStatistics()->viewCount);
    }
    
    
    
    
    
    
    
    
    
    
}


        
        





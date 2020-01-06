<?php



namespace Aldaflux\YoutubeUtilsBundle\Utils;


use  Aldaflux\YoutubeUtilsBundle\Utils\ApiYoutube;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use Symfony\Component\PropertyAccess\PropertyAccess;



class ApiYoutubeChannel
{
    private $channel;
    private $channelId;

    private $snippet;
    
    private $json;
    private $youtubeService;
    

 public function __debugInfo() 
     { 
         $properties = [ 
             'channelId' => $this->GetChannelId(),
             'title' => $this->GetTitle(),
             'decription' => $this->GetDescription(),
             'publishedAt' => $this->GetPublishedAt()->format('Y-m-d H:i:s.u'),
             'debugUrl' => $this->channel->GetUrl(),
             'uploadPlaylistId' => $this->GetUploadPlaylistId(),
             'uploadPlaylist' => $this->GetUploadPlaylist(),
         ];
        return $properties; 
     }
     
    
    public function __construct(ServiceApiYoutube $youtubeService,$channelId)
    {
        $this->channelId = $channelId;
        $youtubeService->config("channels", "id=".$this->channelId,"contentDetails,snippet");
        $this->json=$youtubeService->GetOneItemJson();
        $this->youtubeService=$youtubeService;
    }
    
    
    public function GetYoutubeApiKey()
    {
        return($this->youtubeApiKey);
    }

    
    
    public function GetSnippet()
    {
        return($this->json->snippet);
    }
    public function GetContentDetails()
    {
        return($this->json->contentDetails);
    }
    

    public function GetChannelId()
    {
        return($this->channelId);
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
       
    public function GetThumbnail($size="default")
    {
        return($this->GetSnippet()->thumbnails->{$size}->url);
    }
    
    public function GetUploadPlaylistId()
    {
        return($this->GetContentDetails()->relatedPlaylists->uploads);
    }

    
    public function GetUploadPlaylist()
    {
        return(new ApiYoutubePlaylist($this->youtubeService, $this->GetUploadPlaylistId()));
    }
    
    public function GetVideos()
    {
        return ($this->GetUploadPlaylist()->GetVideos());
    }

    
    
    
    
    
    
    
    
    
    
    
    
    
}


        
        





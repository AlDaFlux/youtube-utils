<?php



namespace Aldaflux\YoutubeUtilsBundle\Utils;


use Doctrine\Common\Collections\ArrayCollection;

use  Aldaflux\YoutubeUtilsBundle\Utils\ApiYoutube;

use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

use Symfony\Component\PropertyAccess\PropertyAccess;



class ApiYoutubePlaylist
{
    private $playlist;
    private $playlistId;

    private $snippet;

    private $youtubeService;

    
    private $json;
    

 public function __debugInfo() 
     { 
         $properties = [ 
             'playlistId' => $this->GetPlaylistId(),
             'title' => $this->GetTitle(),
             'decription' => $this->GetDescription(),
             'debugUrl' => $this->playlist->GetUrl(),
             'debugVideosUrl' => $this->GetVideosUrl(),
         ];
        return $properties; 
     }
     
    
    public function __construct(ServiceApiYoutube $youtubeService,$playlistId)
    {
        $this->playlistId = $playlistId;
        $youtubeService->config("playlists", "id=".$this->playlistId,"contentDetails,snippet");
        $this->youtubeService=$youtubeService;
        $this->json=$youtubeService->GetOneItemJson();

    }
    
    
    public function GetVideosUrl()
    {
        $this->playlistItems=new ApiYoutube ($this->youtubeApiKey,"playlistItems", "playlistId=".$this->playlistId,"contentDetails,snippet");
        return($this->playlistItems->GetUrl());
    }
    
    public function GetVideos()
    {
        $videos=new ArrayCollection();
//        $this->playlistItems=new ApiYoutube ($this->youtubeApiKey,);
        $this->youtubeService->config("playlistItems", "playlistId=".$this->playlistId,"contentDetails,snippet");
        foreach ($this->youtubeService->GetJson()->items as $jsonVideo)
        {
            $videos->Add(new ApiYoutubeVideo($this->youtubeService, $jsonVideo->snippet->resourceId->videoId));
        }
        return($videos);
    }
    
    public function GetYoutubeApiKey()
    {
        return($this->youtubeApiKey);
    }
    
    
   
    public function GetSnippet()
    {
        return($this->json->snippet);
    }

    public function GetPlaylistId()
    {
        return($this->playlistId);
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
        $date=New \DateTime($this->snippet->publishedAt);
        return($date);
    }
       
    public function GetThumbnail($size="default")
    {
        return($this->GetSnippet()->thumbnails->{$size}->url);
    }
    
    
    
    
    
    
    
    
    
    
}


        
        





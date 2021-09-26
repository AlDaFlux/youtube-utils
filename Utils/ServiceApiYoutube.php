<?php



namespace Aldaflux\YoutubeUtilsBundle\Utils;

use Symfony\Component\Debug\Exception\FatalThrowableError;


use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;



class ServiceApiYoutube 
{
    protected static  $logs = array();
    protected static  $errorlogs = array();

    
    public $AccessToken;
	public $PageToken;
	public $RefreshToken;
	public $TypeRecherche;
	public $CritereRecherche;
	public $RechercheId;
	public $maxResults=50;
	public $Part;
	private $Fields;
	private $PostURL;
	private $pagination;
        private $Occurence;
        private $apiKey;
	const URLAPI="https://www.googleapis.com/youtube/";
	const VERSION="v3";


    public function __construct(ParameterBagInterface $params)
    {
        if ($params->has("youtube_api_key"))
        {
            $this->apiKey = $params->get("youtube_api_key");
        }
        else
        {
            self::$errorlogs[]="youtube_api_key is not set";
        }
    }
    
        
    public function config($TypeRecherche,$CritereRecherche,$Part=null)
    {
        $this->TypeRecherche = $TypeRecherche;
        $this->CritereRecherche = $CritereRecherche;
        $this->Part = $Part;
    }
        
    public function getLogs()
    {
        return self::$logs;
    }
    public function getErrorLogs()
    {
        return self::$errorlogs;
    }
    

    
    
	
	public function ApplyAllElementsFonction($function)
	{ 
		$i=0;
		$this->pagination=true;
		do 
		{
			$i++;
			$resultat=self::GetJson($nextpagetoken);
			foreach ($resultat->items as $item)
			{
                            
				$function($item);
			}
			$nextpagetoken=($resultat->nextPageToken);
		}while ($nextpagetoken);
		return($i);
	}
	
	public function ApplyAllElementsFonctionsUntilDate($function,$date)
	{
		$i=1;
		$this->pagination=true;
		do 
		{
			$resultat=self::GetJson($nextpagetoken);
			if ((strtotime($item->{$this->Part}->publishedAt)<$date)) 
			{
				$function($item);	
			}
			else return(0);
			
			$nextpagetoken=($resultat->nextPageToken);
		}while ($nextpagetoken);
	}
	
	public function ApplyAllElementsFonctionFromDate($function,$date)
	{
		$i=1;
		$this->pagination=true;
		do 
		{
			$resultat=self::GetJson($nextpagetoken);
			foreach ($resultat->items as $item)
			{
				if ((strtotime($item->{$this->Part}->publishedAt)>$date)) 
				{
					$function($item);	
				}
				else return(0);
			}
			
			$nextpagetoken=($resultat->nextPageToken);
		}while ($nextpagetoken);
	}
	
	
	
	
	
	public function GetUrl()
	{
			global $ipresolve;
			$url=self::URLAPI.self::VERSION."/".$this->TypeRecherche."?part=".$this->Part."&".$this->CritereRecherche.self::GetFields()."&key=".$this->apiKey."&".$this->PostURL;
			if ($this->AccessToken)  $url.="&access_token=".$this->AccessToken;
			if ($this->maxResults) $url.="&maxResults=".$this->maxResults;
			if ($this->PageToken) $url.="&pageToken=".$this->PageToken;
			//			debug(explode("&",$url));
			return ($url);
                        
	}
	

	function GetFields()
	{
		
		if ($this->Fields)
		{
			if ($this->pagination) return("&fields=nextPageToken,".$this->Fields);
			else return("&fields=".$this->Fields);	
		}
	}
	
	function SetFields($Fields)
	{
		$this->Fields = $Fields;
	}

	function SetpostURL($PostURL)
	{
		$this->PostURL = $PostURL;
	}
	
	
	function GetJson($PageToken='')
	{
		$url=self::GetUrl();
                
//                dump($url);
                
		if ($PageToken) $url.="&pageToken=".$PageToken;
         	$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result=json_decode(curl_exec($curl));
                
                $log=array();
                //$log["codeYoutube"]=$code_youtube;
                $log["url"]=$url;
                $log["result"]=$result;
                $log["type"]=$this->TypeRecherche;
                //$log["id"]=$this->if;
                self::$logs[]=$log; 
                
                
                if (isset($result->error))
                {
                    self::$errorlogs[]=$result->error;
                }
                
                
                
		curl_close($curl);
		return ($result);
	}	
 
	function GetOneItemJson($PageToken='')
	{
            if (isset(self::GetJson($PageToken)->items[0]))
            {
    		return(self::GetJson($PageToken)->items[0]);
            }
            else
            {
                dump("EXISTE PAS !!  :".self::GetUrl());
            }
	}	
	
	function totalResults()
	{
		$url=self::URLAPI.self::VERSION."/".$this->TypeRecherche."?part=".$this->Part."&".$this->CritereRecherche."&fields=pageInfo&key=".$this->apiKey."&".$this->PostURL;
		if ($this->AccessToken)  $url.="&access_token=".$this->AccessToken;
		$url.="&maxResults=0";
		$curl = curl_init($url);
		curl_setopt($curl, CURLOPT_HEADER, 0);
		curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
		$result=json_decode(curl_exec($curl));
		return ($result->pageInfo->totalResults);
		curl_close($curl);
	}
	
	
	function SetAcessToken($AccessToken)
	{
		$this->AccessToken=$AccessToken;
	}	
	/*
	function GetAcessToken($AccessToken)
	{
		$this->AccessToken=$AccessToken;
		//$_SESSION["accounts_api"]['google']['access_token']
	}	
	*/
}
/*
class my_youtube_v3_access_token extends my_youtube_v3
{
	function my_youtube_v3_access_token($TypeRecherche,$CritereRecherche,$Part,$AccessToken)
	{
		self::my_youtube_v3($TypeRecherche,$CritereRecherche,$Part);
		self::SetAcessToken($AccessToken);	
	}
	
}


class my_youtube_v3_user_subscriptions extends my_youtube_v3
{
	function my_youtube_v3_user_subscriptions($code_user_youtube,$access_token='')
	{
		self::my_youtube_v3("subscriptions","channelId=".$code_user_youtube,"snippet,subscriberSnippet");
		self::SetFields("items(subscriberSnippet(channelId),snippet(resourceId(channelId),publishedAt))");
		self::SetAcessToken($access_token);	
	}
	
	function CanGetSuscribes()
	{
		$result=self::GetJson();
		if ($result->error->code==403) return(false);
		else return (true);
	} 
        
	public function GetPlaylists()
	{
		$result=self::GetJson();
		//debug($result);
		return($result->items[0]->contentDetails->relatedPlaylists);
	}
} 

   

class my_youtube_v3_playlist_videos extends my_youtube_v3
{
	function my_youtube_v3_playlist_videos ($code_playlist)
	{
		self::my_youtube_v3("playlistItems","playlistId=".$code_playlist,"snippet");
		self::SetFields("items(snippet(playlistId,resourceId(videoId),title,channelId,channelTitle,publishedAt,position))");
	}
	function NbVideos()
	{
		return(self::totalResults());
	}
        
        public function IsNotFound()
	{
                return($this->GetJson()->error->errors[0]->reason=='playlistNotFound');
        }
	
} 

class my_youtube_v3_playlist 
{
	public $playlist_videos;
	public $playlist_info;
	
	function my_youtube_v3_playlist  ($code_playlist)
	{
		$code_playlist=trim($code_playlist);
		
		$this->playlist_videos= new my_youtube_v3_playlist_videos($code_playlist);
		$this->playlist_info= new my_youtube_v3("playlists","id=".$code_playlist,"snippet,status");
		$this->playlist_info->SetFields("pageInfo,items(status,snippet(channelTitle,title,channelId,title,publishedAt,description,thumbnails(default(url))))");
	}
        
	function IsNotFound()
	{
		return($this->playlist_videos->IsNotFound());
        }
	
	function GetMetas()
	{
		$metas=$this->playlist_info->GetOneItemJson();
                
                
		$status=$metas->status->privacyStatus;
		
		$metas=$metas->snippet;
		$metas->status=$status;
		
//		$metas=$this->playlist_info->GetOneItemJson()->snippet;
		
		$metas->thumbnail_url=$metas->thumbnails->default->url;
		unset ($metas->thumbnails);
		return($metas);
	}
	
	function AfficheVideos()
	{
		$this->playlist_videos->ApplyAllElementsFonction('affiche_one_video_from_snippet');
	}
	
	function NbVideos()
	{
		return($this->playlist_videos->NbVideos());
	}
} 


class my_youtube_v3_user_playlists extends my_youtube_v3
{
	function my_youtube_v3_user_playlists($code_user_youtube)
	{
		self::my_youtube_v3("playlists","channelId=".$code_user_youtube,"status,id,snippet");
		self::SetFields("items(status,id,snippet(title,description,channelId,publishedAt,thumbnails(default(url))))");
	}
	
	function GetPlaylists()
	{
		return(self::GetJson());
	}
               
        public function IsNotFound()
	{
                return($this->GetJson()->error->errors[0]->reason=='channelNotFound');
        }
 * 
 */
        







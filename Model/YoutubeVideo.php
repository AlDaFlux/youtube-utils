<?php



namespace Aldaflux\YoutubeUtilsBundle\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 */
class YoutubeVideo 
{

    

    
    /**
     * @var string|null
     *
     * @ORM\Column(name="title", type="string", nullable=true)
     */
    protected  $title;

    
    
    /**
     * @var string|null
     *
     * @ORM\Column(name="content", type="text", nullable=true)
     */
    private $content;


    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_publication", type="datetimetz", nullable=true)
     */
    private $datePublication;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_creation", type="date", nullable=true, options={"default"="now()"})
     */
    private $dateCreation = 'now()';

    /**
     * @var string|null
     *
     * @ORM\Column(name="code_user_youtube", type="string", length=22, nullable=true, options={"fixed"=true})
     */
    private $codeUserYoutube;

    /**
     * @var string|null
     *
     * @ORM\Column(name="user_youtube", type="string", nullable=true)
     */
    private $userYoutube;
    
    

    /**
     * @var string|null
     *
     * @ORM\Column(name="type_video", type="string", length=3, nullable=true, options={"fixed"=true})
     */
    private $typeVideo;

    /**
     * @var float|null
     *
     * @ORM\Column(name="type_video_prob", type="float", precision=10, scale=0, nullable=true)
     */
    private $typeVideoProb;

    /**
     * @var int|null
     *
     * @ORM\Column(name="duration", type="integer", nullable=true)
     */
    private $duration;

    /**
     * @var int|null
     *
     * @ORM\Column(name="viewcount", type="bigint", nullable=true)
     */
    private $viewCount;

    /**
     * @var float|null
     *
     * @ORM\Column(name="average", type="float", precision=10, scale=0, nullable=true)
     */
    private $average;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_lastmaj_meta", type="date", nullable=true)
     */
    private $dateLastmajMeta;

    /**
     * @var \DateTime|null
     *
     * @ORM\Column(name="date_lastmaj_meta_stats", type="date", nullable=true)
     */
    private $dateLastmajMetaStats;

    /**
     * @var string|null
     *
     * @ORM\Column(name="privacystatus", type="string", nullable=true)
     */
    private $privacyStatus;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_accessible", type="boolean", nullable=false, options={"default"="1"})
     */
    private $isAccessible = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_accessible_fr", type="boolean", nullable=false, options={"default"="1"})
     */
    private $isAccessibleFr = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_public", type="boolean", nullable=false, options={"default"="1"})
     */
    private $isPublic = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_notdeleted", type="boolean", nullable=false, options={"default"="1"})
     */
    private $isNotdeleted = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_notrejected", type="boolean", nullable=false, options={"default"="1"})
     */
    private $isNotrejected = true;

    /**
     * @var bool
     *
     * @ORM\Column(name="is_embeddable", type="boolean", nullable=false, options={"default"="1"})
     */
    private $isEmbeddable = true;


    /**
     * @var int|null
     *
     * @ORM\Column(name="likecount", type="bigint", nullable=true)
     */
    private $likeCount;

    /**
     * @var int|null
     *
     * @ORM\Column(name="dislikecount", type="bigint", nullable=true)
     */
    private $dislikeCount;

    


    /**
    * {@inheritdoc}
    */
    public function createVideo()
    {
        $class = $this->getClass();
        $video = new $class();
        return $video;
    }
    

    
    
}

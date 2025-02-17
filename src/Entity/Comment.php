<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\DateTime;

#[ORM\Entity] 
#[ORM\Table(name: 'comment')]

class Comment
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\Column(type:'integer', name:'idComment')]
	private $idComment;

	#[ORM\OneToOne(targetEntity: Profile::class)]
    #[ORM\JoinColumn(name: 'idUser', referencedColumnName: 'idUser')]
    private $idUser;

	#[ORM\ManyToOne(targetEntity: Post::class)]
    #[ORM\JoinColumn(name: 'commPost', referencedColumnName: 'idPost')]
	private $commPost;
	
	#[ORM\Column(type:'string', name:'content')]
	private $content;
	
	#[ORM\Column(type:'integer', name:'likes')]
	private $likes;
	
	#[ORM\Column(type:'integer', name:'dislikes')]
	private $dislikes;

	#[ORM\Column(type:'datetime_immutable', name:'postingTime')]
	private $postingTime;
	
	#[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'allComments')]
    #[ORM\JoinColumn(name: 'commComment', referencedColumnName: 'idComment', nullable: true)]
	private $commComment = null;
	
	#[ORM\OneToMany(targetEntity: self::class, mappedBy: 'commComment')]
	private Collection $allComments;
	
    public function __construct() {
        $this->allComments = new ArrayCollection();
    }

//-----------------------------------------------------------

	public function getIdComment() : ?int {
		return $this->idComment;
	}
	public function setIdComment(?int $idComment) {
		$this->idComment = $idComment;
	}

	public function getProfileUser() : ?Profile {
		return $this->idUser;
	}
	public function setProfileUser(?Profile $idUser) {
		$this->idUser = $idUser;
	}

	public function getCommPost() : ?Post {
		return $this->commPost;
	}
	public function setCommPost(?Post $commPost) {
		$this->commPost = $commPost;
	}

	public function getCommComment() : ?Comment {
		return $this->commComment;
	}
	public function setCommComment(?Comment $commComment) {
		$this->commComment = $commComment;
	}

	public function getContent() : ?string {
		return $this->content;
	}
	public function setContent(?string $content) {
		$this->content = $content;
	}

	public function getLikes() : ?int {
		return $this->likes;
	}
	public function setLikes(?int $likes) {
		$this->likes = $likes;
	}

	public function getDislikes() : ?int {
		return $this->dislikes;
	}
	public function setDislikes(?int $dislikes) {
		$this->dislikes = $dislikes;
	}

	public function getPostingTime() : \DateTimeImmutable {
		return $this->postingTime;
	}
	public function setPostingTime(\DateTimeImmutable $postingTime) {
		$this->postingTime = $postingTime;
	}

//-----------------------------------------------------------

	function toArray() {

		$returned = [
            'idComment' => $this->idComment,
            'content' => $this->content,
            'likes' => $this->likes,
            'dislikes' => $this->dislikes,
            'postingTime' => $this->postingTime,
			
            'idUser' => $this->idUser->toArray(),
            'commPost' => $this->commPost->getIdPost(),
        ];

		if ($this->commComment) {
			$returned['commComment'] = $this->commComment->getIdComment();
		}else{
			$returned['commComment'] = null;
		}

		$returned['allComments'] = array_map(fn($comment) => $comment->toArray(), $this->allComments->toArray());
		
		return $returned;
	}

	function getCommentInfoForAJAX() {
		return [
			'idComment' => $this->idComment,
			'content' => $this->content,
			'likes' => $this->likes,
			'dislikes' => $this->dislikes,
			'postingTime' => $this->postingTime,
			'Profile' => $this->idUser->toArray(),
			'commComment' => $this->commComment ? $this->commComment->getCommentInfoForAJAX() : null,
		];
	}
}

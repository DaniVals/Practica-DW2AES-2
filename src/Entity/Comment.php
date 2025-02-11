<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;

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
        $this->allComments = new Collection();
    }

//-----------------------------------------------------------

	public function getIdComment() {
		return $this->idComment;
	}
	public function setIdComment($idComment) {
		$this->idComment = $idComment;
	}

	public function getIdUser() {
		return $this->idUser;
	}
	public function setIdUser($idUser) {
		$this->idUser = $idUser;
	}

	public function getCommPost() {
		return $this->commPost;
	}
	public function setCommPost($commPost) {
		$this->commPost = $commPost;
	}

	public function getCommComment() {
	// public function getCommComment() : ?Comment {
		return $this->commComment;
	}
	public function setCommComment($commComment) {
		$this->commComment = $commComment;
	}

	public function getContent() {
		return $this->content;
	}
	public function setContent($content) {
		$this->content = $content;
	}

	public function getLikes() {
		return $this->likes;
	}
	public function setLikes($likes) {
		$this->likes = $likes;
	}

	public function getDislikes() {
		return $this->dislikes;
	}
	public function setDislikes($dislikes) {
		$this->dislikes = $dislikes;
	}

	public function getPostingTime() {
		return $this->postingTime;
	}
	public function setPostingTime($postingTime) {
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
}

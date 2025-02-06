<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity] 
#[ORM\Table(name: 'post')]

class Post
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
	#[ORM\OneToMany(targetEntity: Comment::class, mappedBy: 'commPost')]
	#[ORM\Column(type:'integer', name:'idPost')]
	private $idPost;

	#[ORM\Column(type:'integer', name:'likes')]
	private $likes;

	#[ORM\Column(type:'integer', name:'dislikes')]
	private $dislikes;

	#[ORM\Column(type:'datetime_immutable', name:'postingTime')]
	private $postingTime;

	#[ORM\Column(type:'integer', name:'commentAmount')]
	private $commentAmount;

	#[ORM\Column(type:'string', name:'contentRoute')]
	private $contentRoute;

	#[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'idUser')]
	#[ORM\JoinColumn(name: 'idPoster', referencedColumnName: 'idUser')]
	private $PosterUser;

//-----------------------------------------------------------

	public function getIdPost() : ?int {
		return $this->idPost;
	}
	public function setIdPost(?int $idPost) {
		$this->idPost = $idPost;
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

	public function getPostingTime() : ?int {
		return $this->postingTime;
	}
	public function setPostingTime($postingTime) {
		$this->postingTime = $postingTime;
	}

	public function getCommentAmount() : ?int {
		return $this->commentAmount;
	}
	public function setCommentAmount(?int $commentAmount) {
		$this->commentAmount = $commentAmount;
	}

	public function getContentRoute() : ?string {
		return $this->contentRoute;
	}
	public function setContentRoute(?string $contentRoute) {
		$this->contentRoute = $contentRoute;
	}
	
	public function getPosterUser() : ?User {
		return $this->PosterUser;
	}
	public function setPosterUser(?User $PosterUser) {
		$this->PosterUser = $PosterUser;
	}

//-----------------------------------------------------------

	public function toArray() : array {
        return [
            'idPost' => $this->idPost,
            'PosterUser' => $this->PosterUser->getProfile()->toArray(),
            'likes' => $this->likes,
            'dislikes' => $this->dislikes,
            'postingTime' => $this->postingTime,
            'commentAmount' => $this->commentAmount,
            'contentRoute' => $this->contentRoute,
        ];
	}

	public function getPostInfoForAJAX() {
		return [
			'idPost' => $this->idPost,
			'PosterUser' => $this->PosterUser->getProfile()->toArray(false),
			'likes' => $this->likes,
			'dislikes' => $this->dislikes,
			'postingTime' => $this->postingTime,
			'commentAmount' => $this->commentAmount,
			'contentRoute' => $this->contentRoute,
		];
	}
}

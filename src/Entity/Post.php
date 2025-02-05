<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity] 
#[ORM\Table(name: 'post')]

class Post
{
	#[ORM\Id]
    #[ORM\Column(type:'integer', name:'idPost')]
    #[ORM\GeneratedValue]
    private $idPost;
	
	#[ORM\ManyToOne(targetEntity: User::class, mappedBy: 'idUser')]
    #[ORM\JoinColumn(name: 'idPoster', referencedColumnName: 'idUser')]
    private $idPoster;

	#[ORM\Column(type:'integer', name:'likes')]
    private $likes;

	#[ORM\Column(type:'integer', name:'dislikes')]
    private $dislikes;

	#[ORM\Column(type:'Types::DATETIME_IMMUTABLE', name:'postingTime')]
    private $postingTime;

	#[ORM\Column(type:'integer', name:'commentAmount')]
    private $commentAmount;

	#[ORM\Column(type:'string', name:'contentRoute')]
    private $contentRoute;

//-----------------------------------------------------------

	public function getIdPost() {
		return $this->idPost;
	}
	public function setIdPost($idPost) {
		$this->idPost = $idPost;
	}

	public function getIdPoster() {
		return $this->idPoster;
	}
	public function setIdPoster($idPoster) {
		$this->idPoster = $idPoster;
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

	public function getCommentAmount() {
		return $this->commentAmount;
	}
	public function setCommentAmount($commentAmount) {
		$this->commentAmount = $commentAmount;
	}

	public function getContentRoute() {
		return $this->contentRoute;
	}
	public function setContentRoute($contentRoute) {
		$this->contentRoute = $contentRoute;
	}
}
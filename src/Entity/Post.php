<?php

namespace App\Entity;

use DateTime;
use DateTimeImmutable;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\EntityManagerInterface;

#[ORM\Entity] 
#[ORM\Table(name: 'post')]

class Post
{
	#[ORM\Id]
	#[ORM\GeneratedValue]
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

	#[ORM\ManyToOne(targetEntity: Profile::class, inversedBy: 'posts')]
	#[ORM\JoinColumn(name: 'idPoster', referencedColumnName: 'idUser')]
	private $PosterProfile;

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

	public function getPostingTime() : ?DateTimeImmutable {
		return $this->postingTime;
	}
	public function setPostingTime(?DateTimeImmutable $postingTime) {
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
	
	public function getPosterProfile() : ?Profile {
		return $this->PosterProfile;
	}
	public function setPosterProfile(?Profile $PosterProfile) {
		$this->PosterProfile = $PosterProfile;
	}

//-----------------------------------------------------------

	public function recountComments(EntityManagerInterface $entityManager) {
		$comments = $entityManager->getRepository(Comment::class)->findBy(['commPost' => $this]);
		$this->commentAmount = count($comments);
		$entityManager->persist($this);
		$entityManager->flush();
	}

	public function toArray(?bool $fullProfile = true) : array {
        return [
            'idPost' => $this->idPost,
            'PosterUser' => $this->PosterProfile->toArray(),
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
			'PosterUser' => $this->PosterProfile->toArray(),
			'likes' => $this->likes,
			'dislikes' => $this->dislikes,
			'postingTime' => $this->postingTime,
			'commentAmount' => $this->commentAmount,
			'contentRoute' => $this->contentRoute,
		];
	}
}

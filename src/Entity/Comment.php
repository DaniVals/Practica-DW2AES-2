<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity] 
#[ORM\Table(name: 'comment')]

class Comment
{
	#[ORM\Id]
    #[ORM\Column(type:'integer', name:'idComment')]
    #[ORM\GeneratedValue]
    private $idComment;

	#[ORM\Column(type:'integer', name:'commentedPost')]
    private $commentedPost;

	#[ORM\Column(type:'integer', name:'commentedComment')]
    private $commentedComment;

	#[ORM\Column(type:'string', name:'content')]
    private $content;

	#[ORM\Column(type:'integer', name:'likes')]
    private $likes;

	#[ORM\Column(type:'integer', name:'dislikes')]
    private $dislikes;

	#[ORM\Column(type:'Types::DATETIME_IMMUTABLE', name:'postingTime')]
    private $postingTime;

//-----------------------------------------------------------

	public function getIdComment() {
		return $this->idComment;
	}
	public function setIdComment($idComment) {
		$this->idComment = $idComment;
	}

	public function getCommentedPost() {
		return $this->commentedPost;
	}
	public function setCommentedPost($commentedPost) {
		$this->commentedPost = $commentedPost;
	}

	public function getCommentedComment() {
		return $this->commentedComment;
	}
	public function setCommentedComment($commentedComment) {
		$this->commentedComment = $commentedComment;
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
}
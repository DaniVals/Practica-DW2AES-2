<?php

namespace App\Entity;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity] 
#[ORM\Table(name: 'comment')]

class Comment
{
	#[ORM\id]
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
}
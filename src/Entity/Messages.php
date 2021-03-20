<?php

namespace App\Entity;

use App\Repository\MessagesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MessagesRepository::class)
 */
class Messages
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Conversations::class, inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $conversations;

    /**
     * @ORM\ManyToOne(targetEntity=Users::class, inversedBy="messages")
     * @ORM\JoinColumn(nullable=false)
     */
    private $users;

    /**
     * @ORM\Column(type="datetime")
     */
    private $date;

    /**
     * @ORM\Column(type="text")
     */
    private $messages;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getConversations(): ?Conversations
    {
        return $this->conversations;
    }

    public function setConversations(?Conversations $conversations): self
    {
        $this->conversations = $conversations;

        return $this;
    }

    public function getUsers(): ?Users
    {
        return $this->users;
    }

    public function setUsers(?Users $users): self
    {
        $this->users = $users;

        return $this;
    }

    public function getDate(): ?\DateTimeInterface
    {
        return $this->date;
    }

    public function setDate(\DateTimeInterface $date): self
    {
        $this->date = $date;

        return $this;
    }

    public function getMessages(): ?string
    {
        return $this->messages;
    }

    public function setMessages(string $messages): self
    {
        $this->messages = $messages;

        return $this;
    }
}

<?php

declare(strict_types=1);

namespace Linio\SafeEcho\Entity;

class Customer
{
    public $id;

    public $sentence;

    public function __construct($id, $sentence)
    {
        $this->setId($id);
        $this->setSentence($sentence);
    }

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getSentence()
    {
        return $this->sentence;
    }

    public function setSentence($sentence): void
    {
        $this->sentence = $sentence;
    }
}

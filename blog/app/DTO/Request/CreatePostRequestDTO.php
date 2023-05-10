<?php

namespace App\DTO;

class CreatePostRequestDTO
{
    public $title;
    public $content;

    public function __construct(string $title, string $content)
    {
        $this->title = $title;
        $this->content = $content;
    }
}
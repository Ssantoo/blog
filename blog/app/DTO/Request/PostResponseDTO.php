<?php

namespace App\DTO;

class PostResponseDTO
{
    public $id;
    public $title;
    public $content;
    public $username;
    public $created_at;
    public $updated_at;

    public function __construct(int $id, string $title, string $content, string $username, $created_at, $updated_at)
    {
        $this->id = $id;
        $this->title = $title;
        $this->content = $content;
        $this->username = $username;
        $this->created_at = $created_at;
        $this->updated_at = $updated_at;
    }
}


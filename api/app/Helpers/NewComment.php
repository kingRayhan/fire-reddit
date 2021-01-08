<?php

namespace App\Helpers;

class NewComment
{
    public $body;
    public $threadSlug;
    public $commentedBy;

    /**
     * NewComment constructor.
     * @param $body
     * @param $threadSlug
     * @param $commentedBy
     */
    public function __construct($body, $threadSlug, $commentedBy)
    {
        $this->body = $body;
        $this->threadSlug = $threadSlug;
        $this->commentedBy = $commentedBy;
    }
}

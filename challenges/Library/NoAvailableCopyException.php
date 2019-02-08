<?php

namespace AF\Challenges\Library;

final class NoAvailableCopyException extends \Exception
{
    public function __construct()
    {
        parent::__construct('There are no available copies of this book.');
    }
}
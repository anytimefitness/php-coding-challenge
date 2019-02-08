<?php

namespace AF\Challenges\Library;

final class NotEnoughCopiesException extends \Exception
{
    public function __construct()
    {
        parent::__construct('There are not enough copies of this book to remove.');
    }
}
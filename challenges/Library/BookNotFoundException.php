<?php

namespace AF\Challenges\Library;

final class BookNotFoundException extends \Exception
{
    public function __construct()
    {
        parent::__construct('This book was not found in the library.');
    }
}
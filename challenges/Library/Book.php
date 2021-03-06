<?php declare(strict_types=1);

namespace AF\Challenges\Library;

class Book
{
    /**
     * Book constructor. Should store the metadata
     *
     * @param string $name
     * @param string $author
     * @param string $genre
     * @param int    $pages
     * @param int    $copies
     */
    public function __construct(string $name, string $author, string $genre, int $pages, int $copies = 1)
    {
    }

    /**
     * Should attempt to check out a copy of this book.
     *     If successful, return true
     *     Otherwise, return false
     *
     * @return bool
     */
    public function checkOutCopy(): bool
    {
    }

    /**
     * Should attempt to check in a copy of this book.
     *     If successful, return true
     *     Otherwise, return false
     *
     * @return bool
     */
    public function checkInCopy(): bool
    {
    }

    /**
     * Should return the name of the book
     *
     * @return string
     */
    public function getName(): string
    {
    }

    /**
     * Should return the name of the author
     *
     * @return string
     */
    public function getAuthor(): string
    {
    }

    /**
     * Should return the genre of the book
     *
     * @return string
     */
    public function getGenre(): string
    {
    }

    /**
     * Should return the number of pages in the book
     *
     * @return int
     */
    public function getPages(): int
    {
    }

    /**
     * Should return the number of copies of this book in the library
     *
     * @return int
     */
    public function getNumberOfCopies(): int
    {
    }

    /**
     * Should return true if there are any checked-in copies of the book
     *
     * @return bool
     */
    public function isAvailable(): bool
    {
    }

    /**
     * Should return true if the two books are the same
     *
     * @param Book $book
     * @return bool
     */
    public function equals(Book $book): bool
    {
        return $this->getName() === $book->getName()
            && $this->getAuthor() === $book->getAuthor()
            && $this->getGenre() === $book->getGenre()
            && $this->getPages() === $book->getPages();
    }
}
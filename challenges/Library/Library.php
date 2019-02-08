<?php declare(strict_types=1);

namespace AF\Challenges\Library;

/**
 * Library Class
 *
 * Contains Books
 */
class Library
{
    /**
     * Library constructor.
     * Should initialize the library with the provided books, if any.
     *
     * @param Book[]|null $books
     */
    public function __construct(?array $books = null)
    {
    }

    /**
     * Should return an array of all the books in the library.
     * Extra points if its immutable.
     *
     * @return Book[]
     */
    public function getBooks(): array
    {
    }

    /**
     * Should return an existing book from the library, that matches the passed book, if it exists
     *
     * @param Book $book
     *
     * @return Book|null
     */
    public function getBook(Book $book): ?Book
    {
    }

    /**
     * Should add the given book to the library.
     * If the book already exists, it should increment the count of that book in the library.
     *
     * @param Book $book
     *
     * @return Library
     */
    public function addBook(Book $book): Library
    {
    }

    /**
     * Should attempt to remove the given book from the library
     * Should throw a BookNotFoundException if the book isn't in the library
     * Should throw a NoAvailableCopyException if there are no available copies of the book.
     * If there is more than one copy of the book, it should just lower the count of that book in the library.
     *
     * @param Book $book
     *
     * @return Library
     * @throws BookNotFoundException
     * @throws NoAvailableCopyException
     */
    public function removeBook(Book $book): Library
    {
    }

    /**
     * Should attempt to check out a book
     *     If successful, return true
     *     Otherwise, return false
     * If that book isn't in the library, throw a BookNotFoundException
     *
     * @param Book   $book
     * @param string $patron
     *
     * @return bool
     * @throws BookNotFoundException
     */
    public function checkOutBook(Book $book, string $patron): bool
    {
    }

    /**
     * Should attempt to check in a book
     *     If successful, return true
     *     Otherwise, return false
     * If that book isn't in the library, throw a BookNotFoundException
     *
     * @param Book   $book
     * @param string $patron
     *
     * @return bool
     * @throws BookNotFoundException
     */
    public function checkInBook(Book $book, string $patron): bool
    {
    }

    /**
     * Should find books that match the options.
     * Available options:
     *     * name - Exact match
     *     * author - Exact match
     *     * genre - Exact Match
     *     * available - true, or false - Whether or not there are any available copies to check out
     *     * pages - Exact match
     *     * minPages - Minimum number of pages, inclusive.
     *     * maxPages - Maximum number of pages, inclusive
     *
     * @param array $options
     *
     * @return Book[]
     */
    public function find(array $options = []): array
    {
    }
}
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
     * Should attempt to check out a book
     *     If successful, return true
     *     Otherwise, return false
     * If that book isn't in the library, throw a BookNotFoundException
     *
     * @param Book   $book
     *
     * @return bool
     * @throws BookNotFoundException
     */
    public function checkOutBook(Book $book): bool
    {
    }

    /**
     * Should attempt to check in a book
     *     If successful, return true
     *     Otherwise, return false
     * If that book isn't in the library, throw a BookNotFoundException
     *
     * @param Book   $book
     *
     * @return bool
     * @throws BookNotFoundException
     */
    public function checkInBook(Book $book): bool
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
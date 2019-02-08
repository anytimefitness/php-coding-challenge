<?php

namespace AF\Challenges\Library;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class BookTest extends TestCase
{
    /**
     * Normally, this would be mocked, but due to the way this is built as a challenge, it makes it more difficult
     * to do that.
     *
     * @param string $type
     * @param int    $pages
     * @param int    $copies
     *
     * @return MockObject|Book
     */
    private function getBook(string $type = 'book', int $pages = 1, int $copies = 1): Book
    {
        return new Book($type, $type.'Author', $type.'Genre', $pages, $copies);
    }

    public function testConstructor()
    {
        $this->assertNotNull($this->getBook());
    }

    public function testGetName()
    {
        $this->assertEquals('book', $this->getBook()->getName());
    }

    public function testGetAuthor()
    {
        $this->assertEquals('bookAuthor', $this->getBook()->getAuthor());
    }

    public function testGetGenre()
    {
        $this->assertEquals('bookGenre', $this->getBook()->getGenre());
    }

    public function testGetPages()
    {
        $this->assertEquals(5, $this->getBook('book', 5)->getPages());
    }

    public function testGetNumberOfCopies()
    {
        $this->assertEquals(5, $this->getBook('book', 1, 5)->getNumberOfCopies());
    }

    public function testCheckOutCopySuccess()
    {
        $book     = $this->getBook();
        $response = $book->checkOutCopy('patron');

        $this->assertTrue($response);
    }

    public function testCheckOutCopyFailure()
    {
        $book     = $this->getBook('book', 1, 0);
        $response = $book->checkOutCopy('patron');

        $this->assertFalse($response);
    }

    public function testCheckInCopySuccess()
    {
        $book     = $this->getBook();
        $book->checkOutCopy('patron');
        $response = $book->checkInCopy('patron');

        $this->assertTrue($response);
    }

    public function testCheckInCopyFailure()
    {
        $book     = $this->getBook('book', 1, 0);
        $response = $book->checkInCopy('patron');

        $this->assertFalse($response);
    }

    public function testIsAvailable()
    {
        $book = $this->getBook('book', 1, 1);
        $this->assertTrue($book->isAvailable());
        $book = $this->getBook('book', 1, 0);
        $this->assertFalse($book->isAvailable());
    }

    public function testAddCopy()
    {
        $book = $this->getBook();
        $this->assertEquals(1, $book->getNumberOfCopies());
        $response = $book->addCopy();

        $this->assertEquals($book, $response);
        $this->assertEquals(2, $book->getNumberOfCopies());
    }

    public function testRemoveCopySuccess()
    {
        $book = $this->getBook('book', 1, 2);
        $this->assertEquals(2, $book->getNumberOfCopies());
        $response = $book->removeCopy();

        $this->assertEquals($book, $response);
        $this->assertEquals(1, $book->getNumberOfCopies());
    }

    public function testRemoveCopyFailureNoneAvailable()
    {
        $book = $this->getBook('book', 1, 2);
        $book->checkOutCopy('patron1');
        $book->checkOutCopy('patron2');
        $this->expectExceptionObject(new NoAvailableCopyException());
        $book->removeCopy();
    }

    public function testRemoveCopyFailureNotEnoughCopies()
    {
        $book = $this->getBook('book', 1, 1);
        $this->expectExceptionObject(new NotEnoughCopiesException());
        $book->removeCopy();
    }

    public function testEquals()
    {
        $bookOne = $this->getBook('one');
        $bookTwo = $this->getBook('two', 2);

        $this->assertTrue($bookOne->equals($bookOne));
        $this->assertTrue($bookTwo->equals($bookTwo));
        $this->assertFalse($bookOne->equals($bookTwo));
        $this->assertFalse($bookTwo->equals($bookOne));
    }
}

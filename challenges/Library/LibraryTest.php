<?php

namespace AF\Challenges\Library;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class LibraryTest extends TestCase
{
    /**
     * Normally, this would be mocked, but due to the way this is built as a challenge, it makes it more difficult
     * to do that.
     *
     * @param string $type
     * @param int    $copies
     *
     * @return MockObject|Book
     */
    private function getBook(string $type = 'book', int $pages = 1, int $copies = 1): Book
    {
        return new Book($type, $type.'Author', $type.'Genre', $pages, $copies);
    }

    public function testConstructorNoBooks()
    {
        $library = new Library();

        $this->assertEmpty($library->getBooks());
    }

    public function testConstructorBooks()
    {
        $book    = $this->getBook();
        $library = new Library([$book]);

        $this->assertNotEmpty($library->getBooks());
    }

    public function testGetBooks()
    {
        $book    = $this->getBook();
        $library = new Library([$book]);

        $this->assertEquals(1, count($library->getBooks()));
        $this->assertEquals($book, $library->getBooks()[0]);

        $books   = [
            $book = $this->getBook('one'),
            $book = $this->getBook('two'),
            $book = $this->getBook('three'),
        ];
        $library = new Library($books);

        $this->assertEquals(3, count($library->getBooks()));
        foreach ($books as $index => $book) {
            $this->assertEquals($book, $library->getBooks()[$index]);
        }
    }

    public function testGetBook()
    {
        $goodBook = $this->getBook('good');

        $badBook = $this->getBook('bad');
        $library = new Library([$goodBook]);

        $this->assertEquals($goodBook, $library->getBook($goodBook));
        $this->assertNull($library->getBook($badBook));
    }

    public function testAddBook()
    {
        $library = new Library();
        $this->assertEmpty($library->getBooks());

        $book     = $this->getBook();
        $response = $library->addBook($book);

        $this->assertEquals(1, $book->getNumberOfCopies());
        $this->assertEquals($library, $response);
        $this->assertEquals(1, count($library->getBooks()));
        $this->assertEquals($book, $library->getBook($book));
        $this->assertEquals($book, $library->getBooks()[0]);
    }

    public function testAddBookCopy()
    {
        $book    = $this->getBook();
        $library = new Library([$book]);
        $this->assertEquals(1, count($library->getBooks()));

        $response = $library->addBook($book);

        $this->assertEquals($library, $response);
        $this->assertEquals(1, count($library->getBooks()));
        $this->assertEquals(2, $book->getNumberOfCopies());
    }

    public function testRemoveBookSuccess()
    {
        $book    = $this->getBook();
        $library = new Library([$book]);
        $this->assertEquals(1, count($library->getBooks()));

        $response = $library->removeBook($book);
        $this->assertEquals($library, $response);
        $this->assertEmpty($library->getBooks());
    }

    public function testRemoveCopySuccess()
    {
        $book    = $this->getBook('book', 1, 2);
        $library = new Library([$book]);
        $this->assertEquals(1, count($library->getBooks()));

        $response = $library->removeBook($book);
        $this->assertEquals($library, $response);
        $this->assertEquals(1, count($library->getBooks()));
        $this->assertEquals(1, $book->getNumberOfCopies());
    }

    public function testRemoveBookNoAvailableCopyFailure()
    {
        $book    = $this->getBook('book', 1, 2);
        $library = new Library([$book]);
        $book->checkOutCopy('patron1');
        $book->checkOutCopy('patron2');

        $this->expectExceptionObject(new NoAvailableCopyException());
        $library->removeBook($book);
    }

    public function testRemoveBookNotEnoughCopiesSuccess()
    {
        $book    = $this->getBook('book', 1, 1);
        $library = new Library([$book]);

        $response = $library->removeBook($book);
        $this->assertEquals($library, $response);
        $this->assertEmpty($library->getBooks());
    }

    public function testCheckOutBookSuccess()
    {
        $book = $this->getMockBuilder(Book::class)
            ->setConstructorArgs(['book', 'author', 'genre', 1])
            ->setMethods(['checkOutCopy'])
            ->getMock();
        $book->expects($this->once())
            ->method('checkOutCopy')
            ->willReturn(true);

        $library = new Library([$book]);

        $this->assertTrue($library->checkOutBook($book, 'patron'));
    }

    public function testCheckOutBookFailureNoAvailableCopies()
    {
        $book = $this->getMockBuilder(Book::class)
            ->setConstructorArgs(['book', 'author', 'genre', 1])
            ->setMethods(['checkOutCopy'])
            ->getMock();
        $book->expects($this->once())
            ->method('checkOutCopy')
            ->willReturn(false);

        $library = new Library([$book]);

        $this->assertFalse($library->checkOutBook($book, 'patron'));
    }

    public function testCheckOutBookFailureBookNotFound()
    {
        $book    = $this->getBook();
        $library = new Library();

        $this->expectExceptionObject(new BookNotFoundException());
        $library->checkOutBook($book, 'patron');
    }


    public function testCheckIntBookSuccess()
    {
        $book = $this->getMockBuilder(Book::class)
            ->setConstructorArgs(['book', 'author', 'genre', 1])
            ->setMethods(['checkInCopy'])
            ->getMock();
        $book->expects($this->once())
            ->method('checkInCopy')
            ->willReturn(true);

        $library = new Library([$book]);

        $this->assertTrue($library->checkInBook($book, 'patron'));
    }

    public function testCheckIntBookFailure()
    {
        $book = $this->getMockBuilder(Book::class)
            ->setConstructorArgs(['book', 'author', 'genre', 1])
            ->setMethods(['checkInCopy'])
            ->getMock();
        $book->expects($this->once())
            ->method('checkInCopy')
            ->willReturn(false);

        $library = new Library([$book]);

        $this->assertFalse($library->checkInBook($book, 'patron'));
    }

    public function testCheckInBookFailureBookNotFound()
    {
        $book    = $this->getBook();
        $library = new Library();

        $this->expectExceptionObject(new BookNotFoundException());
        $library->checkInBook($book, 'patron');
    }

    public function testFind()
    {
        $bookOne = $this->getBook('one', 500);
        $bookTwo = $this->getBook('two', 300);
        $bookThree = $this->getBook('three', 50);
        $bookFour = new Book('Test', 'Test', 'Science Fiction', 1);
        $bookFive = new Book('Test', 'Test', 'Fiction', 1);
        $bookSix = new Book('Test', 'Foobar', 'Fiction', 1);

        $library = new Library([$bookOne, $bookTwo, $bookThree, $bookFour, $bookFive, $bookSix]);
        $this->assertEquals(6, count($library->getBooks()));

        // Name
        $response = $library->find(['name' => $bookOne->getName()]);
        $this->assertEquals(1, count($response));
        $this->assertContains($bookOne, $response);
        $response = $library->find(['name' => $bookFour->getName()]);
        $this->assertEquals(3, count($response));
        $this->assertContains($bookFour, $response);
        $this->assertContains($bookFive, $response);
        $this->assertContains($bookSix, $response);
        $this->assertNotContains($bookOne, $response);

        // Author
        $response = $library->find(['author' => $bookOne->getAuthor()]);
        $this->assertEquals(1, count($response));
        $this->assertContains($bookOne, $response);
        $response = $library->find(['author' => $bookFour->getAuthor()]);
        $this->assertEquals(2, count($response));
        $this->assertContains($bookFour, $response);
        $this->assertContains($bookFive, $response);
        $this->assertNotContains($bookSix, $response);

        // Genre
        $response = $library->find(['genre' => $bookOne->getGenre()]);
        $this->assertEquals(1, count($response));
        $this->assertContains($bookOne, $response);
        $response = $library->find(['genre' => $bookFive->getGenre()]);
        $this->assertEquals(2, count($response));
        $this->assertContains($bookFive, $response);
        $this->assertContains($bookSix, $response);
        $this->assertNotContains($bookFour, $response);

        // Pages
        $response = $library->find(['pages' => $bookOne->getPages()]);
        $this->assertEquals(1, count($response));
        $this->assertContains($bookOne, $response);
        $response = $library->find(['pages' => $bookFour->getPages()]);
        $this->assertEquals(3, count($response));
        $this->assertContains($bookFour, $response);
        $this->assertContains($bookFive, $response);
        $this->assertContains($bookSix, $response);
        $this->assertNotContains($bookOne, $response);
        $response = $library->find(['minPages' => 100]);
        $this->assertEquals(2, count($response));
        $this->assertContains($bookOne, $response);
        $this->assertContains($bookTwo, $response);
        $response = $library->find(['maxPages' => 100]);
        $this->assertEquals(4, count($response));
        $this->assertContains($bookThree, $response);
        $this->assertContains($bookFour, $response);
        $this->assertContains($bookFive, $response);
        $this->assertContains($bookSix, $response);

        // Available
        $response = $library->find(['available' => true]);
        $this->assertEquals(6, count($response));
        $response = $library->find(['available' => false]);
        $this->assertEquals(0, count($response));
        $bookOne->checkOutCopy('patron');
        $response = $library->find(['available' => true]);
        $this->assertEquals(5, count($response));
        $response = $library->find(['available' => false]);
        $this->assertEquals(1, count($response));
    }
}

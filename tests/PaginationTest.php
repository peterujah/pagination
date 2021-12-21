<?php
namespace Pager\Tests;

use Peterujah\NanoBlock;
use PHPUnit\Framework\TestCase;

class PaginationTest extends TestCase
{
    
    protected $pagination;
    
    public function setUp(): void
    {
        $this->pagination = new Pagination(100, Pagination::LIST);
    }
    
    public function tearDown(): void
    {
        unset($this->pagination);
    }
    
    /**
     * @covers Peterujah\NanoBlock::setLimit
     * @covers Peterujah\NanoBlock::setCurrentPage
     * @covers Peterujah\NanoBlock::show
     */
    public function testCreatePager()
    {
        $pager = $this->pagination->setLimit(20)->setCurrentPage(1)->show();

        $this->assertStringStartsWith("<ul", $pager);
        $this->assertStringEndsWith("ul>", $pager);
        $this->assertStringContainsString('<li class="page-item active"><a class="page-link" href="?n=1" title="Page 1">1</a></li>', $pager);
    }
}

<?php

use PHPUnit\Framework\TestCase;

class AccessoriesTest extends TestCase
{
    // Initial setup
    function setUp()
    {
            $this->CI = &get_instance();
            $this->CI->load->model('accessories');
            $this->item = new Accessories();
            $this->item->id = 1;
            $this->item->name = 'sword';
            $this->item->category = 'weapon';
            $this->item->str = 10;
            $this->item->dex = 5;
            $this->item->int = 0;
    }

    // test setup for id, name, category, str, dex and int
    function testSetup()
    {
            $this->assertEquals(1, $this->item->id);
            $this->assertEquals('sword', $this->item->name);
            $this->assertEquals('weapon', $this->item->category);
            $this->assertEquals(10, $this->item->str);
            $this->assertEquals(5, $this->item->dex);
            $this->assertEquals(0, $this->item->int);
    }

    function testValidId()
    {
		$expected = 123;
		$this->item->id = $expected;
		$this->assertEquals($expected, $this->item->id);
    }

    /**
     * This is an alternate way to assert that an exception should occur
     * @expectedException InvalidArgumentException
     */
    function testInvalidId() 
    {
        $this->expectException('InvalidArgumentException');
		$this->item->id = null;
    }

    function testNamePresent() 
    {
		$expected = "sword";
		$this->item->name = $expected;
		$this->assertEquals($expected, $this->item->name);
    }

    function testNameAbsent() 
    {
		$badvalue = "";
		$this->expectException(Exception::class);
		$this->item->name = $badvalue;
    }

    function testNameTooLong() 
    {
		$badvalue = "This is a very long string that will fail the name test.";
		$this->expectException('Exception');
		$this->item->name = $badvalue;
    }

    function testValidCategory() 
    {
        $expected = "amulet";
        $this->item->category = $expected;
        $this->assertEquals($expected, $this->item->category);
    }

    function testInvalidCategory() 
    {
        $badvalue = "wrongcategory";
        $this->expectException(Exception::class);
        $this->item->category = $badvalue;
    }

    function testCategoryAbsent() 
    {
        $badvalue = "";
        $this->expectException(Exception::class);
        $this->item->category = $badvalue;
    }

    function testValidStr() 
    {
        $expected = 10;
        $this->item->str = $expected;
        $this->assertEquals($expected, $this->item->str);
    }

    function testNegativeStr() 
    {
        $badvalue = -1;
        $this->expectException(Exception::class);
        $this->item->str = $badvalue;
    }

    function testValidDex() 
    {
        $expected = 10;
        $this->item->dex = $expected;
        $this->assertEquals($expected, $this->item->dex);
    }

    function testNegativeDex() 
    {
        $badvalue = -1;
        $this->expectException(Exception::class);
        $this->item->dex = $badvalue;
    }
    
    function testValidInt() 
    {
        $expected = 10;
        $this->item->int = $expected;
        $this->assertEquals($expected, $this->item->int);
    }

    function testNegativeInt() 
    {
        $badvalue = -1;
        $this->expectException(Exception::class);
        $this->item->int = $badvalue;
    }
}
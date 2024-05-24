<?php
// test/MyTest.php

use PHPUnit\Framework\TestCase;

class MyTest extends TestCase {
    public function testSuma() {
        $this->assertEquals(4, suma(2, 2));
    }
}

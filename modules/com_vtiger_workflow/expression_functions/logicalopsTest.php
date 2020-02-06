<?php
/*************************************************************************************************
 * Copyright 2020 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
 * The MIT License (MIT)
 * Permission is hereby granted, free of charge, to any person obtaining a copy of this software
 * and associated documentation files (the "Software"), to deal in the Software without restriction,
 * including without limitation the rights to use, copy, modify, merge, publish, distribute,
 * sublicense, and/or sell copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all copies or
 * substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR IMPLIED, INCLUDING BUT
 * NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT.
 * IN NO EVENT SHALL THE AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY,
 * WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN CONNECTION WITH THE
 * SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
 *************************************************************************************************/
use PHPUnit\Framework\TestCase;

class workflowfunctionslogicalopsTest extends TestCase {

	/**
	 * Method testisnumfunction
	 * @test
	 */
	public function testisnumfunction() {
		$this->assertTrue(__cb_is_numeric(array(2017)), 'is numeric true');
		$this->assertFalse(__cb_is_numeric(array('kkk')), 'is numeric false');
	}

	/**
	 * Method testisstrfunction
	 * @test
	 */
	public function testisstrfunction() {
		$this->assertFalse(__cb_is_string(array(2017)), 'is string false');
		$this->assertTrue(__cb_is_string(array('kkk')), 'is string true');
	}

	/**
	 * Method testORANDfunctions
	 * @test
	 */
	public function testORANDfunctions() {
		$this->assertTrue(__cb_or(array(true, true)), 'or');
		$this->assertTrue(__cb_or(array(true, false)), 'or');
		$this->assertTrue(__cb_or(array(false, true)), 'or');
		$this->assertFalse(__cb_or(array(false, false)), 'or');
		$this->assertTrue(__cb_or(array(1, 1)), 'or');
		$this->assertTrue(__cb_or(array(1, 0)), 'or');
		$this->assertTrue(__cb_or(array(0, 1)), 'or');
		$this->assertFalse(__cb_or(array(0, 0)), 'or');
		$this->assertTrue(__cb_or(array('a', 'a')), 'or');
		$this->assertTrue(__cb_or(array('a', '')), 'or');
		$this->assertTrue(__cb_or(array('', 'a')), 'or');
		$this->assertFalse(__cb_or(array('', '')), 'or');
		////
		$this->assertTrue(__cb_and(array(true, true)), 'and');
		$this->assertFalse(__cb_and(array(true, false)), 'and');
		$this->assertFalse(__cb_and(array(false, true)), 'and');
		$this->assertFalse(__cb_and(array(false, false)), 'and');
		$this->assertTrue(__cb_and(array(1, 1)), 'and');
		$this->assertFalse(__cb_and(array(1, 0)), 'and');
		$this->assertFalse(__cb_and(array(0, 1)), 'and');
		$this->assertFalse(__cb_and(array(0, 0)), 'and');
		$this->assertTrue(__cb_and(array('a', 'a')), 'and');
		$this->assertFalse(__cb_and(array('a', '')), 'and');
		$this->assertFalse(__cb_and(array('', 'a')), 'and');
		$this->assertFalse(__cb_and(array('', '')), 'and');
	}

	/**
	 * Method testexistsfunction
	 * @test
	 */
	public function testexistsfunction() {
		global $current_user;
		$entityCache = new VTEntityCache($current_user);
		$entityData = $entityCache->forId('11x74');
		$params = array('accountname', 'J A Associates', $entityData);
		$this->assertTrue(__cb_exists($params), 'exists true');
		$params = array('accountname', 'No account with this name', $entityData);
		$this->assertFalse(__cb_exists($params), 'exists false');
	}

	/**
	 * Method testexistsrelatedfunction
	 * @test
	 */
	public function testexistsrelatedfunction() {
		global $current_user;
		$entityCache = new VTEntityCache($current_user);
		$entityData = $entityCache->forId('11x74');
		$params = array('Contacts', 'firstname', 'Lina', $entityData);
		$this->assertTrue(__cb_existsrelated($params), 'exists related true');
		$params = array('Contacts', 'firstname', 'no contact with this name', $entityData);
		$this->assertFalse(__cb_existsrelated($params), 'exists related true');
		$params = array('Assets', 'assetname', 'No asset related', $entityData);
		$this->assertFalse(__cb_existsrelated($params), 'exists related false');
	}

	//test number formating
	public function testenumberformatingfunction() {
		$actual = __cb_number_format(array(1234.56));
		$this->assertNotEquals("1,23456", $actual);
		$actual = __cb_number_format(array(1234.56,1));
		$this->assertEquals("1,234.6", $actual);
		$actual = __cb_number_format(array(12345,2,"."));
		$this->assertEquals("12,345.00", $actual);
		$actual = __cb_number_format(array(1234,3,".",','));
		$this->assertEquals("1,234.000", $actual);
		$actual = __cb_number_format(array(123,4,",".'.'));
		$this->assertEquals("123,.0000", $actual);

//less than 100
		$actual = __cb_number_format(array(10));
		$this->assertEquals("10", $actual);
		$actual = __cb_number_format(array(22,1));
		$this->assertEquals("22.0", $actual);
		$actual = __cb_number_format(array(45,2,','));
		$this->assertNotEquals("4500", $actual);
		$actual = __cb_number_format(array(38,3,",",'.'));
		$this->assertEquals("38,000", $actual);
		$actual = __cb_number_format(array(99,4,".",':'));
		$this->assertEquals("99.0000", $actual);

		//number with decimals
		$actual = __cb_number_format(array(999.999999));
		$this->assertNotEquals("999", $actual);
		$actual = __cb_number_format(array(999.999999,1));
		$this->assertEquals("1,000.0", $actual);
		$actual = __cb_number_format(array(999.999999,2,'.'));
		$this->assertEquals("1,000.00", $actual);
		$actual = __cb_number_format(array(999.999999,3,",",'.'));
		$this->assertEquals("1.000,000", $actual);
		$actual = __cb_number_format(array(999.999999,4,".",','));
		$this->assertEquals("1,000.0000", $actual);
		$actual = __cb_number_format(array(999394394.999999,5,",",'.'));
		$this->assertEquals("999.394.395,00000", $actual);
		$actual = __cb_number_format(array(99923456785433.999999,6,".",':'));
		$this->assertEquals("99:923:456:785:434.000000", $actual);
	}
}
?>
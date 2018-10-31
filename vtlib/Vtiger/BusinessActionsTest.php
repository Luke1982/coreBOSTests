<?php
/*************************************************************************************************
 * Copyright 2017 JPL TSolucio, S.L. -- This file is a part of TSOLUCIO coreBOS Tests.
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

class BusinessActionsTest extends TestCase {

	/**
	 * Method testgetAllByType
	 * @test
	 */
	public function testgetAllByType() {
		$customlink_params = array('MODULE'=>'CobroPago', 'RECORD'=>14297, 'ACTION'=>'DetailView');
		$actual = Vtiger_Link::getAllByType(getTabid('CobroPago'), array('DETAILVIEWBASIC', 'DETAILVIEW', 'DETAILVIEWWIDGET'), $customlink_params);
		$expectedLink = new Vtiger_Link();
		$expectedLink->tabid = '42';
		$expectedLink->linkid = '43178';
		$expectedLink->linktype = 'DETAILVIEWBASIC';
		$expectedLink->linklabel = 'View History';
		$expectedLink->linkurl = "javascript:ModTrackerCommon.showhistory('14297')";
		$expectedLink->linkicon = '';
		$expectedLink->sequence = '0';
		$expectedLink->status = false;
		$expectedLink->handler_path = 'modules/ModTracker/ModTracker.php';
		$expectedLink->handler_class = 'ModTracker';
		$expectedLink->handler = 'isViewPermitted';
		$expectedLink->onlyonmymodule = '0';
		$expected = array(
			'DETAILVIEWBASIC' => array(
				0 => $expectedLink,
			),
			'DETAILVIEW' => array(),
			'DETAILVIEWWIDGET' => array(),
		);
		$this->assertEquals($expected, $actual);
		/////////////////////////////////////////
		$actual = Vtiger_Link::getAllByType(getTabid('CobroPago'), 'DETAILVIEWBASIC', $customlink_params);
		$expectedLink = new Vtiger_Link();
		$expectedLink->tabid = '42';
		$expectedLink->linkid = '43178';
		$expectedLink->linktype = 'DETAILVIEWBASIC';
		$expectedLink->linklabel = 'View History';
		$expectedLink->linkurl = "javascript:ModTrackerCommon.showhistory('14297')";
		$expectedLink->linkicon = '';
		$expectedLink->sequence = '0';
		$expectedLink->status = false;
		$expectedLink->handler_path = 'modules/ModTracker/ModTracker.php';
		$expectedLink->handler_class = 'ModTracker';
		$expectedLink->handler = 'isViewPermitted';
		$expectedLink->onlyonmymodule = '0';
		$expected = array(
			'DETAILVIEWBASIC' => $expectedLink,
		);
		$this->assertEquals($expected, $actual);
	}
}
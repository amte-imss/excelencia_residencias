<?php

/**
 * Part of ci-phpunit-test
 *
 * @author     Kenji Suzuki <https://github.com/kenjis>
 * @license    MIT License
 * @copyright  2015 Kenji Suzuki
 * @link       https://github.com/kenjis/ci-phpunit-test
 */
class Welcome_test extends TestCase {

    public function test_index() {
        $this->assertTrue(false, "true didn't end up being false!");
//        $this->browse(function ($browser) {
//            $browser->visit('welcome/index')
//                    -> assertSee('Latest Transactions');
//        });
//        $output = $this->request('GET', ['Welcome', 'index']);
////		$output = $this->request('GET', 'welcome/index');
////		$this->assertContains('<title> SIPIMSS</title>', $output);
//        $this->assertContains('<title>Welcome to CodeIgniter</title>', $output);
    }

    public function test_method_404() {
        $this->request('GET', 'welcome/method_not_exist');
        $this->assertResponseCode(404);
    }

    public function test_APPPATH() {
        $actual = realpath(APPPATH);
        $expected = realpath(__DIR__ . '/../..');
        $this->assertEquals(
                $expected, $actual, 'Your APPPATH seems to be wrong. Check your $application_folder in tests/Bootstrap.php'
        );
    }

}

<?php
/**
 * Class SampleTest
 *
 * @package Wp_Gdpr_Compliance
 */

/**
 * Sample test case.
 */
class SampleTest extends WP_UnitTestCase {

	/**
	 * A single example test.
	 */
	public function test_sample() {
        $user_id = self::factory()->user->create(
            [
                'role' => 'editor',
            ]
        );

        $this->assertTrue( user_can( $user_id, 'edit_others_posts' ) );
	}
}

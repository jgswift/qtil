<?php
namespace qtil\Tests {
    use qtil\Identifier;
    /**
    * Base qtil test case class
    * Class qtilTestCase
    * @package qtil
    */
    abstract class qtilTestCase extends \PHPUnit_Framework_TestCase {
        /**
        * Perform setUp tasks
        */
        protected function setUp()
        {
        }

        /**
         * Perform clean up / tear down tasks
         */
        protected function tearDown()
        {
            Identifier::clearSchemes();
        }
    }
}
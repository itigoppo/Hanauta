<?php
/**
 * Hanauta : Development Library
 *
 * @author Hisato Sakanoue <itigoppo+github@gmail.com>
 * @copyright Copyright(c) Hisato Sakanoue <itigoppo+github@gmail.com>
 * @since 2.0.0
 */

namespace Hanauta\Test\Utility;

use Hanauta\Utility\Text;

class TextTest extends \PHPUnit_Framework_TestCase
{
    /** @var  Text */
    private $text;

    public function setUp()
    {
        parent::setUp();
        $this->text = new Text();
    }

    protected function tearDown()
    {
        parent::tearDown();
        unset($this->text);
    }

    public function testUuid()
    {
        $result = Text::uuid();
        $pattern = '/^[a-f0-9]{8}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{4}-[a-f0-9]{12}$/';
        $match = (bool)preg_match($pattern, $result);
        $this->assertTrue($match);
    }
}

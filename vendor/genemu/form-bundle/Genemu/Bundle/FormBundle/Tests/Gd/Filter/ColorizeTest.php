<?php

/*
 * This file is part of the GenemuFormBundle package.
 *
 * (c) Olivier Chauvel <olivier@generation-multiple.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Genemu\Bundle\FormBundle\Tests\Gd\Filter;

use Genemu\Bundle\FormBundle\Gd\Filter\Colorize;

/**
 * @author Olivier Chauvel <olivier@generation-multiple.com>
 */
class ColorizeTest extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();

        if (!function_exists('gd_info')) {
            $this->markTestSkipped('Gd not installed');
        }
    }

    public function testDefault()
    {
        $filter = new Colorize('#000');
        $filter->setResource(imagecreatetruecolor(10, 10));

        $apply = $filter->apply();

        $this->assertTrue(is_resource($apply));
    }
}

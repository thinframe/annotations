<?php

/**
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\Annotations\Test\Sample;

/**
 * SampleAnnotatedClass
 *
 * @package        ThinFrame\Annotations\Tests\Samples
 *
 * @simpleProperty simpleValue
 * @multiLineJSONProperty {
 *                          "someKey":"someValue",
 *                          "otherKey":"otherValue"
 *                      }
 */
class SampleAnnotatedClass
{
    /**
     * @visibility private
     * @var string
     */
    protected $someProperty;

    /**
     * @Route {
     *          "path":"/home",
     *          "method":"GET"
     *        }
     * @since 0.2
     */
    public function someMethod()
    {

    }
}

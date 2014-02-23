<?php

/**
 * src/Tests/Samples/SampleAnnotatedClass.php
 *
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\Annotations\Tests\Samples;

/**
 * Class SampleAnnotatedClass
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
    private $someProperty;

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

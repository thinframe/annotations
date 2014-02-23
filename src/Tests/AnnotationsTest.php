<?php

/**
 * src/Tests/AnnotationsTest.php
 *
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\Annotations\Tests;

use ThinFrame\Annotations\AnnotationsApplication;
use ThinFrame\Annotations\AnnotationsHandlerInterface;
use ThinFrame\Annotations\Collector;
use ThinFrame\Annotations\Processor;
use ThinFrame\Annotations\Tests\Samples\SampleAnnotatedClass;

/**
 * Class AnnotationsTest
 *
 * @package ThinFrame\Annotations\Tests
 * @since   0.2
 */
class AnnotationsTest extends \PHPUnit_Framework_TestCase implements AnnotationsHandlerInterface
{
    /**
     * @var Processor
     */
    private $processor;

    /**
     * Test annotations
     */
    public function testAnnotations()
    {
        $this->processor->processInstance(new SampleAnnotatedClass());
    }

    /**
     * Test annotations application
     */
    public function testApplication()
    {
        $app = new AnnotationsApplication();

        $this->assertTrue(
            $app->make()->getContainer()->get('annotations.processor') instanceof Processor,
            'Services should be configured correctly'
        );
    }

    /**
     * Handle class annotations
     *
     * @param mixed            $targetObj
     * @param \ReflectionClass $reflection
     * @param array            $annotations
     *
     * @return mixed
     */
    public function handleClassAnnotations(\ReflectionClass $reflection, array $annotations, $targetObj = null)
    {
        $this->assertArrayHasKey('simpleProperty', $annotations, 'Annotations array should have the right keys');
        $this->assertArrayHasKey('multiLineJSONProperty', $annotations, 'Annotations array should have the right keys');
        $this->assertEquals('simpleValue', $annotations['simpleProperty'][0], 'Annotations should be correct');
        $this->assertEquals(
            'someValue',
            $annotations['multiLineJSONProperty'][0]->someKey,
            'Annotations should be correct'
        );
    }

    /**
     * Handle method annotations
     *
     * @param mixed             $targetObj
     * @param \ReflectionMethod $reflection
     * @param array             $annotations
     *
     * @return mixed
     */
    public function handleMethodAnnotations(\ReflectionMethod $reflection, array $annotations, $targetObj = null)
    {
        $this->assertFalse(isset($annotations['since']));
        $this->assertEquals('GET', $annotations['Route'][0]->method);
    }

    /**
     * Handle property annotations
     *
     * @param mixed               $targetObj
     * @param \ReflectionProperty $reflection
     * @param array               $annotations
     *
     * @return mixed
     */
    public function handlePropertyAnnotations(\ReflectionProperty $reflection, array $annotations, $targetObj = null)
    {
        $this->assertEquals('private', $annotations['visibility'][0]);
    }

    /**
     * Setting up
     */
    protected function setUp()
    {
        parent::setUp();

        $this->processor = new Processor(new Collector());

        $this->processor->addHandler($this);
    }
}

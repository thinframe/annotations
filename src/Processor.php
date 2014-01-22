<?php

/**
 * /src/Processor.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\Annotations;

use ThinFrame\Foundation\Constants\DataType;
use ThinFrame\Foundation\Helpers\TypeCheck;

/**
 * Class Processor
 *
 * @package ThinFrame\Annotations
 * @since   0.2
 */
class Processor
{
    /**
     * @var AnnotationsHandlerInterface[]
     */
    private $handlers = [];
    /**
     * @var Collector
     */
    private $collector;

    /**
     * Constructor
     *
     * @param Collector $collector
     */
    public function __construct(Collector $collector)
    {
        $this->collector = $collector;
    }

    /**
     * Add a new annotations handler
     *
     * @param AnnotationsHandlerInterface $handler
     */
    public function addHandler(AnnotationsHandlerInterface $handler)
    {
        $this->handlers[] = $handler;
    }

    /**
     * Process instance annotations
     *
     * @param mixed $instance
     */
    public function processInstance($instance)
    {
        $this->processClass(get_class($instance), $instance);
    }

    /**
     * Process class annotations
     *
     * @param string $className
     * @param mixed  $instance
     */
    public function processClass($className, $instance = null)
    {
        TypeCheck::doCheck(DataType::STRING);

        $reflector = new \ReflectionClass($className);

        foreach ($this->handlers as $handler) {
            $handler->handleClassAnnotations($reflector, $this->collector->getAnnotationsFor($reflector), $instance);
            foreach ($reflector->getMethods() as $method) {
                $handler->handleMethodAnnotations($method, $this->collector->getAnnotationsFor($method), $instance);
            }
            foreach ($reflector->getProperties() as $property) {
                $handler->handlePropertyAnnotations(
                    $property,
                    $this->collector->getAnnotationsFor($property),
                    $instance
                );
            }
        }
    }
}

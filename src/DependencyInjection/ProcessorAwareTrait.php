<?php

/**
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\Annotations\DependencyInjection;

use ThinFrame\Annotations\Processor;

/**
 * ProcessorAwareTrait - should be used by classes that depends on the Processor
 *
 * @package ThinFrame\Annotations\DependencyInjection
 * @since   0.2
 */
trait ProcessorAwareTrait
{
    /**
     * @var Processor
     */
    protected $processor;

    /**
     * Attach processor instance
     *
     * @param Processor $processor
     */
    public function setProcessor(Processor $processor)
    {
        $this->processor = $processor;
    }
}

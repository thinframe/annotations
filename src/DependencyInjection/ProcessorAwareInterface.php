<?php

/**
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\Annotations\DependencyInjection;

use ThinFrame\Annotations\Processor;

/**
 * ProcessorAwareInterface - should be implemented by classes that depends on the Processor
 *
 * @package ThinFrame\Annotations\DependencyInjection
 * @since   0.3
 */
interface ProcessorAwareInterface
{
    /**
     * Attach the processor to the current instance
     *
     * @param Processor $processor
     *
     * @return $this
     */
    public function setProcessor(Processor $processor);
}

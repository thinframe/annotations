<?php

/**
 * /src/DependencyInjection/TaggedHandlerCompilerPass.php
 *
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\Annotations\DependencyInjection;

use Symfony\Component\DependencyInjection\Compiler\CompilerPassInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Reference;

/**
 * Class TaggedHandlerCompilerPass
 *
 * @package ThinFrame\Annotations\DependencyInjection
 * @since   0.2
 */
class TaggedHandlerCompilerPass implements CompilerPassInterface
{
    /**
     * Processor service ID
     *
     * @var string
     */
    private $processorServiceId;

    /**
     * Constructor
     *
     * @param string $processorServiceId
     */
    public function __construct($processorServiceId)
    {
        $this->processorServiceId = $processorServiceId;
    }

    /**
     * You can modify the container here before it is dumped to PHP code.
     *
     * @param ContainerBuilder $container
     *
     * @api
     */
    public function process(ContainerBuilder $container)
    {
        foreach ($container->findTaggedServiceIds(
                     'annotations.handler'
                 ) as $handlerServiceId => $options) {
            $container->getDefinition($this->processorServiceId)->addMethodCall(
                'addHandler',
                [new Reference($handlerServiceId)]
            );
        }
    }
}

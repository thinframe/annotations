<?php

/**
 * /src/AnnotationsApplication.php
 *
 * @author    Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\Annotations;

use PhpCollection\Map;
use ThinFrame\Annotations\DependencyInjection\TaggedHandlerCompilerPass;
use ThinFrame\Applications\AbstractApplication;
use ThinFrame\Applications\DependencyInjection\ContainerConfigurator;
use ThinFrame\Applications\DependencyInjection\TraitInjectionRule;

/**
 * Class AnnotationsApplication
 *
 * @package ThinFrame\Annotations
 * @since   0.2
 */
class AnnotationsApplication extends AbstractApplication
{
    /**
     * Get application name
     *
     * @return string
     */
    public function getName()
    {
        return $this->reflector->getShortName();
    }

    /**
     * Get application parents
     *
     * @return AbstractApplication[]
     */
    public function getParents()
    {
        return [];
    }

    /**
     * Set different options for the container configurator
     *
     * @param ContainerConfigurator $configurator
     */
    protected function setConfiguration(ContainerConfigurator $configurator)
    {
        $configurator
            ->addResource('Resources/config/services.yml')
            ->addInjectionRule(
                new TraitInjectionRule(
                    '\ThinFrame\Annotations\DependencyInjection\ProcessorAwareTrait',
                    'setProcessor',
                    'annotations.processor'
                )
            )
            ->addCompilerPass(new TaggedHandlerCompilerPass('annotations.processor'));
    }

    /**
     * Set application metadata
     *
     * @param Map $metadata
     *
     */
    protected function setMetadata(Map $metadata)
    {
        //noop
    }
}

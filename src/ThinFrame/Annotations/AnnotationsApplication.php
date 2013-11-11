<?php

/**
 * /src/ThinFrame/Annotations/AnnotationsApplication.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\Annotations;

use ThinFrame\Annotations\DependencyInjection\TaggedHandlerCompilerPass;
use ThinFrame\Applications\AbstractApplication;
use ThinFrame\Applications\DependencyInjection\ContainerConfigurator;

/**
 * Class AnnotationsApplication
 *
 * @package ThinFrame\Annotations
 * @since   0.2
 */
class AnnotationsApplication extends AbstractApplication
{
    /**
     * Initialize configurator
     *
     * @param ContainerConfigurator $configurator
     *
     * @return mixed
     */
    public function initializeConfigurator(ContainerConfigurator $configurator)
    {
        $configurator->addCompilerPass(new TaggedHandlerCompilerPass('thinframe.annotations.processor'));
    }

    /**
     * Get application name
     *
     * @return string
     */
    public function getApplicationName()
    {
        return 'ThinFrameAnnotations';
    }

    /**
     * Get configuration files
     *
     * @return mixed
     */
    public function getConfigurationFiles()
    {
        return [
            'resources/services.yml'
        ];
    }

    /**
     * Get parent applications
     *
     * @return AbstractApplication[]
     */
    protected function getParentApplications()
    {
        return [];
    }
}

<?php

/**
 * /src/Collector.php
 *
 * @copyright 2013 Sorin Badea <sorin.badea91@gmail.com>
 * @license   MIT license (see the license file in the root directory)
 */

namespace ThinFrame\Annotations;

/**
 * Class Collector
 *
 * @package ThinFrame\Annotations
 * @since   0.2
 */
class Collector
{
    /**
     * @var array
     */
    private $phpDocKeywords = [
        'abstract',
        'access',
        'author',
        'copyright',
        'deprecated',
        'deprec',
        'example',
        'exception',
        'global',
        'ignore',
        'internal',
        'link',
        'name',
        'magic',
        'package',
        'param',
        'return',
        'see',
        'since',
        'static',
        'staticvar',
        'subpackage',
        'throws',
        'todo',
        'var',
        'version'
    ];
    /**
     * @var array
     */
    private $classAnnotations = [];
    /**
     * @var array
     */
    private $methodAnnotations = [];
    /**
     * @var array
     */
    private $propertyAnnotations = [];

    /**
     * Get annotations for reflector
     *
     * @param \Reflector $reflector
     *
     * @return array
     */
    public function getAnnotationsFor(\Reflector $reflector)
    {
        if ($reflector instanceof \ReflectionClass) {
            return $this->getClassAnnotations($reflector->getName());
        } elseif ($reflector instanceof \ReflectionMethod) {
            return $this->getMethodAnnotations($reflector->getDeclaringClass()->getName(), $reflector->getName());
        } elseif ($reflector instanceof \ReflectionProperty) {
            return $this->getPropertyAnnotations($reflector->getDeclaringClass()->getName(), $reflector->getName());
        } else {
            return [];
        }
    }

    /**
     * Get class annotations
     *
     * @param string $className
     *
     * @return array
     */
    public function getClassAnnotations($className)
    {
        if (!isset($this->classAnnotations[$className])) {
            trY {
                $reflector                          = new \ReflectionClass($className);
                $this->classAnnotations[$className] = $this->parseDocCommentBlock($reflector->getDocComment());
            } catch (\ReflectionException $e) {
                $this->classAnnotations[$className] = [];
            }
        }

        return $this->classAnnotations[$className];
    }

    /**
     * Parse given doc comment
     *
     * @param      $docCommentBlock
     * @param bool $remoteReserved
     *
     * @return array
     */
    private function parseDocCommentBlock($docCommentBlock, $remoteReserved = true)
    {
        $docCommentBlock = substr($docCommentBlock, 4, -2);
        $docCommentBlock = preg_split('/\r?\n\r?/', $docCommentBlock);
        $docCommentBlock = array_map(
            function ($line) {
                return ltrim(rtrim($line), "* \t\n\r\0\x0B");
            },
            $docCommentBlock
        );
        $unifiedRows     = [];
        $row             = "";
        $multiLine       = false;
        foreach ($docCommentBlock as $docBlockRow) {
            if (trim($docBlockRow) == "") {
                continue;
            }
            if (substr($docBlockRow, 0, 1) == "@") {
                if ($multiLine) {
                    $unifiedRows[] = $row;
                }
                $row       = substr($docBlockRow, 1, strlen($docBlockRow));
                $multiLine = true;
            } elseif ($multiLine == true) {
                $row .= ' ' . $docBlockRow;
            }
        }
        $unifiedRows[] = $row;
        $annotations   = [];
        foreach ($unifiedRows as $row) {
            $parts = explode(" ", $row, 2);
            if ($remoteReserved && in_array($parts[0], $this->phpDocKeywords)) {
                continue;
            }
            if (!isset($annotations[$parts[0]])) {
                $annotations[$parts[0]] = [];
            }
            if (isset($parts[1])) {
                if (is_null($decoded = json_decode($parts[1]))) {
                    $decoded = $parts[1];
                }
                $annotations[$parts[0]][] = $decoded;
            }
        }

        return $annotations;
    }

    /**
     * Get method annotations
     *
     * @param string $className
     * @param string $methodName
     *
     * @return array
     */
    public function getMethodAnnotations($className, $methodName)
    {
        $id = $className . '::' . $methodName;
        if (!isset($this->methodAnnotations[$id])) {
            try {
                $reflector                    = new \ReflectionMethod($className, $methodName);
                $this->methodAnnotations[$id] = $this->parseDocCommentBlock(
                    $reflector->getDocComment()
                );
            } catch (\ReflectionException $e) {
                $this->methodAnnotations[$id] = [];
            }
        }

        return $this->methodAnnotations[$id];
    }

    /**
     * Get property annotations
     *
     * @param string $className
     * @param string $propertyName
     *
     * @return array
     */
    public function getPropertyAnnotations($className, $propertyName)
    {
        $id = $className . '::' . $propertyName;
        if (!isset($this->propertyAnnotations[$id])) {
            try {
                $reflector                      = new \ReflectionProperty($className, $propertyName);
                $this->propertyAnnotations[$id] = $this->parseDocCommentBlock(
                    $reflector->getDocComment()
                );
            } catch (\ReflectionException $e) {
                $this->propertyAnnotations[$id] = [];
            }
        }

        return $this->propertyAnnotations[$id];
    }
}
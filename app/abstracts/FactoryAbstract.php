<?php

namespace App\Abstracts;

use Core\Error;

abstract class FactoryAbstract
{
    /**
     * Given a short type identifier, this method should resolve and return
     * the fully‐qualified class name of the product.
     *
     * For example, in a FormFieldFactory you may map "text" to "App\FormFields\TextField"
     *
     * @param string $type
     * @return string Fully qualified class name
     * @throws Error if resolution fails
     */
    abstract protected static function resolveClassName(string $type): string;

    /**
     * Create an instance of the product identified by $type.
     *
     * @param string $type      The product type (or alias)
     * @param array $parameters Optional parameters to pass to the constructor.
     * @return object           An instance of the resolved product.
     * @throws Error            If the class doesn’t exist.
     */
    public static function create(string $type, array $parameters = [])
    {
        $className = self::resolveClassName($type);

        if (!class_exists($className)) {
            throw new Error (
                'system',
                'Unkown type in factory',
                "Class {$className} does not exist for type: {$type}",
                [
                    'className' => $className,
                    'type' => $type
                ]
            );
        }

        $reflection = new \ReflectionClass($className);
        return $reflection->newInstanceArgs($parameters);
    }
}
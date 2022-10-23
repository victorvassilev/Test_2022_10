<?php

declare(strict_types=1);

/**
 * Model collection attribute.
 * This class is implemented as attribute to be used in the model classes to define collection of objects.
 *
 * @author Maxim Antonisin <maxim.antonisin@gmail.com>
 *
 * @version 1.0.0
 */
#[Attribute]
class CollectionAttribute
{
    /**
     * Class name used for collection.
     * This property contain class name used to define each item in the collection.
     *
     * @var string - Collection item class name.
     */
    private string $class;


    /**
     * Main constructor.
     * This method is used to initialize class instance and define properties.
     *
     * @param string $class - Collection item class name.
     */
    public function __construct(string $class)
    {
        $this->class = $class;
    }

    /**
     * Return collection item class name.
     * This method is used to return collection item class name.
     *
     * @return string
     */
    public function getClass(): string
    {
        return $this->class;
    }
}
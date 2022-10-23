<?php

declare(strict_types=1);

use CollectionAttribute as Collection;

/**
 * Application helper class.
 * This class is implemented as abstract helper and used to store all static and common methods used in the application.
 *
 * @author Maxim Antonisin <maxim.antonisin@gmail.com>
 *
 * @version 1.0.0
 */
abstract class Helper
{
    /**
     * Load all files path.
     * This method is used to load all files path from the given directory.
     *
     * @param string $path - Directory path.
     *
     * @return array
     */
    public static function loadPaths(string $path): array
    {
        $list = scandir($path, SCANDIR_SORT_ASCENDING);
        $list = array_filter($list, function($file) {
            return preg_match('/\.json$/', $file);
        });

        /** @noinspection PhpUnnecessaryLocalVariableInspection */
        $list = array_map(function($file) use ($path) {
            return sprintf('%s/%s', $path, $file);
        }, $list);

        return $list;
    }

    /**
     * Read and decode file.
     * This method is used to read file $file and decode it to the array.
     *
     * @param string $file - File path.
     *
     * @return array
     */
    public static function readFile(string $file): array
    {
        $content = file_get_contents($file);

        return json_decode($content, true);
    }

    /**
     * Process class.
     * This method is used to process class $class and return instance of it with all properties set from $content.
     *
     * @param string $class   - Class name.
     * @param array  $content - Content to be set to the class.
     *
     * @return object
     *
     * @throws ReflectionException
     */
    public static function processClass(string $class, array $content): object
    {
        $object = new $class();
        $reflection = new ReflectionClass($class);

        $properties = $reflection->getProperties();
        foreach ($properties as $property) {
            $method = sprintf('set%s', ucfirst($property->getName()));
            $value = $content[$property->getName()];
            $value = self::processAttributes($property, $value);

            $object->$method($value);
        }

        return $object;
    }

    /**
     * Process attributes.
     * This method is used to process attributes of the property $property and return value $value. In some case,
     * attributes can change or transform value.
     *
     * @param ReflectionProperty $property - Property to be processed.
     * @param mixed              $value    - Value to be processed.
     *
     * @return mixed
     *
     * @throws ReflectionException
     */
    private static function processAttributes(ReflectionProperty $property, mixed $value): mixed
    {
        $attributes = $property->getAttributes();
        if (empty($attributes)) {
            return $value;
        }

        foreach ($attributes as $attribute) {
            if (Collection::class !== $attribute->getName()){
                continue;
            }

            $value = array_map(function($item) use ($attribute) {
                $class = $attribute->newInstance()->getClass();

                return self::processClass($class, $item);
            }, $value);
        }

        return $value;
    }
}
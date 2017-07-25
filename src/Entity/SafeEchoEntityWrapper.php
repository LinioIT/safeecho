<?php

declare(strict_types=1);

namespace Linio\SafeEcho\Entity;

//TODO: Implement callStatic
use Exception;

abstract class SafeEchoEntityWrapper
{
    /**
     * @var mixed
     */
    private $wrappedEntity;

    /**
     * Define how to handle safeecho call.
     *
     * Example 1: return safeecho($return, ***set data*** , true);
     *
     * @param mixed $return
     *
     * @return mixed
     */
    abstract protected function attemptSafeEcho($return);

    /**
     * Sets the wrapped entity for safe output.
     *
     * @param mixed $entity
     *
     * @throws Exception
     */
    public function wrap($entity): void
    {
        if (!is_object($entity)) {
            throw new Exception('Only objects can be wrapped');
        }

        $this->wrappedEntity = $entity;
    }

    /**
     * @throws Exception
     */
    public function __call(string $name, array $arguments = null)
    {
        if (method_exists($this->getWrappedEntity(), $name)) {
            return $this->attemptSafeEcho(call_user_func_array([$this->getWrappedEntity(), $name], $arguments));
        }

        throw new Exception($this->undefinedMethod($name));
    }

    /**
     * @throws Exception
     */
    public function __get(string $name)
    {
        if (property_exists(get_class($this->getWrappedEntity()), $name)) {
            return $this->attemptSafeEcho($this->getWrappedEntity()->$name);
        }

        throw new Exception($this->undefinedProperty($name));
    }

    /**
     * @throws Exception
     */
    public function __set(string $name, $value): void
    {
        if (property_exists(get_class($this->getWrappedEntity()), $name)) {
            $this->getWrappedEntity()->$name = $value;
        } else {
            throw new Exception($this->undefinedProperty($name));
        }
    }

    /**
     * Gets the entity that is currently wrapped, or throws an Exception.
     *
     * @throws Exception
     *
     * @return mixed
     */
    private function getWrappedEntity()
    {
        if (!isset($this->wrappedEntity)) {
            throw new Exception('No wrapped object defined. Did you forget to call [wrap]?');
        }

        return $this->wrappedEntity;
    }

    /**
     * @param string $name
     *
     * @return string
     */
    private function undefinedMethod(string $name): string
    {
        return sprintf('Call to undefined method %s::%s()', get_class($this->wrappedEntity), $name);
    }

    /**
     * @param string $name
     *
     * @return string
     */
    private function undefinedProperty(string $name): string
    {
        return sprintf('Undefined property %s::$%s', get_class($this->wrappedEntity), $name);
    }
}

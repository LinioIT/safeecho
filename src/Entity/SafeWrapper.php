<?php


namespace Linio\SafeEcho\Entity;

class SafeWrapper extends SafeEchoEntityWrapper
{
    /**
     * Define how to handle safeecho call.
     *
     * Example 1: return safeecho($return, ***set data*** , true);
     *
     * @param mixed $return
     *
     * @return mixed
     */
    protected function attemptSafeEcho($return)
    {
        return safeecho($return, null, true);
    }
}

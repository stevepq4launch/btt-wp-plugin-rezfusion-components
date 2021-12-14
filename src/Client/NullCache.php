<?php

namespace Rezfusion\Client;

class NullCache extends Cache
{
    public function getMode(): int
    {
        return 0;
    }

    public function get($key)
    {
        return false;
    }

    public function set($key, $data)
    {
        return false;
    }

    public function has($key)
    {
        return false;
    }

    public function delete($key)
    {
        return false;
    }
}

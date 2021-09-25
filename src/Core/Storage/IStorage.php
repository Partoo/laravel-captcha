<?php
namespace Tao\Captcha\Core\Storage;
interface IStorage
{
    /**
     * @param string $code
     * @return void
     */
    public function put(string $cache_key, string $code);

    /**
     * @return string|null
     */
    public function get(string $cache_key): ?string;

    public function forget(string $cache_key);
}

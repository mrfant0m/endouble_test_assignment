<?php

namespace App\Service;

use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Doctrine\Common\Cache\CacheProvider;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;
use Symfony\Contracts\Cache\ItemInterface;
use App\Components\Space;
use App\Components\Comics;

class SourceService
{
    /**
     * Source service constructor.
     */
    public function __construct()
    {
    }

    /**
     * Get provider
     * @return int
     */
    public function getProvider($name, $year, $limit): array
    {

        $cache = new FilesystemAdapter();

        $result = [];
        $cacheKey = $name . $year;

        //warm cache if not exist
        if (!$cache->hasItem($cacheKey)) {

            $class = 'App\Components\\' . ucfirst($name);

            if (class_exists($class)) {
                $source = new $class();
                $data = $source->process();
            } else {
                throw new BadRequestHttpException('Wrong source parameter');
            }

            //save data to cache
            if (is_array($data)) {
                foreach ($data as $key => $row) {
                    $item = $cache->getItem($name . $key);
                    if (!$item->isHit()) {
                        $item->set($data[$key]);
                        $cache->save($item);
                    }
                }
            }

        }

        //get chached data
        if ($cache->hasItem($cacheKey)) {
            $item = $cache->getItem($cacheKey);
            $list = $item->get();
            $result = array_slice($list, 0, $limit);
        }

        return $result;
    }

}
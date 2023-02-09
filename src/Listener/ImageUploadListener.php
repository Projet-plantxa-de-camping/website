<?php


namespace App\Listener;

use Vich\UploaderBundle\Event\Event;
use Liip\ImagineBundle\Imagine\Cache\CacheManager;
use App\Entity\Article;

class ImageUploadListener
{
    private CacheManager $cacheManager;

    public function __construct(CacheManager $cacheManager)
    {
        $this->cacheManager = $cacheManager;
    }

    public function onVichUploaderPreRemove(Event $event): void
    {
        $entity = $event->getObject();

        if(!$entity instanceof Article) {
            return;
        }

        $this->cacheManager->remove($event->getMapping()->getUriPrefix() . '/' . $entity->getImageName());
    }

}
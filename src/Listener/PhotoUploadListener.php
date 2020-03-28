<?php
/**
 * PhotoUploadListener.php Created by TS for hanna
 * Email tim@live.fi
 * 23.3.2020 @ 16.04
 */

namespace App\Listener;
use Psr\Log\LoggerInterface;
use Symfony\Component\HttpKernel\KernelInterface;
use Vich\UploaderBundle\Event\Event;
use Intervention\Image\ImageManagerStatic as Image;

class PhotoUploadListener
{
    private $logger;
    private $projectDir;

    public function __construct(KernelInterface $kernel,LoggerInterface $logger)
    {
        $this->projectDir = $kernel->getProjectDir();
        $this->logger=$logger;
    }

    public function onVichuploaderPostupload(Event $event)
    {
        $object = $event->getObject();
        $mapping = $event->getMapping();

        //$this->logger->info(var_dump($event->getObject()->file->getFileName()));
        $this->createThumbnail($event->getObject()->file->getFileName(),$event->getObject()->file->getPathName());
//        $this->logger->info(var_dump($event->getObject()->file));
    }

    private function createThumbnail($filename,$pathname)
    {
        $img = Image::make($pathname);

        // resize image instance
        $img->resize(240, 240);

        // save image in desired format
        $img->save($this->projectDir . '/public/thumb/media/'.$filename,100);

    }

}
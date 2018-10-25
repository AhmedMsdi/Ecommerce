<?php

namespace AppBundle\Controller\vich;

use Symfony\Component\HttpFoundation\File\UploadedFile;
use Vich\UploaderBundle\Mapping\PropertyMapping ;
use Vich\UploaderBundle\Mapping\PropertyMappingFactory;
use Vich\UploaderBundle\Storage\FileSystemStorage as BaseVichController;
use Vich\UploaderBundle\Storage\AbstractStorage;
use Vich\UploaderBundle\Storage\StorageInterface;

/**
 * FileSystemStorage.
 *
 * @author Dustin Dobervich <ddobervich@gmail.com>
 */
class FileSystemStorage
{
    /**
     * {@inheritDoc}
     */
    protected function doUpload(PropertyMapping $mapping, UploadedFile $file, $dir, $name)
    {
        $uploadDir = $mapping->getUploadDestination().DIRECTORY_SEPARATOR.$dir;

        return $file->move($uploadDir, time()."_".$name);
    }



}

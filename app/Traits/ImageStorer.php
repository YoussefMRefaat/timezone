<?php

namespace App\Traits;

use Illuminate\Http\UploadedFile;

trait ImageStorer{

    /**
     * store an image in the file system and return the path
     *
     * @param UploadedFile $image
     * @return string
     */
    public function storeImage(UploadedFile $image): string
    {
        $path = $image->store('public/images/watches/');
        return str_replace('public' , 'storage' , $path);
    }
}

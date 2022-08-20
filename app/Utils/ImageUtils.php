<?php


namespace App\Utils;


use Intervention\Image\Facades\Image as InterventionImage;

class ImageUtils
{
    public static function createResizedImage(string $type, string $filename, string $subfolder, $size)
    {
        $fullname = pathinfo($filename, PATHINFO_FILENAME);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $file = InterventionImage::make($filename)->resize($size,$size, function($constraint) {
            $constraint->aspectRatio();
        });

        $path = public_path('storage/images/'. $subfolder . '/'. $fullname.'_'.$type.'.'.$extension);
        $store_path = $subfolder.'/'.$fullname.'_'.$type.'.'.$extension;
        if($file->save($path))
            return $store_path;
    }
}

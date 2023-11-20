<?php


namespace App\Utils;


use Intervention\Image\Facades\Image as InterventionImage;
use Illuminate\Database\Eloquent\Model;

class ImageUtils
{
    public static function createResizedImage(string $type, string $filename, string $subfolder, $sizeX, $sizeY)
    {
        $fullname = pathinfo($filename, PATHINFO_FILENAME);
        $extension = pathinfo($filename, PATHINFO_EXTENSION);
        $file = InterventionImage::make($filename)->resize($sizeX, $sizeY, function($constraint) {
            $constraint->aspectRatio();
        });

        $path = public_path('storage/images/'. $subfolder . '/'. $fullname.'_'.$type.'.'.$extension);
        $store_path = $subfolder.'/'.$fullname.'_'.$type.'.'.$extension;
        if($file->save($path))
            return $store_path;
    }

    public static function saveOriginalImage($file, Model $object, string $subfolder)
    {
        $fullname = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
        $filename = str_replace(' ', '_', $fullname);
        $extension = $file->getClientOriginalExtension();
        $store_path =  $file->storeAs($subfolder, $filename . '.' . $extension, 'images');
        $path = public_path('storage/images/' . $store_path);
        $image = InterventionImage::make($path);

        try {
            $image->save($path);
            return $subfolder . $fullname . '.' . $extension;
        }
        catch (\Exception $e)
        {
            return response()->json($e);
        }
    }
}

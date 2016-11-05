<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Storage;
use Image;
class FileUpload extends Model {

    private static function generateFolderPath() {
        
		$folderPath         = date("Y")."/".intval(date("m"))."/";
		return $folderPath;
	}
	
    /**
     * Make a Filename, based on the uploaded file.
     *
     * @return string
     */
    private static function generateFilename($fileObj) {

        // Get the file name original name
        // and encrypt it with sha1
        $name = sha1 (
            time() . $fileObj->getClientOriginalName()
        );

        // Get the extension of the photo.
        $extension = $fileObj->getClientOriginalExtension();

        // Then set name = merge those together.
        return "{$name}.{$extension}";
    }

    /**
     * get filename with full path
     * save this path to db and folder
     * @return string
     */
    public static function generateFilepath($fileObj) {

        $folderPath =   self::generateFolderPath();
        $ret        =   $folderPath. self::generateFilename($fileObj);
        return $ret;
    }
    
    /**
     * display file path with filename 
     * for viewing
     * @return string
     */
    public static function getFilepath($fileObj) {

        //make condition here....
        $ret        =   $fileObj->filepath;
        return $ret;
    }
    
    /*
     * upload orifinal file
     */
    public static function uploadFile($file) {
			$filenameToSave     =   self::generateFilename($file);
            $filePathToStore    =   self::generateFilepath($file);
            \Storage::disk('news')->put($filePathToStore,  \File::get($file));//big file
            //TODO :: will make thumbnail...
        return "/uploads/".$filePathToStore;
    }
    
    /* upload image and create thumbnail and store into db and update db
     */
    public static function uploadFileAndThumbnail($file) {
        $filePathToStore = null;
        $filenameToSave     =   self::generateFilename($file);
        $filePathToStore    =   self::generateFilepath($file);
        $path = self::uploadFile($file);
        self::generateThumbs($filePathToStore, $filenameToSave, \File::get($file));
		return $path;
    }
    
    private static function generateThumbs($originalFilepath, $originalFilename, $fileObj) {
        $size = \Config::get('app.thumbSize');
        if(isset($size)) {
            $fileSizes = $size;
            foreach ($fileSizes as $k => $fileSize) {
                $destination = str_replace($originalFilename, $k."_".$originalFilename, $originalFilepath);
                $img = Image::make($fileObj)
                    ->resize($fileSize[0], $fileSize[1]);
                Storage::disk('news')->put($destination, $img->stream());
            }
        }
   }
}
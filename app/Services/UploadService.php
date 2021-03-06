<?php

namespace App\Services;

use Illuminate\Support\Facades\Storage;
use App\Models\File;
use App\Helpers\FileHelper;
use Image;
use App\Models\User;

/**
 * Service manages file upload routine.
 *
 * Class UploadFileService
 * @package App\Services
 */

class UploadService
{

    /**
     * Uploads base64 encoded files and saves file polymorphic relation to database.
     *
     * @param $request
     * @param $entity
     * @param null $file
     * @param string $field_name
     * @return array
     */
    public function base64Upload($request, $entity, $file = null, $field_name = 'base64_files')
    {
        $base64Files = $request->get($field_name, []);
        $files = [];

        foreach ($base64Files as $base64File) {
            // Parses base64 encoded string
            $parsedFile = FileHelper::parse_encoded_base64($base64File, true);
            $hashName = FileHelper::hashName($parsedFile['extension']);
            $path = FileHelper::storagePath($entity) . $hashName;
            $disk = Storage::disk(config('filesystem.default'));
            // Stores file to disk
            $stored = $disk->put($path, $parsedFile['data']);
            if ($stored) {
                // Saves file to database
                if (is_null($file)) {
                    $file = new File();
                }
                $file->original_name = $request->get('file_name');
                $file->mime = $disk->mimeType($path);
                $file->name = $hashName;
                $file->field_name = $field_name;
                $file->entity_id = $entity->id;
                $file->entity_type = $entity->entity_type;

                if ($file->save()) {
                    $files[] = $file;
                    $file = null;
                }
            }
        }

        return $files;
    }

    /**
     * Uploads and manages user avatar.
     *
     * @param $request
     * @param $entity
     */
    public function base64UploadAvatar($request, $entity)
    {
        $field_name = User::AVATAR_FIELD_NAME;
        $files = $request->get($field_name, null);

        if (is_array($files) && !empty($files)) { // Creates or updates avatar if files array not empty
            if ($entity->avatar) {
                // Removes old avatar
                FileHelper::delete($entity->avatar);
                // Uploads new avatar and updates old file instance
                $this->base64Upload($request, $entity, $entity->avatar, $field_name);
            } else {
                // Uploads new avatar and creates new file instance
                $this->base64Upload($request, $entity, null, $field_name);
            }
        } else if (is_array($files) && empty($files)) { // Removes avatar if files array empty
            if ($entity->avatar) {
                FileHelper::delete($entity->avatar);
                $entity->avatar->delete();
            }
        }
    }

    /**
     * Uploads and manages user avatar.
     *
     * @param $request
     * @param $entity
     */
    public function base64UploadLandscape($request, $entity)
    {
        $field_name = User::LANDSCAPE_FIELD_NAME;
        $files = $request->get($field_name, null);

        if (is_array($files) && !empty($files)) { // Creates or updates avatar if files array not empty
            if ($entity->landscape) {
                // Removes old avatar
                FileHelper::delete($entity->landscape);
                // Uploads new avatar and updates old file instance
                $this->base64Upload($request, $entity, $entity->landscape, $field_name);
            } else {
                // Uploads new avatar and creates new file instance
                $this->base64Upload($request, $entity, null, $field_name);
            }
        } else if (is_array($files) && empty($files)) { // Removes avatar if files array empty
            if ($entity->avatar) {
                FileHelper::delete($entity->landscape);
                $entity->avatar->delete();
            }
        }
    }

    /**
     * Uploads binary data files and saves file polymorphic relation to database.
     *
     * @param $request
     * @param $entity
     * @param null $file
     * @param string $field
     * @return array
     */
    public function upload($request, $entity, $file = null, $field = 'file')
    {
        $uploadedFiles = $request->file($field);
        $files = [];

        if (!is_null($uploadedFiles)) {

            if (is_array($uploadedFiles)) {
                foreach ($uploadedFiles as $uploadedFile) {
                    $files[] = $this->store($uploadedFile, $entity, $file);
                }
            } else {
                $files[] = $this->store($uploadedFiles, $entity, $file);
            }

        }

        return $files;
    }

    /**
     * Stores file to disk and database
     *
     * @param $uploadedFile
     * @param $entity
     * @param null $file
     * @param string $field_name
     * @return File|null
     */
    public function store($uploadedFile, $entity, $file = null, $field_name = File::FILE_FIELD_NAME) {
        $path = FileHelper::storagePath($entity);
        // Stores file to disk
        $uploadedFile->store($path);
        // Saves file to database
        if (is_null($file)) {
            $file = new File();
        } else {
            FileHelper::delete($file);
        }
        $file->mime = $uploadedFile->getClientMimeType();
        $file->original_name = $uploadedFile->getClientOriginalName();
        $file->name = $uploadedFile->hashName();
        $file->entity_id = $entity->id;
        $file->entity_type = $entity->entity_type;
        $file->field_name = $field_name;

        if ($file->save()) {
            $files[] = $file;
        }

        return $file;
    }

    /**
     * Uploads and manages user avatar.
     *
     * @param $request
     * @param $entity
     * @param string $field
     * @return array
     */
    public function uploadAvatar($request, $entity, $field = 'avatar')
    {
        $uploadedFile = $request->file($field, null);

        if (!empty($uploadedFile)) { // Creates or updates avatar if file not empty
            if ($entity->avatar) {
                // Removes old avatar
                FileHelper::delete($entity->avatar);
                FileHelper::deleteThumb($entity->avatar);
                // Uploads new avatar and updates old file instance
                $files = $this->upload($request, $entity, $entity->avatar, $field);
            } else {
                // Uploads new avatar and creates new file instance
                $files = $this->upload($request, $entity, null, $field);
            }
            if (!empty($files)) {
                $avatar = array_shift($files);
                // Creates thumbnail for avatar
                $destination = storage_path('app' . '/' . FileHelper::storageThumbPath($entity));
                if (!is_dir($destination)) {
                    mkdir($destination, 0755, true);
                }

                $destination .=  $avatar->name;

                $this->fit($uploadedFile, $destination, File::THUMBNAIL_WIDTH);
            }

            return $files;
        }
    }

    /**
     * Fits size of the image to width
     *
     * @param $source
     * @param $destination
     * @param $width
     */
    public function fit($source, $destination, $width)
    {
        $img = Image::make($source);
        $img->fit($width);
        $img->save($destination);
    }

}
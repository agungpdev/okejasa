<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;

class UploadFileService
{
    public function uploadImage(UploadedFile $file, string $path, ?string $fileName = null): ?string
    {
        // Upload file to storage
        return $file->storeAs($path, $fileName, 'public');

    }

    public function generateGroupNameFile($photos)
    {
        $filenames = [];
        foreach ($photos as $foto) {
            $filename = pathinfo($foto->getClientOriginalName(), PATHINFO_FILENAME);
            $extension = $foto->getClientOriginalExtension();
            $file = "{$filename}_" . time() . ".{$extension}";

            $filenames[] = $file;
        }

        return $filenames;
    }

    public function generateNameFile($foto)
    {
        $oriname = pathinfo($foto->getClientOriginalName(), PATHINFO_FILENAME);
        $extension = $foto->getClientOriginalExtension();
        $filename = "{$oriname}_" . time() . ".{$extension}";

        return $filename;
    }
}

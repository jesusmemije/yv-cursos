<?php


namespace App\Traits;


use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use File;
use Intervention\Image\Facades\Image;
use Vimeo\Vimeo;

trait ImageSaveTrait
{
    private function saveImageFromUrl($destination, $imageUrl, $width = null, $height = null, $mode = 'resize')
    {
        // Descarga la imagen en memoria
        $imageContents = file_get_contents($imageUrl);
        if (!$imageContents) {
            Log::error("Failed to download image from URL: " . $imageUrl);
            return null;
        }

        // Crea un nombre de archivo único
        $fileName = time() . '-' . Str::random(10) . '.' . pathinfo($imageUrl, PATHINFO_EXTENSION);

        // Crea un archivo temporal
        $tmpFile = tempnam(sys_get_temp_dir(), $fileName);
        file_put_contents($tmpFile, $imageContents);

        // Utiliza el método saveImage para guardar la imagen
        $path = $this->saveImage($destination, new \Illuminate\Http\File($tmpFile), $width, $height, $mode);

        // Verifica si el archivo temporal existe antes de intentar eliminarlo
        if (file_exists($tmpFile)) {
            unlink($tmpFile);
        }

        return $path;
    }

    private function saveImage($destination, $attribute , $width = NULL, $height = NULL, $mode = 'resize'): string
    {
        if (!File::isDirectory(base_path().'/public/uploads/'.$destination)){
            File::makeDirectory(base_path().'/public/uploads/'.$destination, 0777, true, true);
        }

        if ($attribute->extension() == 'svg'){
            $file_name = time().Str::random(10).'.'.$attribute->extension();
            $path = 'uploads/'. $destination .'/' .$file_name;
            $attribute->move(public_path('uploads/' . $destination .'/'), $file_name);
            return $path;
        }

        $img = Image::make($attribute);
        if ($width != null && $height != null && is_int($width) && is_int($height)) {
            if ($mode == 'resize') {
                $img->resize($width, $height, function ($constraint) {
                    $constraint->aspectRatio();
                });
            } else if ($mode == 'fit') {
                $img->fit($width, $height, function ($constraint) {
                    $constraint->upsize();
                }, 'center');
            }
        }

        $returnPath = 'uploads/'. $destination .'/' . time().'-'. Str::random(10) . '.' . $attribute->extension();
        $savePath = base_path().'/public/'.$returnPath;
        $img->save($savePath);
        return $returnPath;
    }

    private function updateImage($destination, $new_attribute, $old_attribute , $width = NULL, $height = NULL): string
    {
        if (!File::isDirectory(base_path().'/public/uploads/'.$destination)){
            File::makeDirectory(base_path().'/public/uploads/'.$destination, 0777, true, true);
        }

        if ($new_attribute->extension() == 'svg'){
            $file_name = time().Str::random(10).'.'.$new_attribute->extension();
            $path = 'uploads/'. $destination .'/' .$file_name;
            $new_attribute->move(public_path('uploads/' . $destination .'/'), $file_name);
            File::delete($old_attribute);
            return $path;
        }

        $img = Image::make($new_attribute);
        if ($width != null && $height != null && is_int($width) && is_int($height)) {
            $img->resize($width, $height, function ($constraint) {
                $constraint->aspectRatio();
            });
        }

        $returnPath = 'uploads/'. $destination .'/' . time().'-'. Str::random(10) . '.' . $new_attribute->extension();
        $savePath = base_path().'/public/'.$returnPath;
        $img->save($savePath);
        File::delete($old_attribute);
        return $returnPath;
    }

    /*
     * uploadFile not used
     */
    private function uploadFile($destination, $attribute)
    {
        if (!File::isDirectory(base_path().'/public/uploads/'.$destination)){
            File::makeDirectory(base_path().'/public/uploads/'.$destination, 0777, true, true);
        }

        $file_name = time().Str::random(10).'.'.$attribute->extension();
        $path = 'uploads/'. $destination .'/' .$file_name;

        try {
            if (env('STORAGE_DRIVER') == 's3' ) {
                $data['is_uploaded'] = Storage::disk('s3')->put($path, file_get_contents($attribute->getRealPath()));
            }else if(env('STORAGE_DRIVER') == 'wasabi' ) {
                $data['is_uploaded'] = Storage::disk('wasabi')->put($path, file_get_contents($attribute->getRealPath()));
            }else if(env('STORAGE_DRIVER') == 'vultr' ) {
                $data['is_uploaded'] = Storage::disk('vultr')->put($path, file_get_contents($attribute->getRealPath()));
            } else {
                $attribute->move(public_path('uploads/' . $destination .'/'), $file_name);
            }
        } catch (\Exception $e) {
            //
        }

        return $path;
    }

    private function uploadFileWithDetails($destination, $attribute)
    {
        if (!File::isDirectory(base_path().'/public/uploads/'.$destination)){
            File::makeDirectory(base_path().'/public/uploads/'.$destination, 0777, true, true);
        }

        $data['is_uploaded'] = false;

        if ($attribute == null || $attribute == '') {
            return $data;
        }

        $data['original_filename'] = method_exists($attribute, 'getClientOriginalName') ? $attribute->getClientOriginalName() : basename($attribute->getPathname());
        $file_name = time().Str::random(10).'.'.pathinfo($data['original_filename'], PATHINFO_EXTENSION);
        $data['path'] = 'uploads/'. $destination .'/' .$file_name;

        try {
            if (env('STORAGE_DRIVER') == 's3' ) {
                $stream = fopen($attribute->getPathname(), 'r+');
                $data['is_uploaded'] = Storage::disk('s3')->put($data['path'], $stream, 'public');
                if (is_resource($stream)) {
                    fclose($stream);
                }
            }else if(env('STORAGE_DRIVER') == 'wasabi' ) {
                $data['is_uploaded'] = Storage::disk('wasabi')->put($data['path'], file_get_contents($attribute->getRealPath()));
                $data['is_uploaded'] = true;
            }else if(env('STORAGE_DRIVER') == 'vultr' ) {
                $data['is_uploaded'] = Storage::disk('vultr')->put($data['path'], file_get_contents($attribute->getRealPath()));
                $data['is_uploaded'] = true;
            } else {
                $attribute->move(public_path('uploads/' . $destination .'/'), $file_name);
                $data['is_uploaded'] = true;
            }
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }

        return $data;
    }
    
    private function uploadFontInLocal($destination, $attribute, $name)
    {
        if (!File::isDirectory(base_path().'/public/uploads/'.$destination)){
            File::makeDirectory(base_path().'/public/uploads/'.$destination, 0777, true, true);
        }

        $data['is_uploaded'] = false;

        if ($attribute == null || $attribute == '') {
            return $data;
        }

        $data['path'] = 'uploads/'. $destination .'/' .$name;

        try {
            $attribute->move(public_path('uploads/' . $destination .'/'), $name);
            $data['is_uploaded'] = true;
        } catch (\Exception $e) {
            Log::info($e->getMessage());
        }

        return $data;
    }


    private function deleteFile($path)
    {
        if ($path == null || $path == '') {
            return null;
        }

        try {
            if (env('STORAGE_DRIVER') == 's3') {
                Storage::disk('s3')->delete($path);
            } else {
                File::delete($path);
            }
        } catch (\Exception $e) {
            //
        }

        File::delete($path);
    }

    private function deleteVideoFile($path)
    {
        if ($path == null || $path == '') {
            return null;
        }

        try {
            if (env('STORAGE_DRIVER') == 's3') {
                Storage::disk('s3')->delete($path);
            } else {
                File::delete($path);
            }
        } catch (\Exception $e) {
            //
        }

        File::delete($path);

    }

    private function deleteVimeoVideoFile($file)
    {
        if ($file == null || $file == '') {
            return null;
        }

        try {
            $client = new Vimeo(env('VIMEO_CLIENT'), env('VIMEO_SECRET'),env('VIMEO_TOKEN_ACCESS'));
            $path = '/videos/' . $file;
            $client->request($path, [], 'DELETE');
        } catch (\Exception $e)  {
            //
        }
    }

    private function uploadVimeoVideoFile($title, $file)
    {
        $path = '';
        if ($file == null || $file == '') {
            return $path;
        }

        try {
            $client = new Vimeo(env('VIMEO_CLIENT'), env('VIMEO_SECRET'),env('VIMEO_TOKEN_ACCESS'));

            $uri = $client->upload($file, array(
                "name" => $title,
                "description" => "The description goes here."
            ));

            $response = $client->request($uri . '?fields=link');
            $response = $response['body']['link'];

            $str = $response;
            $vimeo_video_id = explode("https://vimeo.com/",$str);
            $path = null;
            if(count($vimeo_video_id))
            {
                $path = $vimeo_video_id[1];
            }
        } catch (\Exception $e) {
            //
        }

        return $path;

    }

    private function downloadAndProcessVideo($videoUrl) 
    {
        // Descargar el video
        $tempPath = tempnam(sys_get_temp_dir(), 'video_');
        file_put_contents($tempPath, fopen($videoUrl, 'r'));
    
        // Obtener la extensión del archivo desde el URL
        $extension = pathinfo(parse_url($videoUrl, PHP_URL_PATH), PATHINFO_EXTENSION);
    
        // Obtener la duración del video usando ffprobe
        $command = "ffprobe -v error -show_entries format=duration -of default=noprint_wrappers=1:nokey=1 {$tempPath}";
        $duration = shell_exec($command);
    
        return ['tempPath' => $tempPath, 'duration' => (float)$duration, 'extension' => $extension];
    }

    private function saveFileFromUrl($url, $destination) 
    {
        try {
            // Inicializa cURL
            $ch = curl_init($url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
            curl_setopt($ch, CURLOPT_HEADER, 1);
            curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true); // Permite que cURL siga las redirecciones
            curl_setopt($ch, CURLOPT_MAXREDIRS, 5); // Establece un máximo de 5 redirecciones

            $response = curl_exec($ch);

            if (!$response) {
                Log::error("Failed to download file from URL: $url");
                return ['is_uploaded' => false, 'path' => null];
            }

            // Separar cabeceras y contenido
            $header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
            $headers = substr($response, 0, $header_size);
            $fileContents = substr($response, $header_size);

            if (empty($fileContents)) {
                Log::error("Downloaded file content is empty: $url");
                return ['is_uploaded' => false, 'path' => null];
            }

            curl_close($ch);

            // Buscar nombre de archivo en las cabeceras
            $fileName = null;
            if (preg_match('/filename="([^"]+)"/', $headers, $matches)) {
                $fileName = $matches[1];
            } else {
                // Si no se encuentra, asignar un nombre genérico con extensión .pdf
                $fileName = time() . '-downloaded_file.pdf';
            }

            $tempPath = tempnam(sys_get_temp_dir(), 'file');
            $tempPathWithExtension = $tempPath . '.' . pathinfo($fileName, PATHINFO_EXTENSION);
            rename($tempPath, $tempPathWithExtension);

            file_put_contents($tempPathWithExtension, $fileContents);
            
            // Crea un objeto File para ser compatible con uploadFileWithDetails
            $file = new \Illuminate\Http\File($tempPathWithExtension);
            
            // Usar la función existente para manejar la carga de archivos
            $uploadDetails = $this->uploadFileWithDetails($destination, $file);
            
            // Eliminar el archivo temporal
            unlink($tempPathWithExtension);
            
            return $uploadDetails;
        } catch (\Exception $e) {
            Log::error("Failed to download and process file: " . $e->getMessage());
            return ['is_uploaded' => false, 'path' => null];
        }
    }

}

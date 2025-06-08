<?php

namespace App\Jobs;

use App\Events\ImportProgressUpdated;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\Course_lesson;
use App\Models\Course_lecture;
use Illuminate\Support\Facades\Log;
use App\Traits\ImageSaveTrait;
use Illuminate\Support\Facades\Event;

class ProcessImportChunk implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels, ImageSaveTrait;

    protected $rows;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($rows)
    {
        $this->rows = $rows;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        set_time_limit(600); // Ajusta el tiempo máximo de ejecución a 10 minutos

        $errors = [];
        
        foreach ($this->rows as $index => $rowData) {
            try {
                $lesson = Course_lesson::firstOrCreate(
                    [
                        'course_id' => $rowData['course_id'],
                        'name' => $rowData['lesson_name']
                    ],
                    [
                        'short_description' => null // Asumiendo que no hay descripción corta en el archivo CSV
                    ]
                );
    
                // Crear la conferencia basada en el tipo de contenido
                $lecture = new Course_lecture([
                    'course_id' => $rowData['course_id'],
                    'lesson_id' => $lesson->id,
                    'title' => $rowData['lecture_name'],
                    'lecture_type' => $rowData['lecture_type'],
                    'type' => $rowData['type'],
                ]);
    
                // Según el tipo, procesar el contenido de la conferencia
                if ($rowData['type'] == 'video') {
                    $this->importLectureVideo($lecture, $rowData['video_url']);
                } elseif ($rowData['type'] == 'text') {
                    $lecture->text = $rowData['text'];
                } elseif ($rowData['type'] == 'pdf') {
                    $file_details = $this->saveFileFromUrl($rowData['pdf'], 'lecture');
                    if ($file_details['is_uploaded']) {
                        $lecture->pdf = $file_details['path'];
                    }
                }
    
                $lecture->save();
            } catch (\Exception $e) {
                $errors[] = "Error at row $index: " . $e->getMessage();
                Log::error('Error importing row: ' . json_encode($rowData) . ' Error: ' . $e->getMessage());
            }

            // Emitir un evento con el progreso actualizado
            $progress = ($index + 1) / count($this->rows) * 100;
            Event::dispatch(new ImportProgressUpdated($progress));
        }

        if (!empty($errors)) {
            Log::error('Errors encountered during import: ' . implode("\n", $errors));
            // O enviar una notificación al usuario con los errores
        }
    }

    private function importLectureVideo($lecture, $videoUrl = null)
    {
        if ($videoUrl) {
            $downloadedVideo = $this->downloadAndProcessVideo($videoUrl);
            $file_duration_second = $downloadedVideo['duration'];
        
            // Renombrar el archivo temporal para incluir la extensión correcta
            $tempPathWithExtension = $downloadedVideo['tempPath'] . '.' . $downloadedVideo['extension'];
            rename($downloadedVideo['tempPath'], $tempPathWithExtension);

            // Procesa y guarda el video en el sistema de archivos
            $file_details = $this->uploadFileWithDetails('video', new \Illuminate\Http\File($tempPathWithExtension));
            if ($file_details['is_uploaded']) {
                $lecture->file_path = $file_details['path'];
                $lecture->file_duration_second = (int)$file_duration_second;
                $lecture->file_duration = gmdate("i:s", $file_duration_second);
            }
            
            // Eliminar el archivo temporal
            unlink($tempPathWithExtension);
        }
    }    
}

<?php

namespace App\Jobs;

use Illuminate\Support\Facades\Config;
use Intervention\Image\Facades\Image;
use Spatie\MediaLibrary\Conversions\FileManipulator;
use Spatie\MediaLibrary\Conversions\ImageGenerators\Image as ImageGenerator;
use Spatie\MediaLibrary\Conversions\Jobs\PerformConversionsJob as BasePerformConversions;

class PerformConversions extends BasePerformConversions
{
    public function handle(FileManipulator $fileManipulator): bool
    {
        // Conversion Done...
        if ($this->media->getCustomProperty('status') == 'processed') {
            // Skipped Processing Media File
            return parent::handle($fileManipulator);
        }

        $this->media->setCustomProperty('status', 'processing')->save();

        try {
            if ($this->isImage()) {
                $path = $this->processImage();
            }
             else {
                $path = null;
            }
            $this->processingDone($path);
        } catch (\Throwable $e) {
            $this->processingFailed();
        }

        return true;
    }

    /**
     * Determine if the media file is an image.
     *
     * @return bool
     */
    protected function isImage()
    {
        return (new ImageGenerator())->canHandleMime($this->media->mime_type);
    }

    /**
     * Process Image File.
     *
     * @return null
     */
    protected function processImage()
    {
        $image = Image::make($this->media->getPath())->orientate();

        $this->media
            ->setCustomProperty('type', 'image')
            ->setCustomProperty('width', $image->width())
            ->setCustomProperty('height', $image->height())
            ->setCustomProperty('ratio', (string) round($image->width() / $image->height(), 3))
            ->save();
    }

    /**
     * @return \Closure
     */
    protected function increaseProcessProgress(): \Closure
    {
        return function (
            $file,
            $format,
            $percentage
        ) {
            // Progress Percentage is $percentage
            $this->media->setCustomProperty('progress', $percentage);
            $this->media->save();
        };
    }

    /**
     * @param null $processedFilePath
     * @throws \Exception
     * @return null
     */
    protected function processingDone($processedFilePath = null)
    {
        $oldMedia = $this->media;

        $model = $oldMedia->model;

        // If the processing does not ended with generating a new file.
        if (is_null($processedFilePath)) {
            $oldMedia->setCustomProperty('status', 'processed')
                ->setCustomProperty('progress', 100)
                ->save();
        } else {

            $model
                ->addMedia($processedFilePath)
                ->withCustomProperties([
                    'type' => $oldMedia->getCustomProperty('type'),
                    'status' => 'processed',
                    'progress' => 100,
                    'duration' => 0,
                ])
                ->preservingOriginal()
                ->toMediaCollection($oldMedia->collection_name);

            $oldMedia->delete();
        }
    }

    /**
     * Mark media status as failed.
     */
    protected function processingFailed()
    {
        $media = $this->media;

        $media->setCustomProperty('status', 'failed')->save();
    }

    /**
     * @param null $extension
     * @return string
     */
    protected function generatePathForProcessedFile($extension = null)
    {
        $path = $this->media->getPath();

        return pathinfo($path, PATHINFO_DIRNAME)
            .DIRECTORY_SEPARATOR.pathinfo($path, PATHINFO_FILENAME)
            .'.processed.'.$extension;
    }
}

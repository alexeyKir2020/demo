<?php

namespace App\Models\Traits;

use App\Models\TemporaryFile;
use App\Transformers\MediaResource;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Config;

trait HasUploader
{
    /**
     * Assign all uploaded temporary files to the model.
     *
     * @param string|array|null $tokens
     * @param string|null $collection
     * @return void
     */
    public function addAllMediaFromTokens($tokens = null, $collection = null)
    {
        $tokens = Arr::wrap($tokens);

        if (count($tokens) == 0) {
            $tokens = Arr::wrap(request('media'));
        }

        $query = TemporaryFile::query();

        if ($collection) {
            $query->where('collection', $collection);
        }

        $query->whereIn('token', $tokens)
            ->each(function (TemporaryFile $file) {
                foreach ($file->getMedia($file->collection) as $media) {
                    $media->forceFill([
                        'model_type' => $this->getMorphClass(),
                        'model_id' => $this->getKey(),
                    ])->save();

                    if (Config::get('laravel-media-uploader.regenerate-after-assigning')) {
                        Artisan::call('media-library:regenerate', [
                            '--ids' => $media->id,
                        ]);
                    }
                }

                $file->delete();
            });
    }

    /**
     * Get all the model media of the given collection using "MediaResource".
     *
     * @param string $collection
     * @return \Illuminate\Support\Collection
     */
    public function getMediaResource($collection = 'default')
    {
        return collect(
            MediaResource::collection(
                $this->getMedia($collection)
            )->jsonSerialize()
        );
    }
}

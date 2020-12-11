<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Config;
use Spatie\MediaLibrary\Conversions\ImageGenerators\Image;

class MediaRule implements Rule
{
    /**
     * @var array
     */
    private $types;

    /**
     * Create a new rule instance.
     *
     * @param $types
     */
    public function __construct(...$types)
    {
        $this->types = $types;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param UploadedFile|mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        if (! $value instanceof UploadedFile) {
            return false;
        }

        try {
            $type = $this->getTypeString($value);
        } catch (\Throwable $e) {
            return false;
        }

        return in_array($type, $this->types);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('uploader::validation.invalid');
    }

    /**
     * @param UploadedFile|mixed $value
     * @return string
     */
    protected function getTypeString($value): string
    {
        $fileFullPath = $value->getRealPath();

        if ((new Image())->canHandleMime($value->getMimeType())) {
            $type = 'image';
        } else {
            return 'image';
        }

        return $type; // either: image, video or audio.
    }

}

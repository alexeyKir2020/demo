<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class MediaResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'url' => $this->getFullUrl(),
            'preview' => $this->getPreviewUrl(),
            'name' => $this->name,
            'file_name' => $this->file_name,
            'type' => $this->getType(),
            'mime_type' => $this->mime_type,
            'size' => $this->size,
            'human_readable_size' => $this->human_readable_size,
            'details' => $this->mediaDetails(),
            'status' => $this->mediaStatus(),
            'progress' => $this->when($this->mediaStatus() == 'processing', $this->getCustomProperty('progress')),
            'conversions' => $this->when(! empty($this->getConversions()),
                $this->getConversions()
            ),
            'links' => [
                'delete' => [
                    'href' => url('api/uploader/media/'.$this->getRouteKey()),
                    'method' => 'DELETE',
                ],
            ],
        ];
    }

    /**
     * Get the generated conversions links.
     *
     * @return array
     */
    public function getConversions()
    {
        $results = [];

        foreach (array_keys($this->getGeneratedConversions()->toArray()) as $conversion) {
            $results[$conversion] = $this->getFullUrl($conversion);
        }

        return $results;
    }


    /**
     * Determine if the media type is image.
     *
     * @return bool
     */
    public function isImage()
    {
        return $this->getType() == 'image';
    }


    /**
     * Get the media type.
     *
     * @return mixed|string
     */
    public function getType()
    {
        return $this->getCustomProperty('type') ?: $this->type;
    }

    /**
     * Get the preview url.
     *
     * @return string|void
     */
    public function getPreviewUrl()
    {
        if ($this->getType() == 'image') {
            return $this->getFullUrl();
        }

        return '/img/attach.png';
    }

    /**
     * @return array
     */
    protected function mediaDetails(): array
    {
        $duration = (float) $this->getCustomProperty('duration');

        return [
            $this->mergeWhen($this->isImage(), [
                'width' => $this->getCustomProperty('width'),
                'height' => $this->getCustomProperty('height'),
                'ratio' => (float) $this->getCustomProperty('ratio'),
            ]),
            'duration' => null,
        ];
    }

    /**
     * @return mixed
     */
    protected function mediaStatus()
    {
        return $this->getCustomProperty('status');
    }
}

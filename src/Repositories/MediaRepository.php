<?php

namespace Dawnstar\Repositories;

use Dawnstar\Contracts\MediaInterface;

class MediaRepository implements MediaInterface
{
    public function syncMedias($model, array $medias = []): void
    {
        foreach ($medias as $key => $mediaIds) {

            if (is_null($mediaIds)) {
                $mediaIds = [];
            } else {
                $mediaIds = explode(',', $mediaIds);
            }

            $temp = [];

            $order = 0;
            foreach ($mediaIds as $mediaId) {
                $temp[$mediaId] = [
                    'model_type' => $model::class,
                    'model_id' => $model->id,
                    'media_id' => $mediaId,
                    'key' => $key,
                    'order' => ++$order
                ];
            }

            $model->medias()->wherePivot('key', $key)->sync($temp);
        }
    }
}

<?php

namespace App\Services\Content;

use Awcodes\Curator\Models\Media;
use Illuminate\Database\Eloquent\Collection;

class MediaService{
    public static function getMediaByIds(array $ids): Collection|array{
        $data = Media::query()->whereIn('id',$ids)->get();

        if ($data){
            $temp = [];

            foreach ($data as $item){
                $temp[$item->id] = $item;
            }

            $data = $temp;
        }

        return $data;
    }

    public static function getMediaUrl($mediaId)
    {
        if (!$mediaId) {
            return null;
        }
        
        $media = Media::find($mediaId);
        return $media ? '/storage/' . $media->path : null;
    }
}

<?php

namespace App;

use Illuminate\Support\Facades\Http;

trait YoutubeVideoResponseTrait
{
    public function videoLists()
    {
        $part = 'snippet';
        $apiKey = config('services.youtube.api_key');
        $channelID = config('services.youtube.channel_id');
        $maxResults = 2000;
        $youtubeEndPoint = config('services.youtube.search_endpoint');
        
        $type = 'vedio';
        $url = $youtubeEndPoint.'?order=date&part='.$part.'&channelId='.$channelID.'&maxResults='.$maxResults.'&type='.$type.'&key='.$apiKey;
        $response = Http::get($url);
        //return $response->body();
        //$response = file_get_contents( $url );
        $result     = json_decode( $response );
       
        foreach ( $result->items as $item ) {
            if ( $item->id->kind === 'youtube#video' ) {
                $video_id  = $item->id->videoId;
                $title     = $item->snippet->title;
                $thumbnail = '';
                if ( isset( $item->snippet->thumbnails->maxres ) ) {
                    $thumbnail = $item->snippet->thumbnails->maxres->url;
                } elseif ( isset( $item->snippet->thumbnails->standard ) ) {
                    $thumbnail = $item->snippet->thumbnails->standard->url;
                } elseif ( isset( $item->snippet->thumbnails->medium ) ) {
                    $thumbnail = $item->snippet->thumbnails->medium->url;
                }
                $videos[] = [
                    'videoId'   => $video_id,
                    'title'     => $title,
                    'thumbnail' => $thumbnail,
                ];
            }
        }
       
        return $videos;
    }
}

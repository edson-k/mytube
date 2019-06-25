<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Cache;
use Alaouy\Youtube\Facades\Youtube;

class SearchController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index() {
        return view('search');
    }

     /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function go(Request $request) {
        $input = $request->all();

        $expiration = 60 * 24 * 7; //minutos * horas * dias
        $key = "search_".str_replace(' ', '_', strip_tags(strtolower(stripAccents($input['q']))));

        // Cache::forget($key);

        $search = Cache::remember($key, $expiration, function() use ($input) {
            // Set default parameters
            $params = [
                'q'             => $input['q'],
                'type'          => 'video',
                'part'          => 'id, snippet',
                'maxResults'    => 50
            ];

            // An array to store page tokens so we can go back and forth
            $pageTokens = [];

            // Make inital search {50}
            $search = Youtube::paginateResults($params, null);

            // Store token
            $pageTokens[] = $search['info']['nextPageToken'];

            // Go to next page in result {50}
            $search = Youtube::paginateResults($params, $pageTokens[0]);

            // Merge results
            $searchResult = array_merge($search['results'], $search['results']);

            // Store token
            $pageTokens[] = $search['info']['nextPageToken'];

            // Go to next page in result {50}
            $search = Youtube::paginateResults($params, $pageTokens[1]);

            // Merge results
            $searchResult = array_merge($searchResult, $search['results']);

            // Store token
            $pageTokens[] = $search['info']['nextPageToken'];

            // Go to next page in result {50}
            $search = Youtube::paginateResults($params, $pageTokens[2]);

            // Merge results
            $searchResult = array_merge($searchResult, $search['results']);
            
            return $searchResult;
        });

        $words = '';
        $videosList = array();
        $totalTime = 0;
        $cont=0;

        foreach ($search as $searchResult) {
            $expirationVideo = 60 * 24 * 366; //minutos * horas * dias
            $videoInfo = Cache::remember('video_'.$searchResult->id->videoId, $expirationVideo, function() use ($searchResult) {
                return Youtube::getVideoInfo($searchResult->id->videoId);
            });
            $totalTime +=ISO8601ToSeconds($videoInfo->contentDetails->duration);
            $words .= $searchResult->snippet->title . " " . $searchResult->snippet->description . " ";
            $videosList[$cont]['videoId'] = $searchResult->id->videoId;
            $videosList[$cont]['title'] = $searchResult->snippet->title;
            $videosList[$cont]['description'] = $searchResult->snippet->description;
            $videosList[$cont]['duration'] = ISO8601ToSeconds($videoInfo->contentDetails->duration)/60;
            $cont++;
        }

        $totalTime = secondsToTime($totalTime);

        //15, 120, 30, 150, 20, 40, 90
        $time_01 = $input['time_01'] ? floatval($input['time_01']) : 15.0;
        $time_02 = $input['time_02'] ? floatval($input['time_02']) : 120.0;
        $time_03 = $input['time_03'] ? floatval($input['time_03']) : 30.0;
        $time_04 = $input['time_04'] ? floatval($input['time_04']) : 150.0;
        $time_05 = $input['time_05'] ? floatval($input['time_05']) : 20.0;
        $time_06 = $input['time_06'] ? floatval($input['time_06']) : 40.0;
        $time_07 = $input['time_07'] ? floatval($input['time_07']) : 90.0;

        $time_controll = 0;
        $contTime = 1;
        $contDia = 1;
        $tTime = 0;

        for($i=0; $i<sizeof($videosList); $i++) {
            if($time_controll == 0) {
                echo "<h3>Dia ".(($contDia<10)?'0'.$contDia:$contDia)." - ".${"time_0".$contTime}." min</h3>";
            }
            if( ($time_controll+$videosList[$i]['duration']) <= ${"time_0".$contTime}) {
                $time_controll += $videosList[$i]['duration'];
                echo sprintf('<li><a href="https://www.youtube.com/watch?v='.$videosList[$i]['videoId'].'" target="_blank">%s</a> (%s) - %s</li>',
                $videosList[$i]['title'], $videosList[$i]['videoId'], gmdate("H:i:s",($videosList[$i]['duration']*60)));
                $tTime += $videosList[$i]['duration']*60;
            } else {
                if($time_controll == 0) {
                   echo "<li>nenhum video para este dia!</li>";
                }
                $time_controll = 0;
                $contDia++;
                if($contTime<7) { $contTime++; } else { $contTime = 1; }                
                $i--;
            }
        }
        $tTime = secondsToTime($tTime);
        echo "<h3>Total Time</h3>
        <ul><li>".$tTime."</li></ul>";

        echo "<h3>Total Dias</h3>
        <ul><li>".$contDia." dias</li></ul>";
        
        echo "<h3>5 Palavras mais utilizadas</h3><ul>";
        foreach (find_most_used_words($words) as $value) {
            echo "<li>".$value['word']."</li>";
        }
        echo "</ul>";

        // echo "<pre>";
        // var_dump();
        // echo "</pre>";
    }
}

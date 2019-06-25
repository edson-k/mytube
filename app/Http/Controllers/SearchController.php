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
        $cont=0;

        foreach ($search as $searchResult) {
            $expirationVideo = 60 * 24 * 366; //minutos * horas * dias
            $videoInfo = Cache::remember('video_'.$searchResult->id->videoId, $expirationVideo, function() use ($searchResult) {
                return Youtube::getVideoInfo($searchResult->id->videoId);
            });
            $words .= $searchResult->snippet->title . " " . $searchResult->snippet->description . " ";
            $videosList[$cont]['videoId'] = $searchResult->id->videoId;
            $videosList[$cont]['title'] = $searchResult->snippet->title;
            $videosList[$cont]['description'] = $searchResult->snippet->description;
            $videosList[$cont]['duration'] = ISO8601ToSeconds($videoInfo->contentDetails->duration)/60;
            $cont++;
        }

        $data = array();
        $data['videosList'] = $videosList;
        $data['q'] = $input['q'];
        $data['time_01'] = ($input['time_01']) ? floatval($input['time_01']) : 15.0;
        $data['time_02'] = $input['time_02'] ? floatval($input['time_02']) : 120.0;
        $data['time_03'] = $input['time_03'] ? floatval($input['time_03']) : 30.0;
        $data['time_04'] = $input['time_04'] ? floatval($input['time_04']) : 150.0;
        $data['time_05'] = $input['time_05'] ? floatval($input['time_05']) : 20.0;
        $data['time_06'] = $input['time_06'] ? floatval($input['time_06']) : 40.0;
        $data['time_07'] = $input['time_07'] ? floatval($input['time_07']) : 90.0;
        $data['find_most_used_words'] = find_most_used_words($words, ($input['q_start']?$input['q_start']:4));

        return view('result', array('data' => $data));
    }
}

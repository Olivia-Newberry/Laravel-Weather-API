<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;

class ApiWeatherController extends Controller
{
    /**
     * Executes the curl request to get the weather data
     * @param  string $url
     * @return string Response
     */
    public function curlRequest($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        try {
            $output = curl_exec($ch);
            curl_close($ch);
            return $output;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Function that drives the API calls to weatherapi.com
     *
     * @return \Illuminate\Http\Response
     */
    public function get_weather(Request $request)
    {
        $query = $request->query('query');
        $url = env('WEATHER_URL').'current.json?key='.env('WEATHER_KEY').'&q=' . $query;
        $data = $this->curlRequest($url);
        $data = json_decode($data);
        return response()->json($data);
    }

    /**
     * Function that returns a list of locations based on the query value
     *
     * @return \Illuminate\Http\Response
     */
    public function get_locations(Request $request)
    {
        $query = $request->query('query');
        $url = env('WEATHER_URL').'search.json?key='.env('WEATHER_KEY').'&q=' . $query;
        $data = $this->curlRequest($url);
        $data = json_decode($data);
        return response()->json($data);
    }
}

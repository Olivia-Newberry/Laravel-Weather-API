<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;

class ApiWeatherController extends Controller
{
    /**
     * Executes the curl request to get the weather data
     *
     * @param  string $url
     * @return string Response
     */
    private function curlRequest($url)
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
     * Get weather data from the API
     *
     * @return \Illuminate\Http\Response
     */
    public function get_weather(Request $request)
    {
        $validator = Validator::make($request->only('token','query'), [
            'token' => 'required|string',
            'query' => 'required|string|min:3'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        $query = $request->query('query');
        $url = env('WEATHER_URL').'current.json?key='.env('WEATHER_KEY').'&q=' . $query;
        $data = $this->curlRequest($url);
        $data = json_decode($data);
        return response()->json($data);
    }

    /**
     * List all the locations
     *
     * @return \Illuminate\Http\Response
     */
    public function get_locations(Request $request)
    {
        $validator = Validator::make($request->only('token','query'), [
            'token' => 'required|string',
            'query' => 'required|string|min:3'
        ]);

        //Send failed response if request is not valid
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()], 200);
        }
        $query = $request->query('query');
        $url = env('WEATHER_URL').'search.json?key='.env('WEATHER_KEY').'&q=' . $query;
        $data = $this->curlRequest($url);
        $data = json_decode($data);
        return response()->json($data);
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Connect;
use GuzzleHttp\Client;
use GuzzleHttp\RequestOptions;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;

class ConnectController extends Controller
{
    //
    protected $basePath = 'https://accounts.zoho.com/oauth/v2/token';
    protected $getPath = 'https://www.zohoapis.com/crm/v2/';

    public function index()
    {
        $active = Connect::whereActive(1)->first();
        $active = (is_null($active)) ? 0 : 1;
        Cookie::queue(Cookie::forever('active', $active));
        return view('connect', compact('active'));
    }

    public function createAction(Request $request)
    {
        $client = new Client();
        $type = 'authorization_code'; // type - create

        // form with names like code, secret ...
        $request->redirectUrl = $request->redirectUrl !=='' ? $request->redirectUrl : 'https://www.livenletlive.zohosites.com'; // Rederect URL

        $data = $this->basePath . '?code=' . $request->code . '&client_id=' . $request->clientId . '&redirect_uri=' . $request->redirectUrl . '&client_secret=' . $request->secret . '&grant_type=' . $type;
        $response = $client->request('POST', $data);
        $result = json_decode($response->getBody(), true);

        if(array_key_exists('refresh_token', $result)) {
            // generate cookie
            $jar = \GuzzleHttp\Cookie\CookieJar::fromArray($result, '/');
            $cookie = $jar->getCookieByName('access_token')->getValue();
            $refresh_token = $jar->getCookieByName('refresh_token')->getValue();

            // save cookie
            Cookie::queue(Cookie::make('access_token', $cookie, 59));

            // save to db
            DB::insert('Insert into connects (client_id, secret, refresh_token, active) values (?, ?, ?, ?)', [$request->clientId, $request->secret, $refresh_token, true]);

            return redirect('/');
        } else {
            return back()->withErrors('Generated code is expired!');
        }

    }

    public function updateAction($controller, $id = null)
    {
        $client = new Client();
        $type = 'refresh_token';

        $connect = Connect::whereActive(1)->first()->toArray();

        $updatePath = $this->basePath . '?refresh_token=' . $connect['refresh_token'] . '&client_id=' . $connect['client_id'] . '&client_secret=' . $connect['secret'] . '&grant_type=' . $type;;
        $response = $client->request('POST', $updatePath);
        $result = json_decode($response->getBody(), true);

        $jar = \GuzzleHttp\Cookie\CookieJar::fromArray($result, '/');
        $cookie = $jar->getCookieByName('access_token')->getValue();
        Cookie::queue(Cookie::make('access_token', $cookie, 59));

        if (!is_null($id)) {
            return redirect()->action(
                $controller, ['id' => $id]
            );
        } else {
            return redirect()->action($controller)->with('status', 'Api token refreshed');
        }
    }

    public function getAction ($uri)
    {
        if ($uri) {
            $token = Cookie::get('access_token');
            $path = $this->getPath . $uri;
            $client = new Client();

            $params['headers'] = ['Content-Type' => 'application/json', 'Authorization' => 'Zoho-oauthtoken ' . $token];
            $response = $client->request('GET', $path, $params);

            $result = json_decode($response->getBody(), true);
            $result = reset($result);
            return $result;
        } else {
            return false;
        }
    }

    public function storeAction ($data = null, $url, $method)
    {
        //
        $token = Cookie::get('access_token');

        $headers = ['Content-Type' => 'application/json', 'Authorization' => 'Zoho-oauthtoken ' . $token];
        $path = $this->getPath . $url;

        $client = new Client([
            'headers' => $headers,
        ]);

        $response = $client->request($method, $path, [RequestOptions::JSON => $data]);

        $result = json_decode($response->getBody(), true);
        $result = reset($result);
        foreach ($result as $key => $value) {
            $dealExid = $value['details']['id'] ? $value['details']['id'] : false;
        }
        return $dealExid;
    }
}

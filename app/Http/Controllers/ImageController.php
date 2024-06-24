<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use League\Glide\Responses\LaravelResponseFactory;
use League\Glide\Server;
use League\Glide\ServerFactory;

class ImageController extends Controller
{
    public function show(Request $request, string $path)
    {
        $server = $this->glideServerFactory(Storage::getDriver(), 'uploads');
        return $server->getImageResponse($path, $request->all());
    }

    /**
     * Create configured server.
     *
     * @param array $config Configuration parameters.
     *
     * @return Server Configured server.
     */
    private function glideServerFactory($source, string $base_url): Server
    {
        return ServerFactory::create([
            'response' => new LaravelResponseFactory(app('request')),
            "source" => $source,
            "cache" => Storage::getDriver(),
            'cache_path_prefix' => '.cache',
            "base_url" => $base_url,
        ]);
    }
}

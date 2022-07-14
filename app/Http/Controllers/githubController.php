<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class githubController extends Controller
{

    public function index()
    {
        $url = Http::get('https://api.github.com/users/rcchaves/repos');
        // return $url->full_name;
        $mostrar = json_decode($url);
        return $mostrar;
    }

    public function buscar($user, $repo)
    {
        $url = 'https://api.github.com/repos/';
        $apiGit = Http::get($url . $user . '/' . $repo . '/commits');
        $dados = json_decode($apiGit, true);
        return Response()->json($dados);
    }

    public function search($api)
    {
        $url = Http::get('https://api.github.com/users/rcchaves/repos');
        $dados = json_decode($url);
        foreach ($dados as $dado) {
            $nome = $dado->name;
            $pos  = strripos($nome, $api);
            if ($pos != '') {
                return Response()->json(['nome' => $nome]);
            }
        }
    }
}

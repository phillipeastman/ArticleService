<?php
header("Access-Control-Allow-Origin: *");
require 'vendor/autoload.php';
require 'Models/Article.php';
require 'Models/ArticleList.php';

$router = new \Klein\Klein();

$router->respond('/hello-world', function () {
    return 'Hello World!';
});

$router->respond(function ($request, $response, $service, $app) use ($router) {
    // Handle exceptions => flash the message and redirect to the referrer
    $router->onError(function ($router, $err_msg) {
        $router->service()->flash($err_msg);
        $router->service()->back();
    });

});

$router->respond('GET', '/api/articles/all', function ($request, $response, $service, $app) {
    $articleList = new ArticleList();
    $articleList->loadDataForAll();
    
    return json_encode($articleList->List);
});

$router->respond('GET', '/api/[a:year]/[a:month]/articles', function ($request, $response, $service, $app) {
    $year = $request->paramsNamed()->get('year');
    $month = $request->paramsNamed()->get('month');
    $yearMonth = $year . '-' . $month;

    $articleList = new ArticleList();
    $articleList->loadDataByDate($yearMonth);

    return json_encode($articleList->List);
});

$router->respond('GET', '/api/article/[i:id]', function ($request, $response, $service, $app) {
    $ID = $request->paramsNamed()->get('id');

    $article = new Article($ID);

    return json_encode($article);
});

$router->dispatch();

<?php
/**
 * Created by PhpStorm.
 * User: Thijs
 * Date: 2-1-2019
 * Time: 18:54
 */

class OutlookController {

    public function me() {
        $cache = new TokenCache();

        $graph = new \Microsoft\Graph\Graph();
        $graph->setAccessToken($cache->getAccessToken());

        $user = $graph->createRequest("GET", "/me")
            ->setReturnType(Microsoft\Graph\Model\User::class)
            ->execute();

        return $user;

    }


    public function tasks() {
        $cache = new TokenCache();

        $graph = new \Microsoft\Graph\Graph();
        $graph->setAccessToken($cache->getAccessToken());

        $graph->setApiVersion('beta');
        //setPageSize
        $task = $graph->createRequest("GET", "/me/outlook/tasks?\$count=true&\$filter=status ne 'completed'")->execute();
        echo "<pre>";
        print_r($task);
    }

}
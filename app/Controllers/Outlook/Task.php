<?php
/**
 * Created by PhpStorm.
 * User: Thijs
 * Date: 2-1-2019
 * Time: 19:36
 */

class Task {

    public function count() {


        $cache = new TokenCache();

        $graph = new \Microsoft\Graph\Graph();
        $graph->setAccessToken($cache->getAccessToken());

        $graph->setApiVersion('beta');
        //setPageSize

        $task = $graph->createRequest("GET", "/me/outlook/tasks?\$count=true&\$filter=status ne 'completed'")->execute();

        $body = $task->getBody();

        return $body['@odata.count'] ?? 0;

    }

    public function completed() {

    }
}
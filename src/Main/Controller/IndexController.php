<?php

namespace Main\Controller;

use Slim\Http\Request;
use Slim\Http\Response;
use Valitron\Validator;

class IndexController extends BaseController
{

    public function getIndex(Request $req, Response $res)
    {
        $db = $this->ci->medoo;
        $category = $db->select('topic_category','*');
        $topicList = $db->select("topic", [
            "[>]guest" => ["guest_id" => "id"],
            "[>]province" => ["province" => "PROVINCE_ID"],
            "[>]topic_category" => ["topic_category_id" => "topic_category_id"]
        ], '*', [
            "AND" => [
                "topic.topic_type" => "0"
            ],
            "ORDER" => ["topic.topic_id" => "DESC"],
            "LIMIT" => 20000
        ]);
        $topicList1 = $db->select("topic", [
            "[>]guest" => ["guest_id" => "id"],
            "[>]province" => ["province" => "PROVINCE_ID"],
            "[>]topic_category" => ["topic_category_id" => "topic_category_id"]
        ], '*', [
            "AND" => [
            "topic.topic_type" => "1"
        ],
            "ORDER" => ["topic.topic_id" => "DESC"],
            "LIMIT" => 20000
        ]);
        //echo "<pre>";
        //var_dump($topicList);

        return $this->ci->view->render($res, 'index.twig',['category'=>$category,'topics'=>$topicList,'topics1'=>$topicList1]);
    }

    public function getLine(Request $req, Response $res) {
        $token = 'NHYDEdSIGRYkFZSSNt9Gi3BHV4key9XxSO896tSmKVP';
        $ln = new \KS\Line\LineNotify($token);
        $text = 'Hello Line Notify';
        $ln->send($text);
    }

    public function createTopicFree(Request $req, Response $res) {
        $db = $this->ci->medoo;
        $category = $db->select('topic_category','*');
        $province = $db->select('province','*');
        return $this->ci->view->render($res, 'create_topic_free.twig',['category'=>$category,'province'=>$province]);
    }

    public function getTopicById(Request $req, Response $res) {
        $db = $this->ci->medoo;
        $category = $db->select('topic_category','*');
        $topicList = $db->get("topic", [
            "[>]guest" => ["guest_id" => "id"],
            "[>]province" => ["province" => "PROVINCE_ID"],
            "[>]topic_category" => ["topic_category_id" => "topic_category_id"]
        ], '*', [
            "AND" => [
                "topic.topic_id" => $req->getAttribute('id')
            ],
            "ORDER" => ["topic.topic_id" => "DESC"],
            "LIMIT" => 20000
        ]);
        // var_dump($topicList);
        return $this->ci->view->render($res, 'topic.twig',['category'=>$category,'topic'=>$topicList]);
    }
}

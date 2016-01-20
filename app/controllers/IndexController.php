<?php

use Phalcon\Mvc\Model\Criteria;
use Phalcon\Paginator\Adapter\Model as Paginator;


class IndexController extends ControllerBase
{
    public function  initialize()
    {
        parent::initialize();
    }

    public function indexAction()
    {
        $username = $this->cookies->get('username')->getValue();
        $this->view->username = $username;
    }

    /**
     * 用户管理主页
     */
    public  function webAction()
    {
        $numberPage = $this->request->getQuery("page", "int") ?  $this->request->getQuery("page", "int") : 1;

        //$parameters["id"] = '3';
        $data = SunUser::find();

        $paginator = new Paginator(array(
            "data" => $data,
            "limit"=> 10,
            "page" => $numberPage
        ));

        $this->view->page = $paginator->getPaginate();
    }

    /**
     * 用户搜索页
     */
    public function  searchAction()
    {

    }

}


<?php

use Mp\App;
use Mp\Core\Controller\Frontend;

class HomeController extends Frontend
{
    public function __construct($model = '', $table = '', $alias = '', $template = 'home')
    {
        parent::__construct($model, $table, $alias, $template);
    }

    public function navigator()
    {
        $request = App::mp('request');
        $helper = App::mp('config');

        switch ($request->query['action']) {
            default:
                $this->index();
                break;
        }
    }

    public function index()
    {
        $categoryService = App::category();

        $service = App::load('product', 'service');
        $topBanner = $service->hot(8);
        $hot = $service->hot();
        $store = $service->store(12);
        $promote = $service->promote(14);

        $service = App::load('makeup', 'service');
        $news = $service->lastest();

        $service->model()->category($categoryService->flat('advisory'));
        $advisory = $service->lastest();

        $service->model()->category($categoryService->flat('collection'));
        $collection = $service->lastest();

        $service = App::load('post', 'service', ['store', 'post', 'store']);
        $service->category('store');

        $option = [
            'select' => 'id, title, seo_id',
            'where' => 'status > 0',
            'order' => '`status` desc, idx desc, id desc',
            'limit' => 15
        ];
        $extend = [
            'string_1' => 'address',
            'string_2' => 'phone',
            'string_5' => 'file_id',
            'text_1' => [
                'email',
                'location'
            ]
        ];

        $shop = $service->get($option, $extend);

        $this->render('index', compact('hot', 'store', 'news', 'promote', 'advisory', 'collection', 'shop', 'topBanner'));
    }
}

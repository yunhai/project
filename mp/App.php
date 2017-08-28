<?php
namespace Mp;

use Mp\Lib\Utility\Hash;
use Mp\Lib\Utility\Exception;
use \ReflectionClass as ReflectionClass;

class App {
    static private $reference = [];
    static private $chain = [];

    static private function checkChain($name = '') {
        return array_key_exists($name, self::$chain);
    }

    static private function chain($name = '', $obj = null) {
        if (empty($obj)) {
            return self::$chain[$name];
        }

        return self::$chain[$name] = $obj;
    }

    static public function invoke() {
        try {
            $view = self::mp('view');
            $request = self::mp('request');

            $module = $request->query['module'];
            $obj = self::uses($module, 'controller');

            $content = $view->finalize(new $obj());
            self::render($content, $view->header());
        } catch (Exception $e) {
            abort('invoke fail', 500);
        }
    }

    static public function render($content, $header = []) {
        $response = App::mp('response');

        $response->body($content);

        if (empty($header) == false) {
            $response->header($header);
        }

        // $response->compress();
        $response->send();

        self::finish();
    }

    static public function finish() {
        self::db()->disconnect();
        // exit;
    }

    static public function db() {
        if (self::checkChain('db')) {
            return self::chain('db');
        }

        $config = self::mp('config')->get('database.default');

        $db = "\Mp\Core\Model\Db\Instance\\" . ucfirst($config['driver']);
        $db = new $db($config);

        return self::chain('db', $db);
    }

    static public function sql() {
        return self::db()->getLog();
    }

    static public function template() {
        if (self::checkChain('template')) {
            return self::chain('template');
        }

        $channel = self::mp('request')->channel;
        $template = self::load('twig/' . $channel, 'component')->twig();

        return self::chain('template', $template);
    }

    static public function mp($name = '', $instance = '', $arguments = []) {
        if (self::checkChain($name)) {
            return self::chain($name);
        }

        $predict = [
            'config' => 'Mp\Lib\Helper\Config',
            'login' => 'Mp\Lib\Helper\Login',
            'request' => 'Mp\Lib\Request',
            'response' => 'Mp\Lib\Response',
            'view' => 'Mp\Lib\View',
            'locale' => 'Mp\Service\Locale',
            'seo' => 'Mp\Service\Seo',
            'file' => 'Mp\Service\File',
        ];

        if (empty($instance)) {
            $instance = $predict[$name];
        }

        $reflection = new \ReflectionClass($instance);

        return self::chain($name, $reflection->newInstanceArgs($arguments));
    }

    static public function load($instance = '', $type = 'helper', $arguments = []) {
        $chain = $instance . $type;

        if (self::checkChain($chain)) {
            return self::chain($chain);
        }

        try {
            $instance = self::uses($instance, $type);

            $reflection = new \ReflectionClass($instance);
            return self::chain($chain, $reflection->newInstanceArgs($arguments));
        } catch (Exception $e) {
            abort('load fail:' . $instance, 500);
        }
    }

    static public function uses($instance = '', $type = 'helper') {
        $chain = 'uses_' . $instance . $type;

        if (self::checkChain($chain)) {
            return self::chain($chain);
        }
        $u = ucfirst($type);
        switch ($type) {
            case 'controller':
                $channel = self::mp('request')->channel;

                $instance = ucfirst($instance) . $u;
                $filename = $u . DS . ucfirst($channel) . DS. $instance;
                $path = $filename . '.php';

                break;
            case 'model':
            case 'validator':
            case 'service':
                $instance = ucfirst($instance) . $u;
                $filename = $u . DS . $instance;
                $path = $filename . '.php';
                break;
            default:
                $filename = '';
                $instance = ucfirst($instance);
                if (strpos($instance, '/') !== false) {
                    $tmp = explode('/', $instance);
                    $count = count($tmp) - 1;
                    foreach ($tmp as $key => $value) {
                        $value = ucfirst($value);
                        if ($key == $count) {
                            $instance = $value;
                            break;
                        }
                        $filename .= $value . DS;
                    }
                }

                $filename = $u . DS . $filename . $instance;

                if ($type == 'component') {
                    $instance .= ucfirst($tmp[0]);
                }
                $instance .= $u;

                $path = 'Lib' . DS . $filename . '.php';
        }
        try {
            self::attach($path);
            return self::chain($chain, $instance);
        } catch (Exception $e) {
            abort('uses fail:' . $instance, 500);
        }
    }

    // static private function __path($instance = '', $type = 'helper') {
    //     $u = ucfirst($type);
    //     switch ($type) {
    //         case 'controller':
    //             $channel = self::mp('request')->channel;

    //             $instance = ucfirst($instance) . $u;
    //             $filename = $u . DS . ucfirst($channel) . DS. $instance;
    //             $path = $filename . '.php';
    //             break;
    //         case 'model':
    //         case 'validator':
    //         case 'service':
    //             $instance = ucfirst($instance) . $u;
    //             $filename = $u . DS . $instance;
    //             $path = $filename . '.php';
    //             break;
    //         default:
    //             $filename = '';
    //             $instance = ucfirst($instance);
    //             if (strpos($instance, '/') !== false) {
    //                 $tmp = explode('/', $instance);
    //                 $count = count($tmp) - 1;
    //                 foreach ($tmp as $key => $value) {
    //                     $value = ucfirst($value);
    //                     if ($key == $count) {
    //                         $instance = $value;
    //                         break;
    //                     }
    //                     $filename .= $value . DS;
    //                 }
    //             }

    //             $filename = $u . DS . $filename . $instance;

    //             if ($type == 'component') {
    //                 $instance .= ucfirst($tmp[0]);
    //             }
    //             $instance .= $u;

    //             $path = 'Lib' . DS . $filename . '.php';
    //     }
    //     return $path;
    // }

    static public function attach($filename = "") {
        $base = App::mp('config')->appLocation();

        if (file_exists($base . $filename)) {
            require $base . $filename;
        } else {
            abort(sprintf('file [%s] not found', $filename), 500);
        }
    }

    static public function log($message, $file = 'log') {
        $target = App::mp('login')->target('app');

        $path = TENANT_PATH . $target['tenant_id'] . DS . $target['code'] . DS . 'Tmp' . DS . 'log' . DS;

        $file = fopen($path . $file . ".txt", "a");

        fwrite($file, date('Y-m-d H:m:s') . ':');
        fwrite($file, PHP_EOL . $message . PHP_EOL);
        fclose($file);
    }

    static public function category() {
        return self::load('category', 'service', [self::load('category', 'model')]);
    }

    static public function reference() {
        return self::$reference;
    }

    static public function refer($target = []) {
        foreach ($target as $key => $list) {
            $target[$key] = array_filter($list);
        }

        if ($target) {
            $target = array_filter($target);
        }

        if ($target) {
            self::$reference = Hash::merge(self::$reference, $target);
        }
    }

    static public function associate($data = [], $fields = ['seo' => 'seo_id', 'file' => 'file_id']) {
        if ($data && $fields) {
            $refer = [];
            foreach ($fields as $key => $field) {
                $refer[$key] = Hash::combine($data, '{n}.' . $field, '{n}.' . $field);
            }
            self::refer($refer);
        }
    }
}

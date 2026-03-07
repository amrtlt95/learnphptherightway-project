<?php

declare(strict_types = 1);

namespace App;

use App\Exceptions\RouteNotFoundException;
use Symfony\Component\Mailer\MailerInterface;
use Dotenv\Dotenv;
use App\CustomMailer;

class App
{
    private static DB $db;
    private Config $config;

    public function __construct(protected Container $container, protected ?Router $router = null, protected array $request = [])
    {
    }


    public function boot(): static
    {
         $dotenv = Dotenv::createImmutable(dirname(__DIR__));
        $dotenv->load();
        $this->config = new Config($_ENV);

        static::$db = new DB($this->config->db ?? []);

        $this->container->set(MailerInterface::class, fn()=>new CustomMailer($this->config->mailer_dsn??"") );

        return $this;
    }

    public static function db(): DB
    {
        return static::$db;
    }

    public function run()
    {
        try {
            echo $this->router->resolve($this->request['uri'], strtolower($this->request['method']));
        } catch (RouteNotFoundException) {
            http_response_code(404);

            echo View::make('error/404');
        }
    }
}

<?php

declare(strict_types=1);

namespace App;

use PhpAmqpLib\Connection\AMQPStreamConnection;
use App\Mail;

class Rabbit{
    
    /**
     * Get queue messsages and send them using phpmailer
     *
     * @return void
     */
    public static function getMessages(){
        try{
            $connection = new AMQPStreamConnection($_ENV['RMQ_HOST'], $_ENV['RMQ_PORT'], $_ENV['RMQ_USERNAME'], $_ENV['RMQ_PASSWORD']);
            $channel = $connection->channel();
            $channel->queue_declare($_ENV['RMQ_KEY'], false, false, false, false);
            echo "Waiting for messages. To exit press CTRL+C\n";
            $callback = function($msg){
                Mail::SendMsg($msg->body);
            };
    
            $channel->basic_consume($_ENV['RMQ_KEY'], '', false, true, false, false, $callback);
            while($channel->is_open()){
                $channel->wait();
            }
        }catch(\Exception $e){
            die($e->getMessage());
        }
    }

}
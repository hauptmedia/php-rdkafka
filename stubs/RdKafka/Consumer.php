<?php
namespace RdKafka;

class Consumer extends \RdKafka {
    public function __construct(RdKafka\Conf $conf = null) {}

    /**
     * @return RdKafka\Queue
     */
    public function newQueue() {}
}
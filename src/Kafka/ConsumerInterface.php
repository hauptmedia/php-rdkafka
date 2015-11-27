<?php
namespace Kafka;

interface ConsumerInterface
{
    /**
     * @param $topic Topic name
     * @param $partition Partition
     * @param $offset Message offset
     * @param $key Optional message key
     * @param $payload Message payload
     * @return mixed
     */
    public function consume($topic, $partition, $offset, $key, $payload);
}

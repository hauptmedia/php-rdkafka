<?php
namespace Kafka;

interface ConsumerInterface
{
    /**
     * @param string $topic Topic name
     * @param int $partition Partition
     * @param int $offset Message offset
     * @param string $key Optional message key
     * @param string $payload Message payload
     * @return mixed
     */
    public function consume($topic, $partition, $offset, $key, $payload);
}

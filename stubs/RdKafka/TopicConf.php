<?php
namespace RdKafka;

class TopicConf extends \RdKafka\Conf {
    /**
     * Allowed values are RD_KAFKA_MSG_PARTITIONER_RANDOM, RD_KAFKA_MSG_PARTITIONER_CONSISTENT.
     * Set partitioner callback
     * @param int $partitioner
     */
    public function setPartitioner($partitioner) {}
}
<?php
namespace Kafka;

class ProducerTopicFacade
{
    /**
     * @var \RdKafka\ProducerTopic
     */
    protected $producerTopic;

    /**
     * @param \RdKafka\ProducerTopic $producerTopic
     */
    public function __construct(\RdKafka\ProducerTopic $producerTopic) {
        $this->producerTopic = $producerTopic;
    }

    /**
     * Produce and send a single message to broker
     * @param int $partition is the target partition, either Topic::PARTITION_UA (unassigned) for automatic partitioning using the topic's partitioner function, or a fixed partition (0..N)
     * @param string $payload is the message payload
     * @param string|null $key is an optional message key, if non-NULL it will be passed to the topic partitioner as well as be sent with the message to the broker and passed on to the consumer.
     */
    public function produce($partition, $payload, $key=null) {
        $this->producerTopic->produce($partition, 0, $payload, $key);
    }
}
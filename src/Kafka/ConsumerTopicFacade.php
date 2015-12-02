<?php
namespace Kafka;

use Kafka\ConsumerInterface;

class ConsumerTopicFacade
{
    /**
     * @var \RdKafka\ConsumerTopic
     */
    protected $consumerTopic;

    /**
     * @var ConsumerInterface[]
     */
    protected $consumers = array();

    /**
     * @param \RdKafka\ConsumerTopic $producerTopic
     */
    public function __construct(\RdKafka\ConsumerTopic $producerTopic) {
        $this->consumerTopic = $producerTopic;
    }

    /**
     * @var bool
     */
    protected $isConsuming = false;

    public function addConsumer(ConsumerInterface $consumer) {
        $this->consumers[] = $consumer;
    }

    public function consumeStart($partition, $offset = RD_KAFKA_OFFSET_BEGINNING) {
        if(true === $this->isConsuming) {
            throw new \Exception("This topic is already consuming");
        }

        if(!$this->consumerTopic) {
            throw new \Exception("Could not start consuming because no kafka consumer is available");
        }

        $this->consumerTopic->consumeStart($partition, $offset);
        $this->isConsuming = true;
    }

    public function consume($timeoutInMs=10000)
    {
        if(true !== $this->isConsuming) {
            throw new \Exception("Please call consumeStart first to start consuming message");
        }

        while($message = $this->consumerTopic->consume($timeoutInMs)) {
            foreach($this->consumers as $consumer) {
                $consumer->consume($message->topic_name, $message->partition, $message->offset, $message->key, $message->payload);
            }
        }

    }

    public function consumeStop($partition) {
        $this->rdKafkaConsumerTopic->consumeStop($partition);

        $this->isConsuming = false;
    }

}
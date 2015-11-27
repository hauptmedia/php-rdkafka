<?php
namespace Kafka;

class Topic {
    const PARTITION_UA = RD_KAFKA_PARTITION_UA;

    protected $consumers = array();

    /**
     * @var \RdKafka\ProducerTopic
     */
    protected $producerTopic;

    /**
     * @var \RdKafka\ConsumerTopic
     */
    protected $consumerTopic;

    protected $isConsuming = false;

    public function __construct(\RdKafka\ProducerTopic $producerTopic = null, \RdKafka\ConsumerTopic $consumerTopic = null) {
        $this->producerTopic = $producerTopic;
        $this->consumerTopic = $consumerTopic;
    }

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

        $this->rdKafkaConsumerTopic->consumeStart($partition, $offset);
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

    /**
     * Produce and send a single message to broker
     * @param int $partition is the target partition, either Topic::PARTITION_UA (unassigned) for automatic partitioning using the topic's partitioner function, or a fixed partition (0..N)
     * @param $payload is the message payload
     * @param $key is an optional message key, if non-NULL it will be passed to the topic partitioner as well as be sent with the message to the broker and passed on to the consumer.
     */
    public function produce($partition, $payload, $key=null) {
        $this->producerTopic->produce($partition, 0, $payload, $key);
    }
}
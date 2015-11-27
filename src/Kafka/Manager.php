<?php
namespace Kafka;

use Kafka\Configuration\ConsumerConfiguration;
use Kafka\Configuration\ProducerConfiguration;

class Manager
{
    protected $topics = array();

    protected $brokers = array();

    /**
     * @var \RdKafka\Producer
     */
    protected $rdKafkaProducer;

    /**
     * @var \RdKafka\Consumer
     */
    protected $rdKafkaConsumer;

    /**
     * @var ProducerConfiguration
     */
    protected $producerConfiguration;

    /**
     * @var ConsumerConfiguration
     */
    protected $consumerConfiguration;

    public function __construct(
        array $brokers,
        ProducerConfiguration $producerConfiguration = null,
        ConsumerConfiguration $consumerConfiguration = null
    ) {
        $this->brokers = $brokers;

        if(null !== $consumerConfiguration) {
            $this->rdKafkaConsumer = $this->createConsumer();
            $this->consumerConfiguration = $consumerConfiguration;
        }

        if(null !== $producerConfiguration) {
            $this->rdKafkaProducer = $this->createProducer();
            $this->producerConfiguration = $producerConfiguration;
        }
    }


    public function createTopic($topic)
    {
        $producerTopic = ($this->rdKafkaProducer !== null) ?
            $this->rdKafkaProducer->newTopic($topic, $this->producerConfiguration->toRdKafkaTopicConfig()) : null;


        $consumerTopic = ($this->rdKafkaConsumer !== null) ?
            $this->rdKafkaConsumer->newTopic($topic, $this->consumerConfiguration->toRdKafkaTopicConfig()) : null;

        $topic = new Topic($producerTopic, $consumerTopic);
        return $topic;
    }

    /**
     * Create a new rdkafka producer
     * @return \RdKafka\Producer
     */
    protected function createProducer() {
        $rdKafkaProducer = new \RdKafka\Producer();
        $rdKafkaProducer->addBrokers(implode(",", $this->brokers));

        return $rdKafkaProducer;
    }

    /**
     * Create a new rdkafka consumer
     * @return \RdKafka\Consumer
     */
    protected function createConsumer() {
        $rdKafkaConsumer = new \RdKafka\Consumer();
        $rdKafkaConsumer->addBrokers(implode(",", $this->brokers));

        return $rdKafkaConsumer;
    }
}
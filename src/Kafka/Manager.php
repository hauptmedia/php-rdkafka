<?php
namespace Kafka;

use Kafka\Configuration\ConsumerConfiguration;
use Kafka\Configuration\ProducerConfiguration;
use Kafka\Topic\ConsumerTopic;
use Kafka\Topic\ProducerTopic;

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

    public function __construct(array $brokers) {
        $this->brokers = $brokers;
    }

    /**
     * @param $topic string
     * @param ConsumerConfiguration|null $consumerConfiguration
     * @return ConsumerTopic
     */
    public function createConsumerTopic($topic, ConsumerConfiguration $consumerConfiguration = null) {
        if(null === $consumerConfiguration) {
            $consumerConfiguration = new ConsumerConfiguration();
        }

        if(null === $this->rdKafkaConsumer) {
            $this->rdKafkaConsumer = $this->createConsumer();
        }

        return new ConsumerTopic(
            $this->rdKafkaConsumer->newTopic($topic, $consumerConfiguration->toRdKafkaTopicConfig())
        );

    }

    /**
     * @param ProducerConfiguration|null $producerConfiguration
     * @return ProducerTopic
     */
    public function createProducerTopic($topic, ProducerConfiguration $producerConfiguration = null) {
        if(null === $producerConfiguration) {
            $producerConfiguration = new ProducerConfiguration();
        }

        if(null === $this->rdKafkaProducer) {
            $this->rdKafkaProducer = $this->createProducer();
        }

        return new ProducerTopic(
            $this->rdKafkaProducer->newTopic($topic, $producerConfiguration->toRdKafkaTopicConfig())
        );
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
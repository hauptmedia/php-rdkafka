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
     * @param string $topic
     * @param ConsumerConfiguration|null $consumerConfiguration
     * @return ConsumerTopicFacade
     */
    public function createConsumerTopicFacade($topic, ConsumerConfiguration $consumerConfiguration = null) {
        if(null === $consumerConfiguration) {
            $consumerConfiguration = new ConsumerConfiguration();
        }

        if(null === $this->rdKafkaConsumer) {
            $this->rdKafkaConsumer = $this->createConsumer();
        }

        return new ConsumerTopicFacade(
            $this->rdKafkaConsumer->newTopic($topic, $consumerConfiguration->toRdKafkaTopicConfig())
        );

    }

    /**
     * @param ProducerConfiguration|null $producerConfiguration
     * @return ProducerTopicFacade
     */
    public function createProducerTopicFacade($topic, ProducerConfiguration $producerConfiguration = null) {
        if(null === $producerConfiguration) {
            $producerConfiguration = new ProducerConfiguration();
        }

        if(null === $this->rdKafkaProducer) {
            $this->rdKafkaProducer = $this->createProducer();
        }

        return new ProducerTopicFacade(
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
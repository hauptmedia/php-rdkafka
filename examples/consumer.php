<?php
use Kafka\Configuration\ConsumerConfiguration;
use Kafka\Manager;

include_once('../vendor/autoload.php');

class MyConsumer implements \Kafka\ConsumerInterface {
    /**
     * @param string $topic Topic name
     * @param int $partition Partition
     * @param int $offset Message offset
     * @param string $key Optional message key
     * @param string $payload Message payload
     * @return mixed
     */
    public function consume($topic, $partition, $offset, $key, $payload)
    {
        echo "Received message with payload " . $payload;
    }
}
$consumerConfiguration = (new ConsumerConfiguration())
    ->setAutoCommitIntervalMs(1000)
    ->setOffsetStoreSyncIntervalMs(60);

$manager = new Manager(['largo']);

$consumerTopic = $manager->createConsumerTopicFacade("test", $consumerConfiguration);
$consumerTopic->addConsumer(new MyConsumer());

$consumerTopic->consumeStart(0 /* partition */, 0 /* offset */);
$consumerTopic->consume(0 /* partition */, 1000 /* timeout in ms */);
$consumerTopic->consumeStop(0 /* partition */);

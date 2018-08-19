# php-rdkafka

PHP stubs for the php rdkafka extension.

See https://github.com/arnaud-lb/php-rdkafka

# Wrapper / Facade objects in the Kafka namespace

You can use the wrapper objects available in the `Kafka` namespace for a more PHP-style interface to the RdKafka
objects.

## Example for a producer

```php
include_once('vendor/autoload.php');

use Kafka\Configuration\ProducerConfiguration;
use Kafka\Manager;

$producerConfiguration = (new ProducerConfiguration())
    ->setRequestRequiredAcks(0);

$manager = new Manager(['hostname']);
$topic = $manager->createProducerTopicFacade("test", $producerConfiguration);

for($i=1;$i<=1000;$i++) {
    $topic->produce(0 /* partition */, "test" . time());
}
```

### Example for a consumer

Implement the `\Kafka\ConsumerInterface` and add the class to the ConsumerTopicFacade object.

```php
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

$manager = new Manager(['hostname']);

$consumerTopic = $manager->createConsumerTopicFacade("test", $consumerConfiguration);
$consumerTopic->addConsumer(new MyConsumer());

$consumerTopic->consumeStart(0 /* partition */, 0 /* offset */);
$consumerTopic->consume(0 /* partition */, 1000 /* timeout in ms */);
$consumerTopic->consumeStop(0 /* partition */);
```
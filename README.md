# php-rdkafka

PHP stubs for the php rdkafka extension.

See https://github.com/arnaud-lb/php-rdkafka

# Wrapper / Facade objects in the Kafka namespace

You can use the wrapper objects available in the the `Kafka` namespace for a more PHP-style interface to the RdKafka
objects.

## Example for a Producer

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
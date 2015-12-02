<?php
include_once('../vendor/autoload.php');

use Kafka\Configuration\ProducerConfiguration;
use Kafka\Manager;

$producerConfiguration = (new ProducerConfiguration())
    ->setRequestRequiredAcks(0);


$manager = new Manager(['largo']);
$topic = $manager->createProducerTopicFacade("test", $producerConfiguration);

for($i=1;$i<=1000;$i++) {
    $topic->produce(0, "test" . time());
}


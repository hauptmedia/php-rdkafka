<?php
class RdKafka {
    public function addBrokers($brokerList) {}

    public function setLogLevel($level) {}

    /**
     * @param $all_topics
     * @param \RdKafka\Topic|null $only_topic
     * @param $timeout_ms
     * @return \RdKafka\Metadata
     */
    public function metadata($all_topics, RdKafka\Topic $only_topic = null, $timeout_ms) {}
}
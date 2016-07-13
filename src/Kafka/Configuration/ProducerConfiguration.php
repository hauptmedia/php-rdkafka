<?php
namespace Kafka\Configuration;

/**
 * See https://github.com/edenhill/librdkafka/blob/master/CONFIGURATION.md
 *
 * Class ProducerConfiguration
 */
class ProducerConfiguration
{
    /**
     * This field indicates how many acknowledgements the leader broker must receive from ISR brokers before responding
     * to the request: 0=broker does not send any response, 1=broker will wait until the data is written to local
     * log before sending a response, -1=broker will block until message is committed by all in sync replicas (ISRs)
     * or broker's in.sync.replicas setting before sending response. 1=Only the leader broker will need to ack the message.
     * @var int
     */
    protected $requestRequiredAcks = 1;


    /**
     * Fail messages locally if the currently known ISR count for a partition is less than this value.
     * NOTE: The ISR count is fetched from the broker at regular intervals (topic.metadata.refresh.interval.ms)
     * and might thus be outdated.
     * @var int
     */
    protected $enforceIsrCnt = 1;

    /**
     * The ack timeout of the producer request in milliseconds. This value is only enforced by the broker
     * and relies on request.required.acks being > 0.
     * @var int
     */
    protected $requestTimeoutMs = 5000;

    /**
     * Local message timeout. This value is only enforced locally and limits the time a produced message
     * waits for successful delivery. A time of 0 is infinite.
     * @var int
     */
    protected $messageTimeoutMs = 300000;

    /**
     * @return int
     */
    public function getRequestRequiredAcks()
    {
        return $this->requestRequiredAcks;
    }

    /**
     * @param int $requestRequiredAcks
     * @return ProducerConfiguration
     */
    public function setRequestRequiredAcks($requestRequiredAcks)
    {
        $this->requestRequiredAcks = $requestRequiredAcks;
        return $this;
    }

    /**
     * @return int
     */
    public function getEnforceIsrCnt()
    {
        return $this->enforceIsrCnt;
    }

    /**
     * @param int $enforceIsrCnt
     * @return ProducerConfiguration
     */
    public function setEnforceIsrCnt($enforceIsrCnt)
    {
        $this->enforceIsrCnt = $enforceIsrCnt;
        return $this;
    }

    /**
     * @return int
     */
    public function getRequestTimeoutMs()
    {
        return $this->requestTimeoutMs;
    }

    /**
     * @param int $requestTimeoutMs
     * @return ProducerConfiguration
     */
    public function setRequestTimeoutMs($requestTimeoutMs)
    {
        $this->requestTimeoutMs = $requestTimeoutMs;
        return $this;
    }

    /**
     * @return int
     */
    public function getMessageTimeoutMs()
    {
        return $this->messageTimeoutMs;
    }

    /**
     * @param int $messageTimeoutMs
     * @return ProducerConfiguration
     */
    public function setMessageTimeoutMs($messageTimeoutMs)
    {
        $this->messageTimeoutMs = $messageTimeoutMs;
        return $this;
    }

    public function toRdKafkaTopicConfig() {
        $topicConf = new \RdKafka\TopicConf();

        $topicConf->set("request.required.acks", $this->requestRequiredAcks);
        $topicConf->set("enforce.isr.cnt", $this->enforceIsrCnt);
        $topicConf->set("request.timeout.ms", $this->requestTimeoutMs);
        $topicConf->set("message.timeout.ms", $this->messageTimeoutMs);

        return $topicConf;

    }
}

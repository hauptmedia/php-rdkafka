<?php
namespace Kafka\Configuration;
/**
 * See https://github.com/edenhill/librdkafka/blob/master/CONFIGURATION.md
 *
 * Class ConsumerConfiguration
 */
class ConsumerConfiguration
{
    /**
     * Consumer group id string. All clients sharing the same group.id belong to the same consumer group.
     * This takes precedence over the global group.id.
     * @var string
     */
    protected $groupId;

    /**
     * If true (default), periodically commit offset of the last message handed to the application.
     * This commited offset will be used when the process restarts to pick up where it left off.
     * If false, the application will manually have to call rd_kafka_offset_store() to store an offset (optional).
     * @var bool
     */
    protected $autoCommitEnable = true;

    /**
     * The frequency in milliseconds that the consumer offsets are commited (written) to offset storage.
     * @var int
     */
    protected $autoCommitIntervalMs = 60000;

    /**
     * Action to take when there is no initial offset in offset store or the desired offset is out of range:
     * 'smallest' - automatically reset the offset to the smallest offset,
     * 'largest' - automatically reset the offset to the largest offset,
     * 'error' - trigger an error which is retrieved by consuming messages and checking 'message->err'.
     * @var string
     */
    protected $autoOffsetReset = 'largest';

    /**
     * Path to local file for storing offsets. If the path is a directory a
     * filename will be automatically generated in that directory based on the topic and partition.
     * Defaults to the current directory
     * @var string
     */
    protected $offsetStorePath = '.';

    /**
     * fsync() interval for the offset file, in milliseconds. Use -1 to disable syncing,
     * and 0 for immediate sync after each write.
     * @var int
     */
    protected $offsetStoreSyncIntervalMs = -1;

    /**
     * Offset commit store method: 'file' - local file store (offset.store.path, et.al),
     * 'broker' - broker commit store (requires Apache Kafka 0.8.1 or later on the broker).
     * @var string
     */
    protected $offsetStoreMethod = 'file';

    public function __construct() {

    }

    /**
     * @return int
     */
    public function getAutoCommitIntervalMs()
    {
        return $this->autoCommitIntervalMs;
    }

    /**
     * @param int $autoCommitIntervalMs
     */
    public function setAutoCommitIntervalMs($autoCommitIntervalMs)
    {
        $this->autoCommitIntervalMs = $autoCommitIntervalMs;
        return $this;
    }

    /**
     * @return int
     */
    public function getOffsetStoreSyncIntervalMs()
    {
        return $this->offsetStoreSyncIntervalMs;
    }

    /**
     * @param int $offsetStoreSyncIntervalMs
     */
    public function setOffsetStoreSyncIntervalMs($offsetStoreSyncIntervalMs)
    {
        $this->offsetStoreSyncIntervalMs = $offsetStoreSyncIntervalMs;
        return $this;
    }

    /**
     * @return string
     */
    public function getOffsetStorePath()
    {
        return $this->offsetStorePath;
    }

    /**
     * @param string $offsetStorePath
     */
    public function setOffsetStorePath($offsetStorePath)
    {
        $this->offsetStorePath = $offsetStorePath;
        return $this;
    }

    /**
     * @return boolean
     */
    public function isAutoCommitEnable()
    {
        return $this->autoCommitEnable;
    }

    /**
     * @param boolean $autoCommitEnable
     */
    public function setAutoCommitEnable($autoCommitEnable)
    {
        $this->autoCommitEnable = $autoCommitEnable;
        return $this;
    }

    /**
     * @return string
     */
    public function getOffsetStoreMethod()
    {
        return $this->offsetStoreMethod;
    }

    /**
     * @param string $offsetStoreMethod
     */
    public function setOffsetStoreMethod($offsetStoreMethod)
    {
        $this->offsetStoreMethod = $offsetStoreMethod;
        return $this;
    }

    /**
     * @return string
     */
    public function getGroupId()
    {
        return $this->groupId;
    }

    /**
     * @param string $groupId
     */
    public function setGroupId($groupId)
    {
        $this->groupId = $groupId;
        return $this;
    }

    /**
     * @return string
     */
    public function getAutoOffsetReset()
    {
        return $this->autoOffsetReset;
    }

    /**
     * @param string $autoOffsetReset
     */
    public function setAutoOffsetReset($autoOffsetReset)
    {
        $this->autoOffsetReset = $autoOffsetReset;
        return $this;
    }

    public function toRdKafkaTopicConfig() {
        $topicConf = new \RdKafka\TopicConf();
        $topicConf->set("auto.commit.interval.ms", $this->autoCommitIntervalMs);
        $topicConf->set("offset.store.sync.interval.ms", $this->offsetStoreSyncIntervalMs);
        $topicConf->set("offset.store.method", $this->offsetStoreMethod);
        $topicConf->set("auto.commit.enable", $this->autoCommitEnable);
        $topicConf->set("auto.offset.reset", $this->autoOffsetReset);
        $topicConf->set("offset.store.path", $this->offsetStorePath);

        if($this->groupId) {
            $topicConf->set("group.id", $this->groupId);
        }
    }
}
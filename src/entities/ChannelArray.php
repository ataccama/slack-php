<?php

    namespace Ataccama\Slack\Env;

    use Ataccama\Common\Env\BaseArray;
    use Nette\Utils\Strings;


    /**
     * Class Channels
     * @package Ataccama\Slack\Env
     */
    class ChannelArray extends BaseArray
    {
        /**
         * @param Channel $channel
         */
        public function add($channel)
        {
            $this->items[$channel->id] = $channel;
        }

        /**
         * @return Channel
         */
        public function current(): Channel
        {
            return parent::current();
        }

        /**
         * Returns first occur.
         *
         * @param string $name
         * @return Channel|null
         */
        public function find(string $name): ?Channel
        {
            foreach ($this as $channel) {
                if (Strings::contains($channel->name, $name)) {
                    return $channel;
                }
            }

            return null;
        }

        /**
         * @param $channelId
         * @return Channel
         */
        public function get($channelId): Channel
        {
            if (isset($this->items[$channelId])) {
                return parent::get($channelId);
            }
            throw new \OutOfBoundsException("Channel with ID $channelId is not in the array.");
        }
    }
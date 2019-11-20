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
    }
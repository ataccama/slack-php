<?php

    namespace Ataccama\Slack\Env;

    use Ataccama\Common\Env\BaseArray;


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
            parent::add($channel);
        }

        /**
         * @return Channel
         */
        public function current(): Channel
        {
            return parent::current();
        }

    }
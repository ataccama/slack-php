<?php

    namespace Ataccama\Environment\Entities\Slack;

    use Ataccama\Environment\BaseArray;


    /**
     * Class Channels
     * @package Ataccama\Environment\Entities\Slack
     */
    class ChannelArray extends BaseArray
    {
        public function current(): Channel
        {
            return parent::current();
        }

    }
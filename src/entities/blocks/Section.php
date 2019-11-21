<?php

    namespace Ataccama\Slack\Blocks;

    use Ataccama\Slack\Env\SlackMessageBlock;


    /**
     * Class Section
     * @package Ataccama\Slack\Blocks
     */
    class Section extends SlackMessageBlock
    {
        /** @var string */
        private $text;

        /**
         * Section constructor.
         * @param string $text
         */
        public function __construct(string $text)
        {
            $this->text = $text;
        }

        public function toArray(): array
        {
            return [
                "type" => self::TYPE_SECTION,
                "text" => [
                    "type"  => "mrkdwn",
                    "text"  => $this->text,
                    "emoji" => true
                ]
            ];
        }
    }
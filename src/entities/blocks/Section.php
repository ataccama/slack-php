<?php

    namespace Ataccama\Slack\Blocks;

    use Ataccama\Slack\Env\SlackMessageBlock;


    /**
     * Class Section
     * @package Ataccama\Slack\Blocks
     */
    class Section extends SlackMessageBlock
    {
        const TYPE_PLAIN_TEXT = "plain_text";
        const TYPE_MARK_DOWN = "mrkdwn";

        /** @var string */
        private $text;

        /** @var string */
        private $type;

        /**
         * Section constructor.
         * @param string $text
         * @param string $type
         */
        public function __construct(string $text, string $type = self::TYPE_MARK_DOWN)
        {
            $this->text = $text;
            $this->type = $type;
        }

        public function toArray(): array
        {
            return [
                "type" => self::TYPE_SECTION,
                "text" => [
                    "type"  => $this->type,
                    "text"  => $this->text,
                    "emoji" => true
                ]
            ];
        }
    }
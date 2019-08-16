<?php


    namespace Ataccama\Environment\Entities\Slack;


    class SlackMessageBlock
    {
        /** @var string  */
        const TYPE_SECTION = "section";

        ///** @var string  */
        //const TYPE_CONTEXT = "context";

        /** @var string */
        protected $type, $text;

        /**
         * SlackMessageBlock constructor.
         * @param string $text
         * @param string $type
         */
        public function __construct(string $text, string $type = self::TYPE_SECTION)
        {
            $this->type = $type;
            $this->text = $text;
        }

        /**
         * @return array
         */
        public function toArray(): array
        {
            return [
                "type" => $this->type,
                "text" => [
                    "type" => "mrkdwn",
                    "text" => $this->text
                ]
            ];
        }
    }
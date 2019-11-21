<?php


    namespace Ataccama\Slack\Blocks;


    use Ataccama\Slack\Env\SlackMessageBlock;


    class Context extends SlackMessageBlock
    {
        /** @var string[] */
        private $texts = [];

        /**
         * Context constructor.
         * @param string[] $texts
         */
        public function __construct(array $texts)
        {
            $this->texts = $texts;
        }

        public function toArray(): array
        {
            $elements = [];
            foreach ($this->texts as $text) {
                $elements[] = [
                    "type" => "mrkdwn",
                    "text" => $text
                ];
            }

            return [
                "type"     => self::TYPE_CONTEXT,
                "elements" => $elements
            ];
        }
    }
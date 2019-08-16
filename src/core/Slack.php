<?php
    /**
     * Created by PhpStorm.
     * User: miroslav
     * Date: 19/02/2019
     * Time: 16:47
     */

    namespace Ataccama\Output\Slack;

    use Ataccama\Environment\Entities\Base\IEntry;
    use Ataccama\Environment\Entities\Base\Person;
    use Ataccama\Environment\Entities\Slack\Channel;
    use Ataccama\Environment\Entities\Slack\ChannelArray;
    use Ataccama\Environment\Entities\Slack\SlackMessage;
    use Ataccama\Output\Slack\Exception\SlackException;
    use Ataccama\Utils\Email;
    use Ataccama\Utils\Name;
    use Curl\Curl;
    use ErrorException;
    use Exception;
    use Tracy\Debugger;


    /**
     * Class Slack
     * @package Ataccama\Outputs
     */
    class Slack
    {
        /** @var string */
        private $token;

        /** @var bool */
        private $enable = false;

        /**
         * @var string[]
         */
        private $blacklist = [];

        /**
         * Slack constructor.
         * @param array $parameters
         * @throws Exception
         */
        public function __construct(array $parameters)
        {
            $requiredParameters = ['token', 'enable'];
            foreach ($requiredParameters as $parameter) {
                if (isset($parameters[$parameter])) {
                    $this->$parameter = $parameters[$parameter];
                } else {
                    throw new SlackException("Required parameter $parameter is missing. Define it in config/services/slack.neon");
                }
            }

            if (isset($parameters["blacklist"])) {
                $this->blacklist = $parameters["blacklist"];
            }
        }

        /**
         * @return bool
         */
        public function isEnabled(): bool
        {
            return $this->enable;
        }

        /**
         * @param Email $email
         * @return Person
         * @throws ErrorException
         * @throws SlackException
         */
        public function getUserByEmail(Email $email): Person
        {
            $curl = new Curl();
            $curl->setHeader("Authorization", "Bearer $this->token");
            $curl->setHeader("Content-Type", "application/json; charset=utf-8");
            $curl->get("https://slack.com/api/users.lookupByEmail", ['email' => $email->definition]);

            if ($curl->error) {
                Debugger::log('Slack lookup error: ' . $curl->errorCode . ': ' . $curl->errorMessage . '');
                throw new SlackException('Slack lookup error: ' . $curl->errorCode . ': ' . $curl->errorMessage . '');
            }

            if (!$curl->response->ok) {
                throw new SlackException("User ($email->definition) not found. Slack error code: [" .
                    $curl->response->error . "]");
            }

            return new Person($curl->response->user->id, new Name($curl->response->user->real_name), $email);
        }

        /**
         * @param IEntry $userId
         * @return Person
         * @throws ErrorException
         * @throws SlackException
         */
        public function getUserByUserID(IEntry $userId): Person
        {
            $curl = new Curl();
            $curl->setHeader("Authorization", "Bearer $this->token");
            $curl->setHeader("Content-Type", "application/json; charset=utf-8");
            $curl->get("https://slack.com/api/users.info", ['user' => $userId->id]);

            if ($curl->error) {
                Debugger::log('Slack lookup error: ' . $curl->errorCode . ': ' . $curl->errorMessage . '');
                throw new SlackException('Slack lookup error: ' . $curl->errorCode . ': ' . $curl->errorMessage . '');
            }

            if (!$curl->response->ok) {
                throw new SlackException("User ($userId->id) not found. Slack error code: [" . $curl->response->error .
                    "]");
            }

            return new Person($curl->response->user->id, new Name($curl->response->user->real_name),
                new Email($curl->response->user->profile->email));
        }

        /**
         * @return ChannelArray
         * @throws ErrorException
         * @throws SlackException
         */
        public function getChannels(): ChannelArray
        {
            $curl = new Curl();
            $curl->setHeader("Authorization", "Bearer $this->token");
            $curl->setHeader("Content-Type", "application/json; charset=utf-8");
            $curl->get("https://slack.com/api/channels.list", ['exclude_members' => true, 'exclude_archived' => true]);

            if ($curl->error) {
                Debugger::log('Slack channels.list error: ' . $curl->errorCode . ': ' . $curl->errorMessage . '');
                throw new SlackException('Slack channels.list error: ' . $curl->errorCode . ': ' . $curl->errorMessage .
                    '');
            }

            if (!$curl->response->ok) {
                throw new SlackException("Slack channels.list error code: [" . $curl->response->error . "]");
            }

            $curlData = $curl->response->channels;
            $channels = new ChannelArray();

            // remove blacklisted channels
            foreach ($curlData as $k => $v) {
                if (in_array($v->name, $this->blacklist)) {
                    unset($curlData[$k]);
                }
            }

            $channels = [];
            foreach ($curlData as $channel) {
                $channels->add(new Channel($channel->id, new Name($channel->name), $channel->purpose->value));
            }

            return $channels;
        }

        /**
         * @param SlackMessage $message
         * @param Channel      $channel
         * @return bool
         * @throws ErrorException
         * @throws SlackException
         */
        public function sendMessage(SlackMessage $message, Channel $channel): bool
        {
            $_to = str_replace(["#", "@"], "", $channel->name);
            if (in_array($_to, $this->blacklist)) {
                throw new SlackException("$channel->name is on blacklist.");
            }

            if (!$this->enable) {
                throw new SlackException("Slack is disabled.");
            }

            $curl = new Curl();
            $curl->setHeader("Authorization", "Bearer $this->token");
            $curl->setHeader("Content-Type", "application/json; charset=utf-8");
            $curl->post("https://slack.com/api/chat.postMessage", $message->createMessage($channel));

            if (isset($curl->response->ok)) {
                return $curl->response->ok;
            }

            throw new SlackException("Unknown response: " . $curl->errorMessage);
        }
    }
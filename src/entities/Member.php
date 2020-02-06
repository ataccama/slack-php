<?php

    namespace Ataccama\Slack\Env;

    use Ataccama\Common\Env\BaseEntry;
    use Ataccama\Common\Env\Name;


    /**
     * Class Member
     * @package Ataccama\Slack\Env
     * @property-read Name $name
     */
    class Member
    {
        use BaseEntry;

        /** @var Name */
        protected $name;

        /**
         * Member constructor.
         * @param string $id
         * @param Name   $name
         */
        public function __construct(string $id, Name $name)
        {
            $this->id = $id;
            $this->name = $name;
        }

        /**
         * @return Name
         */
        public function getName(): Name
        {
            return $this->name;
        }
    }
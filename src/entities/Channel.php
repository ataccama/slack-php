<?php

    namespace Ataccama\Slack\Env;

    use Ataccama\Common\Env\Entry;


    /**
     * Class Channel
     * @package Ataccama\Slack\Env
     * @property-read string $purpose
     * @property-read string $name
     */
    class Channel extends Entry
    {
        /** @var string */
        protected $purpose;

        /** @var string */
        protected $name;

        /**
         * Channel constructor.
         * @param string      $id
         * @param string      $name
         * @param string|null $purpose
         */
        public function __construct(string $id, string $name, string $purpose = null)
        {
            parent::__construct($id);
            $this->purpose = $purpose;
            $this->name = $name;
        }

        /**
         * @return string
         */
        public function getPurpose(): string
        {
            return $this->purpose;
        }

        /**
         * @return string
         */
        public function getName(): string
        {
            return $this->name;
        }
    }
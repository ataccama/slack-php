<?php

    namespace Ataccama\Slack\Env;

    use Ataccama\Common\Env\BaseArray;


    /**
     * Class MemberList
     * @package Ataccama\Slack\Env
     */
    class MemberList extends BaseArray
    {
        /**
         * @param Member $member
         * @return MemberList
         */
        public function add($member)
        {
            $this->items[$member->id] = $member;

            return $this;
        }

        /**
         * @return Member
         */
        public function current(): Member
        {
            return parent::current();
        }

        /**
         * @param string $memberId
         * @return Member
         */
        public function get($memberId): Member
        {
            return parent::get($memberId);
        }
    }
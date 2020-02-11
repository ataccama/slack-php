<?php

    namespace Ataccama\Slack\Env;

    use Ataccama\Common\Env\BaseArray;
    use Ataccama\Common\Env\Pair;
    use Ataccama\Common\Env\PairArray;


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

        public function toPairs(): PairArray
        {
            $pairs = new PairArray();
            foreach ($this as $member) {
                $pairs->add(new Pair($member->id, $member->name->full));
            }

            return $pairs;
        }
    }
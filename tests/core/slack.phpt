<?php

    require __DIR__ . "/../bootstrap.php";

    use Tester\Assert;


    $slack = new \Ataccama\Output\Slack\Slack([
        "token"  => "xoxb-xxxxxxxxxx-xxxxxxxxxxxxxxxxxxxxxxx",
        "enable" => true
    ]);

    $message = new \Ataccama\Environment\Entities\Slack\SlackMessage("Test message for channel.");
    $message->addBlock(new \Ataccama\Environment\Entities\Slack\SlackMessageBlock("Some section"));
    $message->addBlock(new \Ataccama\Environment\Entities\Slack\SlackMessageBlock("Some section 2"));
    $message->addBlock(new \Ataccama\Environment\Entities\Slack\SlackMessageBlock("Some section 3"));

    $response = $slack->sendMessage($message, new \Ataccama\Environment\Entities\Slack\Channel("CXXXXXXXX", "Sandbox"));

    Assert::same(true, $response);

    $message = new \Ataccama\Environment\Entities\Slack\SlackMessage("Test message for user.");

    $response = $slack->sendMessage($message,
        new \Ataccama\Environment\Entities\Slack\Channel("UXXXXXXXXXX", "Will Smith"));

    Assert::same(true, $response);
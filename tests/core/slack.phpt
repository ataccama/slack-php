<?php

    require __DIR__ . "/../bootstrap.php";

    use Tester\Assert;


    // set up before tests
    const TEST_TOKEN = "xoxb-xxxxxxxxxx-xxxxxxxxxxx-xxxxxxxxxxxxxxxxxxx";
    const TEST_GROUP = "GXXXXXXXX";
    const TEST_USER = "UXXXXXXXX";


    $slack = new \Ataccama\Output\Slack\Slack([
        "token"  => TEST_TOKEN,
        "enable" => true
    ]);

    $message = new \Ataccama\Slack\Env\SlackMessage("Test message for channel.");
    $message->addBlock(new \Ataccama\Slack\Blocks\Section("Some section"));
    $message->addBlock(new \Ataccama\Slack\Blocks\Context(["Some context"]));
    $message->addBlock(new \Ataccama\Slack\Blocks\Divider());
    $message->addBlock(new \Ataccama\Slack\Blocks\Fields(["Field 1", "Field 2"]));

    $response = $slack->sendMessage($message, new \Ataccama\Slack\Env\Channel(TEST_GROUP, "Sandbox"));

    Assert::same(true, $response);

    $message = new \Ataccama\Slack\Env\SlackMessage("Test message for user.");

    $response = $slack->sendMessage($message, new \Ataccama\Slack\Env\Channel(TEST_USER, "Will Smith"));

    Assert::same(true, $response);
# Slack PHP
Provides a sending messages to Slack via a bot.  

## Requirements
You have to have a bot. How to do it?
1) Create (or use existing) app via Slack API (https://api.slack.com/apps)
2) Search for **Features** and **Bot Users**. Then click on the button **Add a Bot User** and fill the form.
3) Now you have to add some permissions (in section OAuth & Permissions) and get **Bot User OAuth Access Token**
4) Install (or reinstall) your app into your Slack workspace


## Use

```
use \Ataccama\Output\Slack;

$slack = new Slack([
            "token"  => "xoxb-xxxxxxxxxx-xxxxxxxxxxxxxxxxxxxxxxx", // Bot User OAuth Access Token
            "enable" => true
        ]);
        
$message = new SlackMessage("Test *message* for channel.");

// optional
$message->addBlock(new SlackMessageBlock("Some *test* section."));

$channel = new Channel("CXXXXXXXX", "Sandbox")

$response = $slack->sendMessage($message, $channel);

if($response) {
    // success
} else {
    // failed
}
```

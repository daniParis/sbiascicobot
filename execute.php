<?php
// require "commands/first-google-search.php";

$content = file_get_contents("php://input");
$update = json_decode($content, true);

if (!$update) {
    exit;
}

$message = isset($update['message']) ? $update['message'] : "";
$messageId = isset($message['message_id']) ? $message['message_id'] : "";
$chatId = isset($message['chat']['id']) ? $message['chat']['id'] : "";
$firstname = isset($message['chat']['first_name']) ? $message['chat']['first_name'] : isset($message['from']['first_name']) ? $message['from']['first_name'] : "";
$lastname = isset($message['chat']['last_name']) ? $message['chat']['last_name'] : isset($message['from']['last_name']) ? $message['from']['last_name'] : "";
$username = isset($message['chat']['username']) ? $message['chat']['username'] : isset($message['from']['username']) ? $message['from']['username'] : "";
$date = isset($message['date']) ? $message['date'] : "";
$text = isset($message['text']) ? $message['text'] : "";

$text = trim($text);
$text = strtolower($text);

header("Content-Type: application/json");

if ($text[0] == "/") {
    preg_match("([^ ]*)", $text, $matches);
    switch ($matches[0]) {
        case "/hi":
            sendMessage($chatId, "Hi {$firstname}");
            break;
        // case "/google":
        //     $serch = str_replace(" ", "+", str_replace("/google ", "", $text));
        //     $result = getFirstUrlFromGoogle($search);
        //     if (!$result) {
        //         sendMessage($chatId, "Mi dispiace {$firstname} ma non ho trovato nulla riguardo '" . str_replace("/google ", "", $text) ."'");
        //     } else {
        //         sendMessage($chatId, "Stavi forse cercando questo?\n{$result}");
        //     }
        //     break;
        default:
            sendMessage($chatId, "No function '" . substr($text, 1) . "' defined");
    }
}

if ($text == "kebab?") {
    if (rand(0, 10) < 7) {
        sendMessage($chatId, "Te sembra il caso? Mo?");
    } else {
        sendMessage($chatId, "Zozzo! Ce sto!");
    }
}


function sendMessage($chatId, $text, $method = "sendMessage")
{
    $parameters = array('chat_id' => $chatId, "text" => $text);
    $parameters["method"] = "sendMessage";

    echo json_encode($parameters);
}

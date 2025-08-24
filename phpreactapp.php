<?php
// react.php
$data = json_decode(file_get_contents("php://input"), true);
$reaction = $data['reaction'];
$ip = $_SERVER['REMOTE_ADDR'];

$logFile = "logs/$reaction.json";

// Load existing data
if (!file_exists($logFile)) {
    file_put_contents($logFile, json_encode(['count' => 0, 'ips' => []]));
}

$reactionData = json_decode(file_get_contents($logFile), true);

// Check IP
if (in_array($ip, $reactionData['ips'])) {
    echo json_encode(['success' => false, 'message' => 'You already reacted.']);
    exit;
}

// Add reaction
$reactionData['count'] += 1;
$reactionData['ips'][] = $ip;
file_put_contents($logFile, json_encode($reactionData));

echo json_encode(['success' => true, 'count' => $reactionData['count']]);
?>

<?php
// Check if it's a POST request
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Path to your project directory
    $projectDir = '/Applications/XAMPP/xamppfiles/htdocs/my-website';
    // Change to that directory
    chdir($projectDir);
    // Run the git pull command
    $output = shell_exec('git pull 2>&1');
    // Log the output (optional)
    file_put_contents('webhook-pull.log', $output . PHP_EOL, FILE_APPEND);
    // Respond to GitHub with a success message
    http_response_code(200);
    echo "Git pull executed: " . $output;
} else {
    http_response_code(405);
    echo "Method Not Allowed";
}
?>

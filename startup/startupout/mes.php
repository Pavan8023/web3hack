<?php include 'config/db.php'; ?>
<!DOCTYPE html>
<html>
<head>
    <title>Group Chat</title>
    <style>
        body { font-family: Arial; background: #f2f2f2; padding: 20px; }
        #chat-box { background: white; border: 1px solid #ccc; height: 400px; overflow-y: scroll; padding: 10px; }
        .message { margin-bottom: 10px; }
        .sender { font-weight: bold; }
        #chat-form { margin-top: 10px; }
    </style>
</head>
<body>

<h2>Startup & Investor Group Chat</h2>
<a href="index.php">← Back to Home</a>

<div id="chat-box"></div>

<form id="chat-form">
    <input type="text" id="sender" placeholder="Your name" required>
    <input type="text" id="message" placeholder="Type your message..." required>
    <button type="submit">Send</button>
</form>

<script>
function fetchMessages() {
    fetch('get_messages.php')
        .then(res => res.json())
        .then(data => {
            const chatBox = document.getElementById('chat-box');
            chatBox.innerHTML = '';
            data.forEach(msg => {
                const div = document.createElement('div');
                div.classList.add('message');
                div.innerHTML = `<span class="sender">${msg.sender_name}:</span> ${msg.message}`;
                chatBox.appendChild(div);
            });
            chatBox.scrollTop = chatBox.scrollHeight;
        });
}

document.getElementById('chat-form').addEventListener('submit', function(e) {
    e.preventDefault();
    const sender = document.getElementById('sender').value;
    const message = document.getElementById('message').value;

    fetch('submit_message.php', {
        method: 'POST',
        headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
        body: `sender=${encodeURIComponent(sender)}&message=${encodeURIComponent(message)}`
    }).then(() => {
        document.getElementById('message').value = '';
        fetchMessages();
    });
});

setInterval(fetchMessages, 2000); // refresh every 2s
fetchMessages();
</script>

</body>
</html>

<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Chat Global
        </h2>
    </x-slot>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        .chat-container {
            max-width: 900px;
            margin: 0 auto;
            height: 600px;
            display: flex;
            flex-direction: column;
        }
        .chat-messages {
            flex: 1;
            overflow-y: auto;
            padding: 20px;
            background: #f8f9fa;
            border: 1px solid #dee2e6;
        }
        .message-item {
            margin-bottom: 15px;
        }
        .message-bubble {
            background: white;
            padding: 10px 15px;
            border-radius: 15px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            max-width: 70%;
            word-wrap: break-word;
        }
        .message-item.own .message-bubble {
            background: #667eea;
            color: white;
            margin-left: auto;
        }
        .message-sender {
            font-weight: 600;
            font-size: 0.875rem;
            margin-bottom: 5px;
        }
        .message-text {
            margin: 0;
        }
        .message-time {
            font-size: 0.75rem;
            color: #6c757d;
            margin-top: 5px;
        }
        .message-item.own .message-time {
            color: rgba(255,255,255,0.8);
        }
        .chat-input {
            padding: 20px;
            background: white;
            border: 1px solid #dee2e6;
        }
    </style>

    <div class="py-6">
        <div class="chat-container">
            <div class="card shadow-lg" style="display: flex; flex-direction: column; height: 100%;">
                <!-- Header -->
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-comments"></i> Chat Global Komunitas Penyu
                    </h5>
                </div>

                <!-- Messages -->
                <div class="chat-messages" id="chat-messages">
                    @foreach($messages as $message)
                        @include('chat.partials.message', ['message' => $message])
                    @endforeach
                </div>

                <!-- Input -->
                <div class="chat-input">
                    <form id="chat-form">
                        @csrf
                        <div class="input-group">
                            <input type="text" 
                                   class="form-control" 
                                   id="message-input" 
                                   name="message"
                                   placeholder="Ketik pesan..." 
                                   required
                                   autocomplete="off">
                            <button class="btn btn-primary" type="submit">
                                <i class="fas fa-paper-plane"></i> Kirim
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        let lastMessageId = {{ $messages->isNotEmpty() ? $messages->last()->id : 0 }};

        // Scroll to bottom
        function scrollToBottom() {
            const chatMessages = document.getElementById('chat-messages');
            chatMessages.scrollTop = chatMessages.scrollHeight;
        }

        // Submit Chat Message
        document.getElementById('chat-form').addEventListener('submit', function(e) {
            e.preventDefault();
            
            const input = document.getElementById('message-input');
            const message = input.value.trim();
            
            if (!message) return;

            // Get CSRF token
            const token = document.querySelector('meta[name="csrf-token"]').content;

            // Send via Fetch API
            fetch('/chat', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': token,
                    'Accept': 'application/json'
                },
                body: JSON.stringify({ message: message })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                console.log('Message sent:', data);
                
                // Append new message
                const messagesDiv = document.getElementById('chat-messages');
                messagesDiv.insertAdjacentHTML('beforeend', data.html);
                
                // Clear input
                input.value = '';
                
                // Update last message ID
                lastMessageId = data.message.id;
                
                // Scroll to bottom
                scrollToBottom();
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Gagal mengirim pesan: ' + error.message);
            });
        });

        // Fetch New Messages (Auto-refresh)
        function fetchNewMessages() {
            fetch('/chat/messages?last_id=' + lastMessageId)
                .then(response => response.json())
                .then(data => {
                    if (data.messages.length > 0) {
                        const messagesDiv = document.getElementById('chat-messages');
                        messagesDiv.insertAdjacentHTML('beforeend', data.html);
                        lastMessageId = data.last_id;
                        scrollToBottom();
                    }
                })
                .catch(error => {
                    console.error('Error fetching messages:', error);
                });
        }

        // Auto-refresh setiap 10 detik
        setInterval(fetchNewMessages, 10000);

        // Initial scroll
        scrollToBottom();
    </script>
</x-app-layout>
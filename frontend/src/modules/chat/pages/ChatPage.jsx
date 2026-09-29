import { useChat } from "../hooks/useChat";

import MessageList from "../components/MessageList";
import MessageInput from "../components/MessageInput";

export default function ChatPage() {

    const { messages, isSending, error, send } = useChat();

    return (
        <div className="chat-container">

            <MessageList messages={messages} isSending={isSending} />

            {error && <p className="chat-error">{error}</p>}

            <MessageInput onSend={send} isSending={isSending} />

        </div>
    );
}
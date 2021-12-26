
// Message system
const message = {
    saveMessage(text, type) {
        const obj = {
            text: text,
            type: type
        };

        // Saving message in localstorage
        localStorage.setItem('message', JSON.stringify(obj));
    },
    removeMessage() {
        localStorage.removeItem('message');
    },
    checkMessage() {
        const item = localStorage.getItem('message');

        // If message exists in localstorage -> show it
        if (item) {
            const text = JSON.parse(item);
            this.createMessage(text.text, text.type);
            this.removeMessage();
        }

        else return false;
    },
    createMessage(text, type = 'success') {
        const message = document.createElement('div');
        message.classList.add(type + '-message');
        message.innerText = text;
        document.body.appendChild(message);

        // Message destruction
        setTimeout(() => message.remove(), 3000);
    }
}
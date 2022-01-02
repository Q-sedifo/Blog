window.onload = () => {

    // Cheching out messages
    message.checkMessage()

    // Ajax requests
    $('form').submit(function (event) {

        event.preventDefault()

        $.ajax({
            type: this.method,
            url: this.action,
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: () => console.log('Sending...'),
            success: (data) => {
                const response = JSON.parse(data)
                if (response['success']) {
                    message.createMessage(response['message'], response['type'])
                }
                else {
                    message.createMessage(response['message'], response['type'])
                }
            },
            error: () => message.createMessage('Request error', 'error')
        });
    });

}

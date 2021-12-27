window.onload = () => {
    message.checkMessage();
}

// Collect data function
function collectData(form) {
    const data = {};
    const postData = form.querySelectorAll('input, textarea');

    postData.forEach(e => {
        data[e.name] = e.value.trim();
    });

    return data;
}

// Ajax requests
function request(form) {
    const data = collectData(form);

    const btn = form.querySelectorAll('button');
    const reload = form.getAttribute('reload');

    $.ajax({
        url: form.action,
        type: form.method,
        data: data,
        dataType: 'json',
        beforeSend: () => btn.forEach(e => e.disabled = true),
        success: (data) => {
            btn.forEach(e => e.disabled = false);
            if (data['success']) {
                if (reload) {
                    message.saveMessage(data['message'], data['type']);
                    location.reload();
                }
                else {
                    message.createMessage(data['message'], data['type']);
                }
            }
            else {
                message.createMessage(data['message'], data['type']);
            }
        },
        error: () => {
            message.createMessage('Request error', 'error');
        }
    });
}
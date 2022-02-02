// Sending request for mailing unique code for changing password
function sendCode() {
    $.ajax({
        url: '?controller=admin&action=changePassword',
        type: 'GET',
        data: {},
        success: (data) => {
            console.log(data)
        }
    })
}

// Delete post
function deletePost(id) {
    $.ajax({
        url: '?controller=admin&action=deletePost&id=' + id,
        type: 'GET',
        data: {},
        success: (data) => {
            const response = JSON.parse(data)
            message.createMessage(response['message'])
            const post = document.getElementById('post' + id)
            document.getElementById('postCount').innerHTML -= 1
            post.style.display = 'none';
        }
    })
}

// Logs
function getLogs() {
    $.ajax({
        url: '?controller=admin&action=logs',
        type: 'POST',
        data: {},
        success: (data) => {
            logs = JSON.parse(data)
            console.log(logs);
        }
    })
}
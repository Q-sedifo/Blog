window.onload = () => {

    // Cheching out messages
    message.checkMessage()

    // Ajax requests
    $('form').submit(function (event) {

        event.preventDefault()

        const btns = this.querySelectorAll('input, textarea')

        $.ajax({
            type: this.method,
            url: this.action,
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: () => btns.forEach(b => b.disabled = true),
            success: (data) => {
                btns.forEach(b => b.disabled = false)

                const response = JSON.parse(data)

                const text = response['message']
                const type = response['type']
                const success = response['success']
                const href = response['href']

                if (success) {
                    if (href) {
                        message.saveMessage(text, type)
                        location.href = href;
                    }
                    else message.createMessage(text, type)
                }
                else {
                    message.createMessage(text, type)
                }
            },
            error: () => message.createMessage('Request error', 'error')
        });
    });

}

// Ajax loading posts
function loadMorePosts() {
    let loadFrom = Math.ceil(document.querySelectorAll('.post').length / 3 + 1)
    let inProgress = false

    $.ajax({
        url: '?controller=index&action=index',
        type: 'POST',
        data: { "loadFrom": loadFrom },
        beforeSend: () => inProgress = true,
        success: (data) => {
            inProgress = false
            let posts = JSON.parse(data)

            if (posts.length > 0) {
                posts.forEach(e => {
                    let post = document.createElement('div')
                    post.classList.add('post')
                    post.innerHTML = e.title
                    document.getElementById('posts').innerHTML += '<div class="post"><a href="?action=post&id=' + e.id + '">' + e.title + '</a></div>'
                })
            }
            inProgress = false
        }
    })
}
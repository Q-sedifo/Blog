// Sending request for mailing unique code for changing password
function sendCode() {
    const preloader = new Preloader()
    const form = new passChanger()
    $.ajax({
        url: '?controller=admin&action=changePassword',
        type: 'GET',
        data: {},
        beforeSend: () => preloader.run(),
        success: (data) => {
            console.log(data)
            form.show()
            preloader.stop()
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
            document.getElementById('postCount').innerHTML -= 1
        }
    })

    // Animation after delete post
    let deletedPost = document.querySelector('#post' + id)
    let deletedPostHeight = deletedPost.offsetHeight
    deletedPost.style.height = deletedPostHeight + 'px'
    deletedPost.innerHTML = '<div class="deletedPost"><svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16 9v10H8V9h8m-1.5-6h-5l-1 1H5v2h14V4h-3.5l-1-1zM18 7H6v12c0 1.1.9 2 2 2h8c1.1 0 2-.9 2-2V7z"/></svg>Deleted</div>'
}

// Logs
function getLogs() {
    const preloader = new Preloader()
    const logs = new Logs()
    $.ajax({
        url: '?controller=admin&action=logs',
        type: 'POST',
        data: {},
        beforeSend: () => preloader.run(),
        success: (data) => {
            logs.activate(JSON.parse(data))
            preloader.stop()
        }
    })
}

// Admin post search 
function findPostByType() {
    const preloader = new Preloader()
    let property = document.querySelector('.search input').value
    let type = document.querySelector('.search select').value

    if (String(property).length > 0) {
        $.ajax({
            url: '?controller=admin&action=findPostByType',
            type: 'POST',
            data: { property: property, type: type },
            beforeSend: () => preloader.run(),
            success: (data) => {
                let posts = JSON.parse(data)
                posts.forEach(post => {
                    document.querySelector('#foundPosts').innerHTML += '<div id="post' + post.id + '" class="post-card"><div class="post-card-info">Id:<span>#' + post.id + '</span></div><div class="post-card-data">Date:<span>' + post.datatime + '</span></div><div class="post-card-title">' + post.title + '</div><div class="post-card-preview" style="background: linear-gradient(rgba(20, 20, 20, .7) 0%, rgba(0, 0, 0, 0) 40%), url(' + post.mini_preview + ');"></div><div class="post-card-btns-block"><button class="btn"><img src="public/icons/edit.svg"><a href="?controller=admin&action=editPost&id=' + post.id + '"></a></button><button class="btn negative" onclick="deletePost(' + post.id + ')"><img src="public/icons/cancel.svg"></button></div></div>'
                });
                document.querySelector('#postSearcher').value = ''
                preloader.stop()
            }
        })
    }
}
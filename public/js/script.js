window.onload = () => {

    // Initializing classes and variables
    const scroller = new Scroller()
    const menu = new Menu()
    const search = new Search()
    const preloader = new Preloader()

    // Required functions after loaded page
    preloader.stop() // Stop preloader
    message.checkMessage() // Chekhing out messages

    // Functions while scrolling
    window.onscroll = () => {

        // Header animation
        const header = document.querySelector('header')
        if (window.pageYOffset > header.offsetHeight) {
            header.style.background = '#171a26'
        }
        else {
            header.style.background = 'none'
        }

        // Scroller btn 
        scroller.check()

        // Comments loader 
        if (Math.ceil($(window).scrollTop() + $(window).height()) >= $(document).height()) {
            loadMoreComments()
        }
    }

    // Search trigger
    search.btn.onclick = () => {
        if (menu.status === 1) menu.disable()
        search.activate()

        search.closeBtn.onclick = () => {
            search.disable()
        }
    }

    // Menu trigger
    menu.btn.onclick = () => {
        if (search.status === 1) search.disable()
        if (menu.status === 1) {
            menu.disable()
        }
        else menu.activate()
    }

    // Getting logs
    const logsBtn = document.querySelector('#logs-btn')
    if (logsBtn) logsBtn.onclick = () => {
        menu.disable()
        getLogs()
    }

    // Ajax requests
    $('form').submit(function (event) {

        event.preventDefault()

        const btns = this.querySelectorAll('input, textarea, button')

        $.ajax({
            type: this.method,
            url: this.action,
            data: new FormData(this),
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: () => {
                preloader.run()
                btns.forEach(b => b.disabled = true)
            },
            success: (data) => {
                btns.forEach(b => b.disabled = false)
                preloader.stop()

                // Clean form fields
                this.querySelectorAll('input, textarea').forEach(field => field.value = '')

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

// Menu
class Menu {
    constructor() {
        this.popUp = new PopUp()
        this.btn = document.querySelector('#menu-btn')
        this.toolBar = document.querySelector('#menu')
    }
    activate() {
        this.toolBar.classList.add('menu-active')
        this.popUp.push()
        document.body.classList.add('scroll-off')
        this.status = 1
    }
    disable() {
        this.toolBar.classList.remove('menu-active')
        this.popUp.remove()
        document.body.classList.remove('scroll-off')
        this.status = 0
    }
}

// Search
class Search {
    constructor() {
        this.popUp = new PopUp()
        this.btn = document.querySelector('#search-btn')
        this.block = document.querySelector('#search')
    }
    activate() {
        this.btn.classList.add('hide')
        this.block.classList.add('show')
        this.popUp.push()
        document.body.classList.add('scroll-off')
        this.closeBtn = document.querySelector('#close-search')
        this.field = document.querySelector('#search input')
        this.status = 1
    }
    disable() {
        this.block.classList.remove('show')
        this.btn.classList.remove('hide')
        this.popUp.remove()
        document.body.classList.remove('scroll-off')
        this.status = 0
        this.cleanField()
        $('.find-field').html('')
    }
    cleanField() {
        this.field.value = ''
    }
}

// Scroll up
class Scroller {
    static distance = 800
    constructor() {
        this.btn = document.getElementById('btn-up')
        this.btn.onclick = () => this.toUp()
    }
    check() {
        if (window.pageYOffset > Scroller.distance) {
            this.btn.classList.add('show')
        }
        else {
            this.btn.classList.remove('show')
        }
    }
    toUp() {
        window.scrollTo(0, 0)
    }
}

// Preloader
class Preloader {
    constructor() {
        this.preloader = document.getElementById('preloader')
        this.status = 0
    }
    run() {
        this.preloader.classList.add('run-preloader')
        this.status = 1
    }
    stop() {
        this.preloader.classList.remove('run-preloader')
        this.status = 0
    }
}

// Pop-up
class PopUp {
    #id = 'pop-up'
    push() {
        const popUp = document.createElement('div')
        popUp.classList.add('pop-up')
        this.#id += document.querySelectorAll('.pop-up').length + 1
        popUp.id = this.#id
        document.body.appendChild(popUp)
        this.status = 1
    }
    remove() {
        document.querySelector('#' + this.#id).remove()
        this.#id = 'pop-up'
        this.status = 0
    }
    toggle() {
        if (this.status != 1) {
            this.push()
        }
        else {
            this.remove()
        }
    }
}

// Getting logs
class Logs {
    constructor() {
        this.block = document.querySelector('#logs')
        this.logsList = document.querySelector('.logs-list')

        this.block.querySelector('.close').onclick = () => this.disable()
    }
    activate(logs) {
        this.block.classList.add('show')
        logs.forEach(log => this.logsList.innerHTML += '<div>' + log + '</div>')
        document.body.classList.add('scroll-off')
    }
    disable() {
        this.block.classList.remove('show')
        document.body.classList.remove('scroll-off')
    }
}

// Changing password form
class passChanger {
    constructor() {
        this.form = document.querySelector('#changing-password-block')
        this.closeBtn = this.form.querySelector('.close')

        this.closeBtn.onclick = () => this.hide()
    }
    show() {
        this.form.classList.add('show')
        document.body.classList.add('scroll-off')
    }
    hide() {
        this.form.classList.remove('show')
        document.body.classList.remove('scroll-off')
    }
}

// Ajax loading posts
function loadMorePosts(btn) {
    const loadFrom = Math.ceil(document.querySelectorAll('#posts .post-card').length / 3 + 1)
    const preloader = new Preloader()

    $.ajax({
        url: '?controller=index&action=index',
        type: 'POST',
        data: { "loadFrom": loadFrom },
        beforeSend: () => {
            btn.disabled = true
            preloader.run()
        },
        success: (data) => {
            const posts = JSON.parse(data)
            btn.disabled = false

            if (posts.length > 0) {
                posts.forEach(e => {
                    let post = document.createElement('div')
                    post.classList.add('post')
                    post.innerHTML = e.title
                    document.getElementById('posts').innerHTML += '<div class="post-card"><div class="card-title">' + e.title + '</div><div class="card-preview" style="background: linear-gradient(rgba(20, 20, 20, .7) 0%, rgba(0, 0, 0, 0) 40%), url(' + e.mini_preview + ');"></div><div class="card-date">' + e.datatime + '</div><a href="?action=post&id=' + e.id + '"></a></div>'
                })
            } else message.createMessage('No available posts', 'warning');
            preloader.stop()
        }
    })
}

// Ajax loading comments
function loadMoreComments() {
    if (document.querySelector('.comments-list')) {
        const loadFrom = Math.ceil(document.querySelectorAll('.comments-list .comment').length / 5 + 1)
        const postId = document.querySelector('#postId').innerHTML
        const preloader = new Preloader()

        $.ajax({
            url: '?controller=index&action=post&loadMoreComments',
            type: 'GET',
            data: { "postId": postId, "loadFrom": loadFrom },
            beforeSend: () => {
                preloader.run()
                inProgress = true
            },
            success: (data) => {
                const comments = JSON.parse(data)
                comments.forEach(comment => {
                    document.querySelector('.comments-list').innerHTML += '<div id="comment#' + comment.id + '" class="comment"><div class="comment-info"><div><div class="comment-image"><img src="public/icons/user.svg"></div>' + comment.name + '</div><?php if (isset($_SESSION[\'admin\'])): ?><button class="btn negative"><a href="?controller=admin&action=&commentId=' + comment.id + '"></a>&times</button><?php endif; ?></div><div class="comment-text">' + comment.text + '</div>'
                })
                preloader.stop()
            }
        })
    }
}

// Posts serach
function searchPosts(text) {
    if (text != '') {
        const preloader = new Preloader()

        $.ajax({
            url: '?controller=index&action=postSearch',
            type: 'POST',
            data: { "title": text.trim() },
            beforeSend: () => preloader.run(),
            success: (data) => {
                let foundPosts = JSON.parse(data)

                if (foundPosts.length > 0) {
                    foundPosts.forEach(e => {
                        document.querySelector('.find-field').innerHTML += '<div class="post"><a href="?action=post&id=' + e.id + '"></a><div class="post-preview" style="background: url(' + e.mini_preview + ')"></div><div class="post-title">' + e.title.slice(0, 32) + '</div></div>'
                    })
                }
                else $('.find-field').html('<div class="message">Nothing found</div>')
                preloader.stop()
            }
        })
    }
    // Clear field
    $('.find-field').html('')
}
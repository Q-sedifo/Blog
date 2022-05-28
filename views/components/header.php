<!-- Header -->
<header>
    <div class="container">
        <!-- Account -->
        <div class="acc">
            <img src="<?php if (isset($_SESSION['admin'])): ?><?= $_SESSION['admin']['ava'] ?><?php else: ?>public/icons/user.svg<?php endif; ?>">
            <!-- Preloader -->
            <div id="preloader" class="run-preloader"></div>
        </div>
        <!-- Search -->
        <div id="search">
            <input type="text" placeholder="Search" oninput="searchPosts(this.value)">
            <img id="close-search" src="public/icons/cancel.svg">
            <div class="find-field"></div>
        </div>
        <!-- Btns container -->
        <div>
            <!-- Search btn -->
            <div id="search-btn"><img src="public/icons/search.svg"></div>
            <!-- Menu-btn -->
            <div id="menu-btn"><img src="public/icons/menu.svg"></div>
        </div>
    </div>
</header>
<!-- Arrow up -->
<div id="btn-up"><img src="public/icons/arrow-up.svg"></div>
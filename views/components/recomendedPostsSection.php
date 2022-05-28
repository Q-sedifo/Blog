<!-- Recomended posts section -->
<div class="recomended-posts-section">
    <div class="title">Recomended posts<img src="public/icons/star.svg"></div>
    <div class="slider">
        <button onclick="moveSliderPrev()">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none" opacity=".87"/><path d="M17.51 3.87L15.73 2.1 5.84 12l9.9 9.9 1.77-1.77L9.38 12l8.13-8.13z"/></svg>
        </button>
        <div class="slider-window">
            <button class="left-btn" onclick="moveSliderPrev()">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"><path d="M0 0h24v24H0V0z" fill="none" opacity=".87"/><path d="M17.51 3.87L15.73 2.1 5.84 12l9.9 9.9 1.77-1.77L9.38 12l8.13-8.13z"/></svg>
            </button>
            <button class="right-btn" onclick="moveSliderNext()">
                <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><g><path d="M0,0h24v24H0V0z" fill="none"/></g><g><polygon points="6.23,20.23 8,22 18,12 8,2 6.23,3.77 14.46,12"/></g></svg>            
            </button>
            <div class="track">
                <?php foreach ($recomendedPosts as $post): ?>
                    <div class="post-card slider-element" style="background-image: url(<?= $post['mini_preview']; ?>)">
                        <div class="card-title"><?= $post['title']; ?></div>
                        <a href="?action=post&id=<?= $post['id']; ?>"></a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
        <button onclick="moveSliderNext()">
            <svg xmlns="http://www.w3.org/2000/svg" enable-background="new 0 0 24 24" viewBox="0 0 24 24"><g><path d="M0,0h24v24H0V0z" fill="none"/></g><g><polygon points="6.23,20.23 8,22 18,12 8,2 6.23,3.77 14.46,12"/></g></svg>            
        </button>
    </div>
    <div class="slider-pagination">
        <?php foreach ($recomendedPosts as $position): ?>
            <div></div>
        <?php endforeach; ?>
    </div>
</div>
<!-- Slider js -->
<script src="public/js/slider.js"></script>